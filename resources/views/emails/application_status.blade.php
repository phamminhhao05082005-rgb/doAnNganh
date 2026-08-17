<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; line-height: 1.6; color: #333333; background-color: #f4f6f9; margin: 0; padding: 0; }
        .wrapper { width: 100%; background-color: #f4f6f9; padding: 30px 0; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); }
        .header { background: linear-gradient(135deg, #0d6efd, #0b5ed7); color: #ffffff; padding: 25px 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 20px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .body { padding: 30px 25px; }
        .greeting { font-size: 16px; margin-bottom: 15px; }
        .status-badge { display: inline-block; padding: 8px 16px; border-radius: 50px; font-weight: bold; font-size: 14px; text-transform: uppercase; margin: 10px 0; }
        .status-accepted { background-color: #d1e7dd; color: #0f5132; }
        .status-rejected { background-color: #f8d7da; color: #842029; }
        .status-default { background-color: #cff4fc; color: #055160; }
        .details-box { background-color: #f8f9fa; border-left: 4px solid #0d6efd; padding: 15px; border-radius: 4px; margin: 20px 0; }
        .details-box p { margin: 5px 0; font-size: 14px; }
        .footer { background-color: #f8f9fa; padding: 20px; font-size: 12px; color: #6c757d; text-align: center; border-top: 1px solid #e9ecef; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <h1>Thông Báo Cập Nhật Hồ Sơ</h1>
            </div>
            
            <div class="body">
                <p class="greeting">Xin chào <strong>{{ $application->cv->user->name ?? 'Ứng viên' }}</strong>,</p>
                
                <p>Cảm ơn bạn đã ứng tuyển tại <strong>{{ $application->job->company->name ?? 'Công ty' }}</strong>. Trạng thái hồ sơ ứng tuyển của bạn đã được thay đổi:</p>
                
                <div class="details-box">
                    <p><strong>Vị trí ứng tuyển:</strong> {{ $application->job->title ?? 'N/A' }}</p>
                    <p><strong>Trạng thái:</strong> 
                        @php $status = strtoupper($application->status); @endphp
                        @if($status === 'ACCEPTED')
                            <span class="status-badge status-accepted">Đã duyệt</span>
                        @elseif($status === 'REJECTED')
                            <span class="status-badge status-rejected">Từ chối</span>
                        @else
                            <span class="status-badge status-default">{{ $status }}</span>
                        @endif
                    </p>
                </div>

                @if($status === 'ACCEPTED')
                    <p>🎉 <strong>Chúc mừng!</strong> Hồ sơ của bạn đã được nhà tuyển dụng chấp nhận. Bộ phận tuyển dụng sẽ sớm liên hệ trực tiếp với bạn qua email/số điện thoại để trao đổi các bước tiếp theo.</p>
                @elseif($status === 'REJECTED')
                    <p>Rất tiếc, nhà tuyển dụng cảm thấy hồ sơ của bạn chưa phù hợp với vị trí hiện tại. Chúc bạn luôn giữ vững ngọn lửa đam mê và sớm tìm được công việc ưng ý.</p>
                @else
                    <p>Hồ sơ của bạn đang trong quá trình xem xét kỹ lưỡng. Chúng tôi sẽ cập nhật đến bạn ngay khi có thông tin mới nhất.</p>
                @endif

                <p style="margin-top: 30px;">Trân trọng,<br><strong>Đội ngũ Tuyển dụng</strong></p>
            </div>

            <div class="footer">
                <p>Đây là email tự động từ hệ thống. Vui lòng không phản hồi lại email này.</p>
            </div>
        </div>
    </div>
</body>
</html>