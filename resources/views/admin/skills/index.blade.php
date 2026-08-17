@extends('layouts.admin')

@section('content')
<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Quản lý kỹ năng</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="bi bi-plus-lg"></i> Thêm mới
        </button>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th width="80">ID</th>
                    <th>Tên kỹ năng</th>
                    <th width="180" class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($skills as $skill)
                <tr>
                    <td>{{ $skill->id }}</td>
                    <td>{{ $skill->name }}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $skill->id }}">
                            <i class="bi bi-pencil"></i> Sửa
                        </button>
                        <form action="{{ route('admin.skills.destroy', $skill->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xoá?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Xoá</button>
                        </form>
                    </td>
                </tr>

                <!-- Modal Sửa -->
                <div class="modal fade" id="editModal{{ $skill->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('admin.skills.update', $skill->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header"><h5 class="modal-title">Sửa kỹ năng</h5></div>
                                <div class="modal-body">
                                    <input type="text" name="name" class="form-control" value="{{ $skill->name }}" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Thêm mới -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.skills.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Thêm kỹ năng mới</h5></div>
                <div class="modal-body">
                    <input type="text" name="name" class="form-control" placeholder="Tên kỹ năng..." required>
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