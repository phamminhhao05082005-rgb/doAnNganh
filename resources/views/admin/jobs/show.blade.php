@extends('layouts.admin')

@section('content')
<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Chi tiết Tin tuyển dụng #{{ $job->id }}</h5>
        <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success mb-3">{{ session('success') }}</div>
        @endif

        <div class="row">
            <div class="col-md-8">
                <h3>{{ $job->title }}</h3>
                <p class="text-muted">
                    <i class="bi bi-building"></i> <strong>Doanh nghiệp:</strong> {{ $job->company->name ?? 'N/A' }} | 
                    <i class="bi bi-geo-alt"></i> <strong>Địa điểm:</strong> {{ $job->location }}
                </p>
                <hr>
                
                <h5>Mô tả công việc</h5>
                <div class="p-3 bg-light rounded mb-3">
                    {!! nl2br(e($job->description)) !!}
                </div>

                <h5>Yêu cầu ứng viên</h5>
                <div class="p-3 bg-light rounded mb-3">
                    {!! nl2br(e($job->requirement)) !!}
                </div>

                <h5>Kỹ năng yêu cầu</h5>
                <div class="mb-3">
                    @forelse($job->skills as $skill)
                        <span class="badge bg-info text-dark me-1">{{ $skill->name }}</span>
                    @empty
                        <span class="text-muted">Không có kỹ năng yêu cầu đặc biệt</span>
                    @endforelse
                </div>
            </div>

            <div class="col-md-4">
                <div class="border p-3 rounded bg-light">
                    <h5 class="border-bottom pb-2">Thông tin chung</h5>
                    
                    <p><strong>Danh mục:</strong> {{ $job->category->name ?? 'N/A' }}</p>
                    <p><strong>Mức lương:</strong> 
                        @if($job->salary_min || $job->salary_max)
                            {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }} VNĐ
                        @else
                            Thỏa thuận
                        @endif
                    </p>
                    <p><strong>Kinh nghiệm:</strong> {{ $job->experience ?? 'Không yêu cầu' }}</p>
                    <p><strong>Hạn nộp hồ sơ:</strong> {{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('d/m/Y') : 'N/A' }}</p>
                    <p><strong>Trạng thái:</strong> 
                        @if($job->status)
                            <span class="badge bg-success">Đang hoạt động (Mở)</span>
                        @else
                            <span class="badge bg-danger">Đã khóa (Tạm đóng)</span>
                        @endif
                    </p>

                    <hr>

                    {{-- Nút Đóng / Mở trực tiếp tại trang chi tiết --}}
                    <div class="d-grid gap-2">
                        @if($job->status)
                            <form action="{{ route('admin.jobs.toggle-status', $job->id) }}" method="POST" onsubmit="return confirm('Xác nhận tạm đóng tin tuyển dụng này?')">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="0">
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="bi bi-lock"></i> Tạm đóng tin tuyển dụng
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.jobs.toggle-status', $job->id) }}" method="POST" onsubmit="return confirm('Xác nhận mở lại tin tuyển dụng này?')">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="1">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-unlock"></i> Mở lại tin tuyển dụng
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection