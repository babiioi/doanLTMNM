
@extends('admin.layouts.main')

@section('title', 'Tổng quan quản trị')

@section('content')

<div class="mb-4">
    <h2 class="page-heading">Tổng quan</h2>
    <p class="page-subtitle mb-0">
        Theo dõi tình hình hoạt động của Fashion Store.
    </p>
</div>

{{-- 4 thẻ thống kê --}}
<div class="row g-4 mb-4">

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-title">Tổng sản phẩm</div>
            <div class="stat-number">{{ number_format($productCount) }}</div>
            <a class="stat-link" href="{{ route('admin.products.index') }}">
                Quản lý sản phẩm →
            </a>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-title">Tổng bộ sưu tập</div>
            <div class="stat-number">{{ number_format($collectionCount) }}</div>
            <a class="stat-link" href="{{ route('admin.collections.index') }}">
                Quản lý bộ sưu tập →
            </a>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-title">Tổng đơn hàng</div>
            <div class="stat-number">{{ number_format($orderCount) }}</div>
            <a class="stat-link" href="{{ route('admin.orders.index') }}">
                Quản lý đơn hàng →
            </a>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-title">Tổng doanh thu</div>
            <div class="stat-number" style="font-size:25px">
                {{ number_format($totalRevenue, 0, ',', '.') }} ₫
            </div>
            <span class="text-secondary small">
                Từ đơn hàng đã hoàn thành
            </span>
        </div>
    </div>

</div>

{{-- Biểu đồ doanh thu --}}
<div class="content-card">
    <div class="mb-4">
        <h5>Doanh thu theo thời gian</h5>
        <p class="text-secondary small mb-0">
            Thống kê doanh thu 6 tháng gần nhất
        </p>
    </div>

    <div style="height:320px; position:relative">
        <canvas id="revenueChart"></canvas>
    </div>
</div>

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
                borderColor: '#8B6F5C',
                backgroundColor: 'rgba(139, 111, 92, 0.15)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#8B6F5C'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Doanh thu: ' +
                                new Intl.NumberFormat('vi-VN')
                                    .format(context.raw) + ' ₫';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
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
