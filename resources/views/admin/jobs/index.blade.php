@extends('layouts.admin')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Quản lý Tin Tuyển Dụng</h5>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Form tìm kiếm --}}
        <form method="GET" action="{{ route('admin.jobs.index') }}" class="row g-2 mb-3">
            <div class="col-md-4">
                <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tiêu đề, công ty..." value="{{ request('keyword') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Lọc
                </button>
            </div>
        </form>

        {{-- Bảng danh sách --}}
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th width="60">ID</th>
                    <th>Tiêu đề tin</th>
                    <th>Doanh nghiệp</th>
                    <th>Danh mục</th>
                    <th>Hạn nộp</th>
                    <th width="130" class="text-center">Trạng thái</th>
                    <th width="200" class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                <tr>
                    <td>{{ $job->id }}</td>
                    <td><strong>{{ $job->title }}</strong></td>
                    <td>{{ $job->company->name ?? 'N/A' }}</td>
                    <td><span class="badge bg-secondary">{{ $job->category->name ?? 'N/A' }}</span></td>
                    <td>{{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('d/m/Y') : 'N/A' }}</td>
                    <td class="text-center">
                        @if($job->status)
                            <span class="badge bg-success">Đang mở</span>
                        @else
                            <span class="badge bg-danger">Tạm đóng</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.jobs.show', $job->id) }}" class="btn btn-info btn-sm text-white me-1">
                            Chi tiết
                        </a>

                        @if($job->status)
                            <form action="{{ route('admin.jobs.toggle-status', $job->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn tạm đóng tin này?')">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="0">
                                <button type="submit" class="btn btn-warning btn-sm">
                                    Đóng
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.jobs.toggle-status', $job->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn mở lại tin này?')">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="1">
                                <button type="submit" class="btn btn-success btn-sm">
                                    Mở
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Không tìm thấy tin tuyển dụng nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Thanh Phân Trang Style Spring Boot Mẫu --}}
        @if($jobs->hasPages())
        <div class="d-flex justify-content-center align-items-center mt-3">
            {{-- Nút Prev --}}
            @if ($jobs->onFirstPage())
                <button class="btn btn-outline-secondary me-2" disabled>Prev</button>
            @else
                <a href="{{ $jobs->previousPageUrl() }}" class="btn btn-outline-primary me-2">Prev</a>
            @endif

            {{-- Thông tin Trang hiện tại --}}
            <span class="btn btn-primary disabled" style="opacity: 1;">
                Page {{ $jobs->currentPage() }} / {{ $jobs->lastPage() }}
            </span>

            {{-- Nút Next --}}
            @if ($jobs->hasMorePages())
                <a href="{{ $jobs->nextPageUrl() }}" class="btn btn-outline-primary ms-2">Next</a>
            @else
                <button class="btn btn-outline-secondary ms-2" disabled>Next</button>
            @endif
        </div>
        @endif

    </div>
</div>
@endsection