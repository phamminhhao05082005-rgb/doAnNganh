<?php

namespace App\Services;

use App\Models\Application;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiEvaluationService
{
    public function evaluateApplication(Application $application): array
    {
        $job = $application->job;
        $cv  = $application->cv;

        // =========================================================
        // 1. CHUẨN BỊ THÔNG TIN YÊU CẦU CÔNG VIỆC
        // =========================================================

        $skillsRequired = $job->skills
            ? $job->skills->pluck('name')->implode(', ')
            : 'Không có';

        $jobInfo = "
Tiêu đề: {$job->title}
Mô tả công việc: {$job->description}
Yêu cầu công việc: {$job->requirement}
Yêu cầu kinh nghiệm: {$job->experience} năm
Kỹ năng yêu cầu: {$skillsRequired}
";

        // =========================================================
        // 2. CHUẨN BỊ THÔNG TIN CV ỨNG VIÊN
        // =========================================================

        $educations = $cv->educations
            ? $cv->educations->map(function ($edu) {
                return "- Trường: {$edu->school_name}, 
Chuyên ngành: {$edu->major}, 
Bằng cấp: {$edu->degree}, 
GPA: {$edu->gpa}";
            })->implode("\n")
            : 'Không có';

        $experiences = $cv->experiences
            ? $cv->experiences->map(function ($exp) {
                return "- Công ty: {$exp->company_name}, 
Vị trí: {$exp->position}, 
Mô tả: {$exp->description}";
            })->implode("\n")
            : 'Không có';

        $cvInfo = "
Họ tên: {$cv->full_name}
Vị trí ứng tuyển mong muốn: {$cv->job_title}
Số năm kinh nghiệm: {$cv->experience_year}
Tóm tắt bản thân: {$cv->summary}

Học vấn:
{$educations}

Kinh nghiệm làm việc:
{$experiences}
";

        // =========================================================
        // 3. CHUẨN BỊ PROMPT
        // =========================================================

        $prompt = "
Bạn là một chuyên gia tuyển dụng (HR Specialist) cao cấp.

Hãy đánh giá mức độ phù hợp của CV Ứng viên đối với Yêu cầu công việc dưới đây.

--- THÔNG TIN CÔNG VIỆC ---
{$jobInfo}

--- THÔNG TIN CV ỨNG VIÊN ---
{$cvInfo}

--- YÊU CẦU ĐẦU RA ---

Hãy phân tích cẩn thận và trả về KẾT QUẢ DUY NHẤT ở dạng chuỗi JSON thuần.

KHÔNG kèm markdown.
KHÔNG kèm ```json.
KHÔNG thêm bất kỳ nội dung nào bên ngoài JSON.

Cấu trúc chính xác:

{
    \"match_percentage\": <số nguyên từ 0 đến 100 thể hiện mức độ phù hợp>,
    \"strengths\": [
        <mảng các chuỗi liệt kê điểm mạnh của ứng viên so với JD>
    ],
    \"weaknesses\": [
        <mảng các chuỗi liệt kê điểm yếu hoặc kỹ năng còn thiếu>
    ],
    \"summary\": \"<nhận xét tổng quan ngắn gọn từ 2-3 câu>\"
}
";

        // =========================================================
        // 4. LẤY GEMINI API KEY
        // =========================================================

        $apiKey = env('GEMINI_API_KEY');

        if (empty($apiKey)) {
            Log::error('Gemini API Key không tồn tại hoặc bị rỗng.');

            return $this->fallbackResponse(
                'Chưa cấu hình GEMINI_API_KEY trong hệ thống.'
            );
        }

        // =========================================================
        // 5. LẤY DANH SÁCH MODEL TỪ GOOGLE GEMINI API
        //    Giống flow /test-gemini đang chạy thành công
        // =========================================================

        $listUrl =
            "https://generativelanguage.googleapis.com/v1beta/models?key={$apiKey}";

        try {
            $listResponse = Http::get($listUrl);
        } catch (\Exception $e) {
            Log::error(
                "Lỗi kết nối Gemini khi lấy danh sách model: "
                . $e->getMessage()
            );

            return $this->fallbackResponse(
                'Không thể kết nối đến Gemini API.'
            );
        }

        if ($listResponse->failed()) {
            Log::error(
                "Lỗi lấy danh sách Models từ Gemini: "
                . json_encode($listResponse->json())
            );

            return $this->fallbackResponse(
                'Không thể lấy danh sách model từ Gemini.'
            );
        }

        $models = $listResponse->json('models', []);

        // =========================================================
        // 6. CHỌN MODEL
        // =========================================================

        $selectedModel = null;

        $preferredModels = [
            'models/gemini-3.6-flash',
            'models/gemini-3-flash',
            'models/gemini-1.5-flash',
            'models/gemini-1.5-pro',
        ];

        // Ưu tiên các model mong muốn
        foreach ($preferredModels as $pref) {
            foreach ($models as $model) {

                if (
                    ($model['name'] ?? '') === $pref
                    &&
                    in_array(
                        'generateContent',
                        $model['supportedGenerationMethods'] ?? []
                    )
                ) {
                    $selectedModel = $model['name'];
                    break 2;
                }
            }
        }

        // =========================================================
        // 7. FALLBACK: TÌM BẤT KỲ MODEL GEMINI NÀO
        //    CÓ generateContent
        // =========================================================

        if (!$selectedModel) {

            foreach ($models as $model) {

                $name = $model['name'] ?? '';

                $methods =
                    $model['supportedGenerationMethods'] ?? [];

                if (
                    str_contains($name, 'gemini')
                    &&
                    !str_contains($name, 'deep-research')
                    &&
                    in_array('generateContent', $methods)
                ) {
                    $selectedModel = $name;
                    break;
                }
            }
        }

        // =========================================================
        // 8. KHÔNG TÌM THẤY MODEL
        // =========================================================

        if (!$selectedModel) {

            Log::error(
                'Không tìm thấy model Gemini hỗ trợ generateContent.',
                [
                    'available_models' => array_column(
                        $models,
                        'name'
                    )
                ]
            );

            return $this->fallbackResponse(
                'Không tìm thấy model Gemini phù hợp.'
            );
        }

        // =========================================================
        // 9. GỌI GEMINI generateContent
        // =========================================================

        $generateUrl =
            "https://generativelanguage.googleapis.com/v1beta/"
            . "{$selectedModel}:generateContent?key={$apiKey}";

        try {

            $response = Http::timeout(60)
                ->post($generateUrl, [
                    'contents' => [
                        [
                            'parts' => [
                                [
                                    'text' => $prompt
                                ]
                            ]
                        ]
                    ]
                ]);

        } catch (\Exception $e) {

            Log::error(
                "Lỗi khi gọi Gemini API cho Application ID "
                . "{$application->id}: "
                . $e->getMessage()
            );

            return $this->fallbackResponse(
                'Lỗi kết nối đến Gemini API.'
            );
        }

        // =========================================================
        // 10. XỬ LÝ RESPONSE
        // =========================================================

        if (!$response->successful()) {

            Log::error(
                "Gemini API Error [{$selectedModel}]: "
                . json_encode($response->json())
            );

            return $this->fallbackResponse(
                'Gemini API trả về lỗi.'
            );
        }

        // Lấy text Gemini trả về
        $rawText = $response->json(
            'candidates.0.content.parts.0.text'
        );

        if (empty($rawText)) {

            Log::error(
                "Gemini không trả về nội dung cho Application ID "
                . $application->id,
                [
                    'response' => $response->json()
                ]
            );

            return $this->fallbackResponse(
                'Gemini không trả về kết quả đánh giá.'
            );
        }

        // =========================================================
        // 11. LÀM SẠCH JSON
        // =========================================================

        $cleanJson = trim($rawText);

        // Xóa ```json ... ```
        $cleanJson = preg_replace(
            '/^```json\s*/i',
            '',
            $cleanJson
        );

        $cleanJson = preg_replace(
            '/^```\s*/i',
            '',
            $cleanJson
        );

        $cleanJson = preg_replace(
            '/\s*```$/',
            '',
            $cleanJson
        );

        $cleanJson = trim($cleanJson);

        // =========================================================
        // 12. DECODE JSON
        // =========================================================

        $data = json_decode(
            $cleanJson,
            true
        );

        if (
            json_last_error() === JSON_ERROR_NONE
            &&
            isset($data['match_percentage'])
        ) {

            return [
                'score' => max(
                    0,
                    min(
                        100,
                        (int) $data['match_percentage']
                    )
                ),

                'evaluation' => [
                    'strengths' => $data['strengths'] ?? [],

                    'weaknesses' => $data['weaknesses'] ?? [],

                    'summary' => $data['summary'] ?? '',
                ]
            ];
        }

        // =========================================================
        // 13. JSON KHÔNG HỢP LỆ
        // =========================================================

        Log::error(
            "Gemini trả về JSON không hợp lệ cho Application ID "
            . $application->id,
            [
                'raw_response' => $rawText,
                'clean_json' => $cleanJson,
                'json_error' => json_last_error_msg(),
            ]
        );

        return $this->fallbackResponse(
            'Gemini trả về dữ liệu không đúng định dạng JSON.'
        );
    }

    // =============================================================
    // FALLBACK RESPONSE
    // =============================================================

    private function fallbackResponse(string $message): array
    {
        return [
            'score' => 0,

            'evaluation' => [
                'strengths' => [],

                'weaknesses' => [
                    $message
                ],

                'summary' =>
                    'Không thể thực hiện đánh giá tự động.'
            ]
        ];
    }
}