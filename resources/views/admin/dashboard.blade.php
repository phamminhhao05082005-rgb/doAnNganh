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

        <a href="{{ route('admin.companies.index') }}"
            class="btn btn-primary">

            <i class="bi bi-buildings"></i>

            Quản lý doanh nghiệp

        </a>

    </div>

</div>

@endsection