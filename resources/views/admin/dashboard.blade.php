@extends('admin.layouts.main')
@section('title', 'Tổng quan quản trị')
@section('content')
<h1 class="h3 mb-4">Tổng quan</h1>
<div class="row g-3">
    <div class="col-md-3"><div class="card shadow-sm border-0"><div class="card-body"><div class="text-secondary">Danh mục</div><div class="display-5 fw-bold">{{ $categoryCount }}</div><a href="{{ route('admin.categories.index') }}">Quản lý danh mục →</a></div></div></div>
    <div class="col-md-3"><div class="card shadow-sm border-0"><div class="card-body"><div class="text-secondary">Bộ sưu tập</div><div class="display-5 fw-bold">{{ $collectionCount ?? \App\Models\Collection::count() }}</div><a href="{{ route('admin.collections.index') }}">Mở quản lý →</a></div></div></div>
    <div class="col-md-3"><div class="card shadow-sm border-0"><div class="card-body"><div class="text-secondary">Sản phẩm</div><div class="display-5 fw-bold">{{ $productCount }}</div><a href="{{ route('admin.products.index') }}">Quản lý sản phẩm →</a></div></div></div>
    <div class="col-md-3"><div class="card shadow-sm border-0"><div class="card-body"><div class="text-secondary">Tổng đơn hàng</div><div class="display-5 fw-bold">{{ $orderCount }}</div><a href="{{ route('admin.orders.index') }}">Quản lý đơn hàng →</a></div></div></div>
    <div class="col-md-3"><div class="card shadow-sm border-0"><div class="card-body"><div class="text-secondary">Đơn chờ xác nhận</div><div class="display-5 fw-bold">{{ $pendingOrderCount }}</div><a href="{{ route('admin.orders.index', ['status' => 'pending']) }}">Xem đơn chờ →</a></div></div></div>
</div>
@endsection
