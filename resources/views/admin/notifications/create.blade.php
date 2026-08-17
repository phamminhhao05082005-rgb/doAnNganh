@extends('layouts.admin')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Gửi Thông Báo Realtime Đến Người Dùng</h5>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.notifications.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="role" class="form-label font-weight-bold">Đối tượng nhận thông báo</label>
                <select name="role" id="role" class="form-select">
                    <option value="">-- Tất cả người dùng (Sinh viên & Doanh nghiệp) --</option>
                    <option value="STUDENT" {{ old('role') == 'STUDENT' ? 'selected' : '' }}>Chỉ Sinh viên (STUDENT)</option>
                    <option value="EMPLOYER" {{ old('role') == 'EMPLOYER' ? 'selected' : '' }}>Chỉ Doanh nghiệp (EMPLOYER)</option>
                </select>
                <div class="form-text">Chọn đối tượng cụ thể hoặc để mặc định để gửi toàn hệ thống.</div>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label font-weight-bold">Tiêu đề thông báo <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Nhập tiêu đề thông báo..." value="{{ old('title') }}" required>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label font-weight-bold">Nội dung thông báo <span class="text-danger">*</span></label>
                <textarea name="content" id="content" rows="5" class="form-control" placeholder="Nhập nội dung thông báo chi tiết..." required>{{ old('content') }}</textarea>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary px-4" onclick="return confirm('Xác nhận gửi thông báo này đến người dùng?')">
                    <i class="bi bi-send-fill me-1"></i> Bắn thông báo ngay
                </button>
            </div>
        </form>
    </div>
</div>
@endsection