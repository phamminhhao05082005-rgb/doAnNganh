@extends('layouts.admin')

@section('content')

<div class="card shadow">

    <div class="card-header">

        <h4>

            Thêm doanh nghiệp

        </h4>

    </div>

    <div class="card-body">

        @if($errors->any())

            <div class="alert alert-danger">

                <ul>

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <form
            action="{{ route('admin.companies.store') }}"
            method="POST">

            @include('admin.companies.form')

        </form>

    </div>

</div>

@endsection