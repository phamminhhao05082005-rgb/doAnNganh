@extends('layouts.admin')

@section('content')

<div class="card shadow mb-4">

    <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
        <h5 class="mb-0 text-primary fw-bold">
            <i class="bi bi-graph-up-arrow me-2"></i>Thống Kê Hệ Thống
        </h5>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Quay lại Dashboard
        </a>
    </div>

    <div class="card-body">

        <!-- CARDS HÀNG 1: TỔNG QUAN HỆ THỐNG -->
        <div class="row g-4 mb-3">
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 bg-primary bg-opacity-10 h-100 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle bg-primary text-white p-3 me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-people-fill fs-4"></i>
                        </div>
                        <div>
                            <span class="text-muted small fw-semibold">TỔNG SINH VIÊN</span>
                            <h4 class="mb-0 fw-bold text-primary">{{ number_format($stats['total_students']) }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 bg-success bg-opacity-10 h-100 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle bg-success text-white p-3 me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-buildings-fill fs-4"></i>
                        </div>
                        <div>
                            <span class="text-muted small fw-semibold">TỔNG DOANH NGHIỆP</span>
                            <h4 class="mb-0 fw-bold text-success">{{ number_format($stats['total_employers']) }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 bg-info bg-opacity-10 h-100 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle bg-info text-white p-3 me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-briefcase-fill fs-4"></i>
                        </div>
                        <div>
                            <span class="text-muted small fw-semibold">TỔNG TIN TUYỂN DỤNG</span>
                            <h4 class="mb-0 fw-bold text-info">{{ number_format($stats['total_jobs']) }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 bg-warning bg-opacity-10 h-100 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle bg-warning text-dark p-3 me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-file-earmark-text-fill fs-4"></i>
                        </div>
                        <div>
                            <span class="text-muted small fw-semibold">ĐƠN ỨNG TUYỂN</span>
                            <h4 class="mb-0 fw-bold text-warning">{{ number_format($stats['total_applications']) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARDS HÀNG 2: TRẠNG THÁI TIN TUYỂN DỤNG & KHÁC -->
        <div class="row g-4 mb-4">
            <div class="col-md-6 col-lg-6">
                <div class="card border-0 bg-success bg-opacity-10 shadow-sm">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-success text-white p-3 me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="bi bi-check-circle-fill fs-4"></i>
                            </div>
                            <div>
                                <span class="text-muted small fw-semibold">TIN ĐANG HOẠT ĐỘNG</span>
                                <h3 class="mb-0 fw-bold text-success">{{ number_format($stats['active_jobs']) }}</h3>
                            </div>
                        </div>
                        <a href="{{ route('admin.jobs.index') }}" class="btn btn-outline-success btn-sm">
                            Xem chi tiết <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-6">
                <div class="card border-0 bg-danger bg-opacity-10 shadow-sm">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-danger text-white p-3 me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                            </div>
                            <div>
                                <span class="text-muted small fw-semibold">TIN ĐANG ĐÓNG</span>
                                <h3 class="mb-0 fw-bold text-danger">{{ number_format($stats['closed_jobs']) }}</h3>
                            </div>
                        </div>
                        <a href="{{ route('admin.jobs.index') }}" class="btn btn-outline-danger btn-sm">
                            Xem chi tiết <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 bg-opacity-10 h-100 shadow-sm" style="background-color: rgba(111, 66, 193, 0.1);">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle text-white p-3 me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background-color: #6f42c1;">
                            <i class="bi bi-file-person-fill fs-4"></i>
                        </div>
                        <div>
                            <span class="text-muted small fw-semibold">TỔNG CV ĐÃ TẠO</span>
                            <h4 class="mb-0 fw-bold" style="color: #6f42c1;">{{ number_format($stats['total_cvs']) }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 bg-secondary bg-opacity-10 h-100 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle bg-secondary text-white p-3 me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-bookmark-star-fill fs-4"></i>
                        </div>
                        <div>
                            <span class="text-muted small fw-semibold">LƯỢT LƯU VIỆC LÀM</span>
                            <h4 class="mb-0 fw-bold text-secondary">{{ number_format($stats['total_bookmarks']) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <!-- SECTION BIỂU ĐỒ TRÒN/DOUGHNUT -->
        <h5 class="fw-bold mb-3 text-secondary"><i class="bi bi-pie-chart-fill me-2"></i>Thống Kê Ngành Nghề & Mẫu CV</h5>
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header bg-white fw-semibold text-center border-bottom-0 pt-3">Tin tuyển dụng theo Ngành</div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="min-height: 280px;">
                        <canvas id="jobsCategoryChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header bg-white fw-semibold text-center border-bottom-0 pt-3">Lượt Ứng tuyển theo Ngành</div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="min-height: 280px;">
                        <canvas id="applicationsCategoryChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header bg-white fw-semibold text-center border-bottom-0 pt-3">Tỷ lệ Mẫu CV được sử dụng</div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="min-height: 280px;">
                        <canvas id="cvTemplatesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <!-- SECTION BIỂU ĐỒ ĐƯỜNG & BIỂU ĐỒ CỘT -->
        <h5 class="fw-bold mb-3 text-secondary"><i class="bi bi-bar-chart-line-fill me-2"></i>Xu Hướng & Hoạt Động Doanh Nghiệp</h5>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header bg-white fw-semibold text-center border-bottom-0 pt-3">Số lượt Ứng tuyển theo Tháng</div>
                    <div class="card-body" style="min-height: 300px;">
                        <canvas id="applicationsOverTimeChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header bg-white fw-semibold text-center border-bottom-0 pt-3">Top Doanh nghiệp Đăng Tin</div>
                    <div class="card-body" style="min-height: 300px;">
                        <canvas id="companyJobsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- CDN Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const chartColors = ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#0dcaf0', '#6f42c1', '#fd7e14', '#20c997'];

    // 1. Biểu đồ Ngành nghề
    fetch("{{ route('admin.analytics.chart-data') }}")
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                new Chart(document.getElementById('jobsCategoryChart'), {
                    type: 'doughnut',
                    data: { labels: res.data.jobs_by_category.labels, datasets: [{ data: res.data.jobs_by_category.data, backgroundColor: chartColors }] },
                    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
                });

                new Chart(document.getElementById('applicationsCategoryChart'), {
                    type: 'pie',
                    data: { labels: res.data.applications_by_category.labels, datasets: [{ data: res.data.applications_by_category.data, backgroundColor: chartColors }] },
                    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
                });
            }
        });

    // 2. Biểu đồ Đường (Lượt ứng tuyển theo thời gian)
    fetch("{{ route('admin.analytics.applications-over-time') }}")
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                new Chart(document.getElementById('applicationsOverTimeChart'), {
                    type: 'line',
                    data: {
                        labels: res.data.labels,
                        datasets: [{
                            label: 'Lượt ứng tuyển',
                            data: res.data.data,
                            borderColor: '#0d6efd',
                            backgroundColor: 'rgba(13, 110, 253, 0.1)',
                            fill: true,
                            tension: 0.3
                        }]
                    },
                    options: { responsive: true, plugins: { legend: { display: false } } }
                });
            }
        });

    // 3. Biểu đồ Tròn (% Mẫu CV được dùng)
    fetch("{{ route('admin.analytics.cv-templates-usage') }}")
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                new Chart(document.getElementById('cvTemplatesChart'), {
                    type: 'doughnut',
                    data: {
                        labels: res.data.labels,
                        datasets: [{ data: res.data.data, backgroundColor: chartColors }]
                    },
                    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
                });
            }
        });

    // 4. Biểu đồ Cột (Tin tuyển dụng theo Doanh nghiệp)
    fetch("{{ route('admin.analytics.company-jobs') }}")
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                new Chart(document.getElementById('companyJobsChart'), {
                    type: 'bar',
                    data: {
                        labels: res.data.labels,
                        datasets: [{
                            label: 'Số lượng tin',
                            data: res.data.data,
                            backgroundColor: '#198754'
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: false } },
                        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                    }
                });
            }
        });
});
</script>

@endsection