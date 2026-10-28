<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Quản trị - Fashion Store')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">FASHION STORE / ADMIN</a>
        <div class="d-flex align-items-center gap-3 text-white">
            <span>{{ auth()->user()->name }}</span>
            <a class="btn btn-sm btn-outline-light" href="{{ route('store.home') }}">Xem cửa hàng</a>
            <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-sm btn-warning">Đăng xuất</button></form>
        </div>
    </div>
</nav>
<div class="container-fluid"><div class="row">
    <aside class="col-md-2 bg-white border-end min-vh-100 p-3">
        <div class="nav flex-column gap-2">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">Tổng quan</a>
            <a class="nav-link" href="{{ route('admin.categories.index') }}">Danh mục</a>
            <a class="nav-link" href="{{ route('admin.collections.index') }}">Bộ sưu tập</a>
            <a class="nav-link" href="{{ route('admin.products.index') }}">Sản phẩm</a>
            <a class="nav-link" href="{{ route('admin.orders.index') }}">Đơn hàng</a>
        </div>
    </aside>
    <main class="col-md-10 p-4">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        @yield('content')
    </main>
</div></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
