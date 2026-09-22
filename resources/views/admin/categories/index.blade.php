@extends('layouts.admin')

@section('content')
<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Quản lý danh mục</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="bi bi-plus-lg"></i> Thêm mới
        </button>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Form tìm kiếm --}}
        <form method="GET" action="{{ route('admin.categories.index') }}" class="row g-2 mb-3">
            <div class="col-md-4">
                <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên danh mục..." value="{{ request('keyword') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Lọc
                </button>
            </div>
        </form>

        <table class="table table-bordered table-hover align-middle">
            <thead>
                <tr>
                    <th width="80">ID</th>
                    <th>Tên danh mục</th>
                    <th width="180" class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $category->id }}">
                            <i class="bi bi-pencil"></i> Sửa
                        </button>
                        
                    </td>
                </tr>

                <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header"><h5 class="modal-title">Sửa danh mục</h5></div>
                                <div class="modal-body">
                                    <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">Không tìm thấy danh mục nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Thanh Phân Trang --}}
        @if($categories->hasPages())
        <div class="d-flex justify-content-center align-items-center mt-3">
            {{-- Nút Prev --}}
            @if ($categories->onFirstPage())
                <button class="btn btn-outline-secondary me-2" disabled>Prev</button>
            @else
                <a href="{{ $categories->appends(request()->query())->previousPageUrl() }}" class="btn btn-outline-primary me-2">Prev</a>
            @endif

            {{-- Thông tin Trang hiện tại --}}
            <span class="btn btn-primary disabled" style="opacity: 1;">
                Page {{ $categories->currentPage() }} / {{ $categories->lastPage() }}
            </span>

            {{-- Nút Next --}}
            @if ($categories->hasMorePages())
                <a href="{{ $categories->appends(request()->query())->nextPageUrl() }}" class="btn btn-outline-primary ms-2">Next</a>
            @else
                <button class="btn btn-outline-secondary ms-2" disabled>Next</button>
            @endif
        </div>
        @endif

    </div>
</div>

<!-- Modal Thêm mới -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Thêm danh mục mới</h5></div>
                <div class="modal-body">
                    <input type="text" name="name" class="form-control" placeholder="Tên danh mục..." required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Tạo mới</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection