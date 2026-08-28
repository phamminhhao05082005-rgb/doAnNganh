<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployerStatisticResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        
        return [
            'success' => true,
            'message' => 'Lấy dữ liệu thống kê thành công',
            'data' => [
                'year' => $this->resource['year'],
                'summary' => $this->resource['summary'],
                'charts' => [
                    'monthly_trends' => $this->resource['line_chart'],
                    'job_categories' => $this->resource['pie_chart_categories'],
                ]
            ]
        ];
    }
}