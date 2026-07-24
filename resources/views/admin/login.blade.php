<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập quản trị</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container vh-100 d-flex justify-content-center align-items-center">

    <div class="card shadow-lg border-0" style="width: 420px; border-radius: 15px;">

        <div class="card-body p-5">

            <div class="text-center mb-4">

                <i class="bi bi-person-circle text-primary" style="font-size:70px"></i>

                <h3 class="mt-3 fw-bold">
                    Đăng nhập Admin
                </h3>

                <p class="text-muted mb-0">
                    Vui lòng đăng nhập để tiếp tục
                </p>

            </div>

            <form action="{{ route('admin.login') }}" method="POST">

                @csrf

                <div class="mb-3">

                    <label class="form-label">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Nhập email">

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="mb-4">

                    <label class="form-label">
                        Mật khẩu
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Nhập mật khẩu">

                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <button type="submit" class="btn btn-primary w-100">

                    <i class="bi bi-box-arrow-in-right"></i>

                    Đăng nhập

                </button>

            </form>

        </div>

    </div>

</div>

</body>

</html>