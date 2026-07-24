@extends('layouts.admin')

@section('content')

<div class="card shadow">

    <div class="card-header">

        <h4>Chi tiết doanh nghiệp</h4>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6">

                <h5>Thông tin doanh nghiệp</h5>

                <table class="table">

                    <tr>
                        <th>Tên công ty</th>
                        <td>{{ $company->name }}</td>
                    </tr>

                    <tr>
                        <th>Website</th>
                        <td>{{ $company->website }}</td>
                    </tr>

                    <tr>
                        <th>Địa chỉ</th>
                        <td>{{ $company->address }}</td>
                    </tr>

                    <tr>
                        <th>Mô tả</th>
                        <td>{{ $company->description }}</td>
                    </tr>

                </table>

            </div>

            <div class="col-md-6">

                <h5>Thông tin tài khoản</h5>

                <table class="table">

                    <tr>
                        <th>Họ tên</th>
                        <td>{{ $company->owner->full_name }}</td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td>{{ $company->owner->email }}</td>
                    </tr>

                    <tr>
                        <th>Điện thoại</th>
                        <td>{{ $company->owner->phone }}</td>
                    </tr>

                    <tr>
                        <th>Trạng thái</th>

                        <td>

                            @if($company->owner->status)

                                <span class="badge bg-success">

                                    Hoạt động

                                </span>

                            @else

                                <span class="badge bg-danger">

                                    Đã khóa

                                </span>

                            @endif

                        </td>

                    </tr>

                </table>

            </div>

        </div>

        <hr>

        <a href="{{ route('admin.companies.edit',$company) }}"
           class="btn btn-warning">

            Sửa

        </a>

        <a href="{{ route('admin.companies.index') }}"
           class="btn btn-secondary">

            Quay lại

        </a>

    </div>

</div>

@endsection