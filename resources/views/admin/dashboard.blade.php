@extends('layouts.admin')

@section('content')

<div class="card shadow">

    <div class="card-header d-flex justify-content-between align-items-center">

        <span class="fw-bold fs-5">Dashboard</span>

        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-box-arrow-right"></i>
                Đăng xuất
            </button>
        </form>

    </div>

    <div class="card-body">

        <h3>
            Xin chào Admin
        </h3>

        <p class="text-muted">
            Chào mừng bạn đến hệ thống quản trị tuyển dụng.
        </p>

        <hr>

        <h5 class="mb-3"><i class="bi bi-lightning-charge-fill text-warning"></i> Truy cập nhanh</h5>

        <!-- Bổ sung đầy đủ các nút tương ứng với Sidebar -->
        <div class="row g-3">

            <!-- Thống kê hệ thống (Mới thêm) -->
            <div class="col-md-4 col-sm-6">
                <a href="{{ route('admin.analytics.index') }}" class="btn btn-secondary w-100 p-3 text-start shadow-sm">
                    <i class="bi bi-graph-up-arrow fs-4 me-2"></i>
                    <span class="fw-bold">Thống kê hệ thống</span>
                </a>
            </div>

            <!-- Quản lý doanh nghiệp -->
            <div class="col-md-4 col-sm-6">
                <a href="{{ route('admin.companies.index') }}" class="btn btn-primary w-100 p-3 text-start shadow-sm">
                    <i class="bi bi-buildings fs-4 me-2"></i>
                    <span class="fw-bold">Quản lý doanh nghiệp</span>
                </a>
            </div>

            <!-- Quản lý tin tuyển dụng -->
            <div class="col-md-4 col-sm-6">
                <a href="{{ route('admin.jobs.index') }}" class="btn btn-warning text-dark w-100 p-3 text-start shadow-sm">
                    <i class="bi bi-briefcase fs-4 me-2"></i>
                    <span class="fw-bold">Quản lý tuyển dụng</span>
                </a>
            </div>

            <!-- Quản lý danh mục -->
            <div class="col-md-4 col-sm-6">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-success w-100 p-3 text-start shadow-sm">
                    <i class="bi bi-tags fs-4 me-2"></i>
                    <span class="fw-bold">Quản lý danh mục</span>
                </a>
            </div>

            <!-- Quản lý kỹ năng -->
            <div class="col-md-4 col-sm-6">
                <a href="{{ route('admin.skills.index') }}" class="btn btn-info text-white w-100 p-3 text-start shadow-sm">
                    <i class="bi bi-award fs-4 me-2"></i>
                    <span class="fw-bold">Quản lý kỹ năng</span>
                </a>
            </div>

            <!-- Gửi thông báo hệ thống -->
            <div class="col-md-4 col-sm-6">
                <a href="{{ route('admin.notifications.create') }}" class="btn text-white w-100 p-3 text-start shadow-sm" style="background-color: #6f42c1;">
                    <i class="bi bi-bell-fill fs-4 me-2"></i>
                    <span class="fw-bold">Gửi thông báo Hệ thống</span>
                </a>
            </div>

        </div>

    </div>

</div>

@endsection