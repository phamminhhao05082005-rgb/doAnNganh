@extends('layouts.admin')

@section('content')

<div class="card shadow">

    <div class="card-header d-flex justify-content-between">

        <h4>Danh sách doanh nghiệp</h4>

        <a href="{{ route('admin.companies.create') }}"
            class="btn btn-success">

            + Thêm doanh nghiệp

        </a>

    </div>

    <div class="card-body">

        @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

        @endif

        <table class="table table-bordered table-hover">

            <thead class="table-dark">

                <tr>

                    <th>ID</th>

                    <th>Tên công ty</th>

                    <th>Email</th>

                    <th>Website</th>

                    <th>Điện thoại</th>
                    <th>Trạng thái</th>
                    <th width="220">

                        Thao tác

                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($companies as $company)

                <tr>

                    <td>

                        {{ $company->id }}

                    </td>

                    <td>

                        {{ $company->name }}

                    </td>

                    <td>

                        {{ $company->owner->email }}

                    </td>

                    <td>

                        {{ $company->website }}

                    </td>

                    <td>

                        {{ $company->owner->phone }}

                    </td>

                    <td>
                        @if($company->trashed())
                        <span class="badge bg-danger">
                            Đã xóa
                        </span>
                        @else
                        <span class="badge bg-success">
                            Đang hoạt động
                        </span>
                        @endif
                    </td>

                    <td>

                        <a href="{{ route('admin.companies.show',$company->id) }}"
                            class="btn btn-info btn-sm">
                            Xem
                        </a>

                        @if(!$company->trashed())

                        <a href="{{ route('admin.companies.edit',$company->id) }}"
                            class="btn btn-warning btn-sm">
                            Sửa
                        </a>

                        <form
                            action="{{ route('admin.companies.destroy',$company->id) }}"
                            method="POST"
                            style="display:inline">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Bạn có chắc muốn xóa doanh nghiệp này?')">

                                Xóa

                            </button>

                        </form>

                        @else

                        <form
                            action="{{ route('admin.companies.restore',$company->id) }}"
                            method="POST"
                            style="display:inline">

                            @csrf
                            @method('PUT')

                            <button
                                type="submit"
                                class="btn btn-success btn-sm"
                                onclick="return confirm('Khôi phục doanh nghiệp này?')">

                                Khôi phục

                            </button>

                        </form>

                        @endif

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6" class="text-center">

                        Chưa có doanh nghiệp

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection