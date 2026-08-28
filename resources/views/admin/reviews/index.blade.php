@extends('layouts.admin')

@section('content')
<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-bold fs-5">Quản lý Đánh giá Doanh nghiệp</span>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.reviews.index') }}" method="GET" class="mb-4">
            <div class="row align-items-end">
                <div class="col-md-5">
                    <label for="company_id" class="form-label text-muted fw-bold">Lọc theo Công ty:</label>
                    <select name="company_id" id="company_id" class="form-select">
                        <option value="">-- Tất cả công ty --</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel"></i> Lọc</button>
                </div>
                @if(request()->filled('company_id'))
                    <div class="col-md-2">
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary w-100">Xóa lọc</a>
                    </div>
                @endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">ID</th>
                        <th width="15%">Sinh viên</th>
                        <th width="20%">Công ty</th>
                        <th width="15%">Đánh giá</th>
                        <th width="30%">Nội dung (Comment)</th>
                        <th width="10%">Ngày tạo</th>
                        <th width="5%">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr>
                            <td>{{ $review->id }}</td>
                            <td class="fw-bold">{{ $review->user->full_name ?? 'Không xác định' }}</td>
                            <td>{{ $review->company->name ?? 'Công ty đã xóa' }}</td>
                            <td>
                                <span class="text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                    @endfor
                                </span>
                                <span class="ms-1 fw-bold">({{ $review->rating }})</span>
                            </td>
                            <td>{{ $review->comment }}</td>
                            <td>{{ $review->created_at->format('d/m/Y') }}</td>
                            <td>
                                
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xoá đánh giá này? Hành động này không thể hoàn tác.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Xóa đánh giá">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Chưa có đánh giá nào trong hệ thống.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $reviews->appends(request()->query())->links() }}
        </div>

    </div>
</div>
@endsection