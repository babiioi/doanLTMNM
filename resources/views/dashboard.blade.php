
@extends('admin.layouts.main')

@section('title', 'Tổng quan quản trị')

@section('content')

<div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
    <div>
        <h2 class="page-heading">Tổng quan</h2>
        <p class="page-subtitle mb-0">
            Theo dõi tình hình hoạt động của Mơ Màng.
        </p>
    </div>
    <span class="text-secondary small">
        <i class="bi bi-calendar3"></i>
        {{ now()->format('d/m/Y') }}
    </span>
</div>

{{-- 4 thẻ thống kê --}}
<div class="row g-4 mb-4">

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <span class="stat-title">Tổng sản phẩm</span>
                <span class="stat-icon" style="background:#eeedff;color:#7167f9">▣</span>
            </div>
            <div class="stat-number">{{ number_format($productCount) }}</div>
            <a class="stat-link" href="{{ route('admin.products.index') }}">
                Quản lý sản phẩm →
            </a>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <span class="stat-title">Tổng bộ sưu tập</span>
                <span class="stat-icon" style="background:#e5f8f0;color:#20a779">▤</span>
            </div>
            <div class="stat-number">{{ number_format($collectionCount) }}</div>
            <a class="stat-link" href="{{ route('admin.collections.index') }}">
                Quản lý bộ sưu tập →
            </a>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <span class="stat-title">Tổng đơn hàng</span>
                <span class="stat-icon" style="background:#fff1df;color:#e99a32">▧</span>
            </div>
            <div class="stat-number">{{ number_format($orderCount) }}</div>
            <a class="stat-link" href="{{ route('admin.orders.index') }}">
                Quản lý đơn hàng →
            </a>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <span class="stat-title">Tổng doanh thu</span>
                <span class="stat-icon" style="background:#ffe8ed;color:#e45d7a">₫</span>
            </div>
            <div class="stat-number" style="font-size:25px">
                {{ number_format($totalRevenue, 0, ',', '.') }}
                <span style="font-size:14px">₫</span>
            </div>
            <span class="text-secondary small">Từ đơn hàng hoàn thành</span>
        </div>
    </div>

</div>

{{-- Biểu đồ doanh thu --}}
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h5 class="mb-1">Doanh thu theo thời gian</h5>
            <p class="text-secondary small mb-0">
                Thống kê doanh thu 6 tháng gần nhất
            </p>
        </div>
        <span class="badge rounded-pill px-3 py-2"
              style="background:#eeedff;color:#7167f9">
            6 tháng
        </span>
    </div>

    <div style="height:320px; position:relative;">
        <canvas id="revenueChart"></canvas>
    </div>
</div>

<style>
    .stat-icon {
        width: 43px;
        height: 43px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        font-size: 23px;
        font-weight: 700;
    }

    .stat-card {
        transition: transform .2s, box-shadow .2s;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px #25294910;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const revenueCanvas = document.getElementById('revenueChart');

    new Chart(revenueCanvas, {
        type: 'line',
        data: {
            labels: @json($revenueLabels),
            datasets: [{
                label: 'Doanh thu',
                data: @json($revenueData),
                borderColor: '#7167f9',
                backgroundColor: 'rgba(113, 103, 249, 0.12)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointBackgroundColor: '#7167f9'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Doanh thu: ' +
                                new Intl.NumberFormat('vi-VN').format(context.raw) + ' ₫';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f0f1f6' },
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('vi-VN', {
                                notation: 'compact'
                            }).format(value) + ' ₫';
                        }
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
</script>

@endsection
