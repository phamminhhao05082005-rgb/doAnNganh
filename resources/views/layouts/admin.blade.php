<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Admin</title>

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
          rel="stylesheet">

</head>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<body>

<div class="container-fluid">

    <div class="row">

        {{-- Sidebar --}}

        <div class="col-md-2 bg-dark text-white vh-100 p-0">

            <div class="text-center p-3">

                <h3>ADMIN</h3>

            </div>

            <hr>

            <div class="list-group rounded-0">

                <a href="{{ route('admin.dashboard') }}"
                   class="list-group-item list-group-item-action">

                    <i class="bi bi-speedometer2"></i>

                    Dashboard

                </a>

                <a href="{{ route('admin.companies.index') }}"
                   class="list-group-item list-group-item-action">

                    <i class="bi bi-buildings"></i>

                    Quản lý doanh nghiệp

                </a>

            </div>

        </div>

        {{-- Content --}}

        <div class="col-md-10 p-0">

            <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">

                <div class="container-fluid">

                    <span class="navbar-brand">

                        Hệ thống quản trị tuyển dụng

                    </span>

                </div>

            </nav>

            <div class="container mt-4">

                @yield('content')

            </div>

        </div>

    </div>

</div>

</body>

</html>