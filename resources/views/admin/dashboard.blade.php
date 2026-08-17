@extends('layouts.admin')

@section('content')

<div class="card shadow">

    <div class="card-header d-flex justify-content-between align-items-center">

        <span>Dashboard</span>

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

        <p>
            Chào mừng bạn đến hệ thống quản trị.
        </p>

        <hr>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.companies.index') }}" class="btn btn-primary">
                <i class="bi bi-buildings"></i> Quản lý doanh nghiệp
            </a>

            <a href="{{ route('admin.jobs.index') }}" class="btn btn-warning text-dark">
                <i class="bi bi-briefcase"></i> Quản lý tuyển dụng
            </a>

            <a href="{{ route('admin.categories.index') }}" class="btn btn-success">
                <i class="bi bi-tags"></i> Quản lý danh mục
            </a>

            <a href="{{ route('admin.skills.index') }}" class="btn btn-info text-white">
                <i class="bi bi-award"></i> Quản lý kỹ năng
            </a>

            <a href="{{ route('admin.notifications.create') }}" class="btn btn-purple text-white" style="background-color: #6f42c1;">
                <i class="bi bi-bell"></i> Gửi thông báo hệ thống
            </a>
        </div>

    </div>

</div>

@endsection