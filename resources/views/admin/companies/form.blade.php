@csrf

<div class="row">

    <div class="col-md-6">

        <div class="mb-3">
            <label class="form-label">Tên người đại diện</label>
            <input
                type="text"
                name="full_name"
                class="form-control"
                value="{{ old('full_name', $company->owner->full_name ?? '') }}"
                required>
        </div>

    </div>

    <div class="col-md-6">

        <div class="mb-3">
            <label class="form-label">Email</label>

            <input
                type="email"
                name="email"
                class="form-control"
                value="{{ old('email', $company->owner->email ?? '') }}"
                required>
        </div>

    </div>

</div>

<div class="row">

    <div class="col-md-6">

        <div class="mb-3">

            <label class="form-label">

                Mật khẩu

            </label>

            <input
                type="password"
                name="password"
                class="form-control">

            @if(!isset($company))
                <small class="text-danger">
                    Bắt buộc khi tạo mới
                </small>
            @endif

        </div>

    </div>

    <div class="col-md-6">

        <div class="mb-3">

            <label class="form-label">

                Số điện thoại

            </label>

            <input
                type="text"
                name="phone"
                class="form-control"
                value="{{ old('phone', $company->owner->phone ?? '') }}">

        </div>

    </div>

</div>

<hr>

<div class="mb-3">

    <label class="form-label">

        Tên công ty

    </label>

    <input
        type="text"
        name="name"
        class="form-control"
        value="{{ old('name', $company->name ?? '') }}"
        required>

</div>

<div class="mb-3">

    <label class="form-label">

        Website

    </label>

    <input
        type="text"
        name="website"
        class="form-control"
        value="{{ old('website', $company->website ?? '') }}">

</div>

<div class="mb-3">

    <label class="form-label">

        Địa chỉ

    </label>

    <input
        type="text"
        name="address"
        class="form-control"
        value="{{ old('address', $company->address ?? '') }}">

</div>

<div class="mb-3">

    <label class="form-label">

        Logo

    </label>

    <input
        type="text"
        name="logo"
        class="form-control"
        value="{{ old('logo', $company->logo ?? '') }}">

</div>

<div class="mb-3">

    <label class="form-label">

        Mô tả

    </label>

    <textarea
        class="form-control"
        rows="5"
        name="description">{{ old('description', $company->description ?? '') }}</textarea>

</div>

<button class="btn btn-primary">

    Lưu

</button>

<a href="{{ route('admin.companies.index') }}"
   class="btn btn-secondary">

    Quay lại

</a>