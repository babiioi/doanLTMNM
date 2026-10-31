<!doctype html>
<html lang="vi">
<head>
<link rel="icon" type="image/png" href="{{ asset('images/mo-mang-favicon.png') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Mơ Màng')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --fashion-brown:#76584a; --fashion-rust:#a14c37; --fashion-cream:#faf9f7; }
        body { background:var(--fashion-cream); color:#252525; }
        .navbar-brand { letter-spacing:.12em; font-weight:800; }
        .product-card { border:0; border-radius:14px; overflow:hidden; transition:transform .2s; }
        .product-card:hover { transform:translateY(-3px); }
        .product-img { width:100%; height:250px; object-fit:cover; background:#eee; }
        .price { color:var(--fashion-rust); font-weight:700; }
        .service-bar { background:#f0e9e4; border:1px solid #e3d8d1; }
        .service-item { text-align:center; padding:.85rem .5rem; font-size:.88rem; }
        .service-item strong { display:block; font-size:.9rem; }
        
        .home-hero {
        width: 100%;
        max-width: none;
        margin-bottom: 24px;
        }

        .banner-slider {
            position: relative;
            width: 100%;
            height: 480px;
            overflow: hidden;
            border-radius: 0;
            background: #f5f5f5;
        }

        .banner-slides {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .banner-slide {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            opacity: 0;
            transition: opacity 0.6s ease;
            pointer-events: none;
        }

        .banner-slide.active {
            opacity: 1;
            pointer-events: auto;
        }

        .banner-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 44px;
            height: 44px;
            border: none;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.85);
            color: #222;
            font-size: 20px;
            cursor: pointer;
            z-index: 2;
            transition: background 0.2s, transform 0.2s;
        }

        .banner-arrow:hover {
            background: #fff;
            transform: translateY(-50%) scale(1.08);
        }

        .banner-prev {
            left: 18px;
        }

        .banner-next {
            right: 18px;
        }

        .banner-dots {
            position: absolute;
            bottom: 16px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 9px;
            z-index: 2;
        }

        .banner-dot {
            width: 9px;
            height: 9px;
            padding: 0;
            border: none;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.65);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .banner-dot.active {
            width: 26px;
            border-radius: 10px;
            background: #fff;
        }

        @media (max-width: 768px) {
            .banner-slider {
                height: 220px;
                border-radius: 10px;
            }

            .banner-arrow {
                width: 34px;
                height: 34px;
                font-size: 16px;
            }

            .banner-prev {
                left: 10px;
            }

            .banner-next {
                right: 10px;
            }
        }

        .promo-card { min-height:105px; border-radius:16px; padding:1.25rem; color:#fff; background:linear-gradient(120deg,#6d493b,#b98266); }
        .promo-card:nth-child(2) { background:linear-gradient(120deg,#373737,#777); }
        .promo-card:nth-child(3) { background:linear-gradient(120deg,#876b4e,#c6a77f); }
        .section-heading { font-weight:750; }

        .fashion-navbar { min-height:76px; }
        .fashion-navbar .navbar-brand { font-size:1.05rem; white-space:nowrap; }
        .fashion-navbar .navbar-collapse { flex-grow:1; }
        .fashion-main-nav { margin-inline:auto; align-items:center; gap:.35rem; }
        .fashion-main-nav .nav-link { color:#292522; font-weight:500; padding:.7rem .8rem !important; white-space:nowrap; }
        .fashion-main-nav .nav-link:hover, .fashion-main-nav .nav-link:focus { color:var(--fashion-rust); }
        .fashion-navbar .dropdown-menu { border:1px solid #eee5df; border-radius:12px; box-shadow:0 12px 30px rgba(40,25,15,.10); padding:.5rem; min-width:220px; }
        .fashion-navbar .dropdown-item { border-radius:7px; padding:.6rem .8rem; }
        .fashion-navbar .dropdown-item:hover { background:#f5eee9; color:var(--fashion-rust); }
        .navbar-tools { display:flex; align-items:center; gap:.35rem; }
        .nav-icon-btn { display:inline-flex; align-items:center; justify-content:center; width:40px; height:40px; border:0; border-radius:50%; color:#282421; background:transparent; text-decoration:none; position:relative; }
        .nav-icon-btn:hover, .nav-icon-btn:focus { background:#f4eee9; color:var(--fashion-rust); }
        .nav-icon-btn svg { width:21px; height:21px; stroke:currentColor; }
        .cart-count { position:absolute; top:0; right:-1px; min-width:17px; height:17px; padding:0 4px; border-radius:20px; display:flex; align-items:center; justify-content:center; background:var(--fashion-rust); color:white; font-size:.65rem; line-height:1; }
        .search-dropdown { width:min(320px, 90vw); padding:.75rem !important; }
        @media (max-width: 991.98px) {
            .fashion-main-nav { align-items:stretch; margin:0; padding:.5rem 0; }
            .fashion-main-nav .nav-link { padding:.6rem .25rem !important; }
            .navbar-tools { justify-content:flex-start; padding:.25rem 0 .75rem; }
            .fashion-navbar .navbar-collapse { padding-top:.5rem; }
        }

        .site-footer { background:#25211f; color:#f8f5f2; }
        .site-footer a { color:#e6d8ce; text-decoration:none; }
        .site-footer a:hover { color:#fff; }
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top fashion-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ route('store.home') }}"><img src="{{ asset('images/mo-mang-logo.png') }}" alt="Mơ Màng" style="height:50px;width:auto;max-width:160px;object-fit:contain"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-label="Mở menu"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav fashion-main-nav">
                <li class="nav-item"><a class="nav-link" href="{{ route('store.home') }}">Trang chủ</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="{{ route('store.products.index') }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">Sản phẩm</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('store.products.index', ['category' => 'do-ngu-nam']) }}">Đồ ngủ nam</a></li>
                        <li><a class="dropdown-item" href="{{ route('store.products.index', ['category' => 'do-ngu-nu']) }}">Đồ ngủ nữ</a></li>
                        <li><a class="dropdown-item" href="{{ route('store.products.index', ['category' => 'do-ngu-tre-em']) }}">Đồ ngủ trẻ em</a></li>
                        <li><a class="dropdown-item" href="{{ route('store.products.index', ['category' => 'phu-kien']) }}">Phụ kiện</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item fw-semibold" href="{{ route('store.products.index') }}">Xem tất cả sản phẩm</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="{{ route('store.products.index') }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">Bộ sưu tập</a>
                    <ul class="dropdown-menu">
                        @forelse(($navCollections ?? collect()) as $navCollection)
                            <li><a class="dropdown-item" href="{{ route('store.products.index', ['collection' => $navCollection->slug]) }}">{{ $navCollection->name }}</a></li>
                        @empty
                            <li><span class="dropdown-item-text text-secondary">Chưa có bộ sưu tập</span></li>
                        @endforelse
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('store.about') }}">Giới thiệu</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('store.contact') }}">Liên hệ</a></li>
            </ul>
            <div class="navbar-tools">
                <a class="nav-icon-btn" href="{{ auth()->check() ? route('wishlist.index') : route('login') }}" title="Sản phẩm yêu thích" aria-label="Sản phẩm yêu thích" style="font-size:24px;text-decoration:none;color:#b94b68">♡</a>
                <div class="dropdown">
                    <button class="nav-icon-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Tìm kiếm" title="Tìm kiếm">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round"><circle cx="10.8" cy="10.8" r="6.8"></circle><path d="m16 16 4.2 4.2"></path></svg>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end search-dropdown">
                        <form method="GET" action="{{ route('store.products.index') }}" class="d-flex gap-2">
                            <input class="form-control" type="search" name="q" value="{{ request('q') }}" placeholder="Tìm sản phẩm..." aria-label="Từ khóa tìm kiếm" autofocus>
                            <button class="btn btn-dark" type="submit">Tìm</button>
                        </form>
                    </div>
                </div>
                <a class="nav-icon-btn" href="{{ route('cart.index') }}" aria-label="Giỏ hàng" title="Giỏ hàng">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h2l2.2 11.2a2 2 0 0 0 2 1.6h8.7a2 2 0 0 0 2-1.6L21 7H6"></path><circle cx="9.5" cy="20" r="1"></circle><circle cx="18" cy="20" r="1"></circle></svg>
                    @if(count(session('cart', [])) > 0)<span class="cart-count">{{ array_sum(session('cart', [])) }}</span>@endif
                </a>
                <div class="dropdown">
                    <button class="nav-icon-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Tài khoản" title="Tài khoản">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="3.5"></circle><path d="M5 21v-1.5a7 7 0 0 1 14 0V21"></path></svg>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @auth
                            <li><span class="dropdown-item-text small text-secondary">Xin chào, {{ auth()->user()->name }}</span></li>
                            <li><a class="dropdown-item" href="{{ route('orders.index') }}">Đơn hàng của tôi</a></li>
                            <li><a class="dropdown-item" href="{{ route('wishlist.index') }}">♡ Sản phẩm yêu thích</a></li>
                            @if(auth()->user()->role === 'admin')<li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Quản trị</a></li>@endif
                            <li><hr class="dropdown-divider"></li>
                            <li><form method="POST" action="{{ route('logout') }}" class="px-2">@csrf<button class="btn btn-outline-dark btn-sm w-100" type="submit">Đăng xuất</button></form></li>
                        @else
                            <li><a class="dropdown-item" href="{{ route('login') }}">Đăng nhập</a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}">Đăng ký tài khoản</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
<main class="container py-4">
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    @if($errors->any())<div class="alert alert-danger"><strong>Vui lòng kiểm tra lại thông tin:</strong><ul class="mb-0 mt-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    @yield('content')
</main>
<footer class="site-footer mt-5 pt-5 pb-4">
    <div class="container"><div class="row g-4">
        <div class="col-md-4"><img src="{{ asset('images/mo-mang-logo.png') }}" alt="Mơ Màng" style="height:100px;width:auto;max-width:165px;object-fit:contain;background:#fff;border-radius:12px;padding:4px;margin-bottom:12px"><h5 class="fw-bold">MƠ MÀNG</h5><p class="text-white-50">Phong cách của riêng bạn. Khám phá những thiết kế dễ phối đồ cho mỗi ngày.</p></div>
        <div class="col-md-4"><h6 class="fw-bold">Hỗ trợ khách hàng</h6><p class="mb-2">Hotline: 094.9675.865</p><p>Thời gian hỗ trợ: 8h30–24h00</p><a href="{{ route('store.contact') }}">Liên hệ với chúng tôi</a></div>
        <div class="col-md-4"><h6 class="fw-bold">Khám phá</h6><p class="mb-2"><a href="{{ route('store.products.index') }}">Tất cả sản phẩm</a></p><p class="mb-2"><a href="{{ route('store.about') }}">Tìm hiểu về chúng tôi</a></p><p><a href="{{ route('cart.index') }}">Giỏ hàng</a></p></div>
    </div><hr class="border-secondary mt-4"><div class="small text-white-50">© {{ date('Y') }} Mơ Màng. All rights reserved.</div></div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('submit', async function (event) {
    const form = event.target.closest('.mm-wishlist-form');
    if (!form) return;
    event.preventDefault();
    @guest
    window.location.href = form.dataset.loginUrl;
    return;
    @endguest
    const button = form.querySelector('[data-wishlist-button]');
    if (!button || button.disabled) return;
    button.disabled = true;
    try {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {'Accept':'application/json', 'X-Requested-With':'XMLHttpRequest'},
            body: new FormData(form),
            credentials: 'same-origin'
        });
        if (response.status === 401 || response.status === 419) {
            window.location.href = form.dataset.loginUrl;
            return;
        }
        if (!response.ok) throw new Error('Không thể cập nhật yêu thích.');
        const result = await response.json();
        button.dataset.active = result.active ? '1' : '0';
        const detail = button.classList.contains('btn-outline-danger');
        button.textContent = detail
            ? (result.active ? '♥ Bỏ khỏi yêu thích' : '♡ Thêm vào yêu thích')
            : (result.active ? '♥' : '♡');
        button.style.color = result.active ? '#d43d60' : '#555';
        button.setAttribute('aria-label', result.active ? 'Bỏ yêu thích' : 'Thêm yêu thích');
        button.title = result.active ? 'Bỏ yêu thích' : 'Thêm yêu thích';
    } catch (error) {
        alert('Không thể cập nhật yêu thích. Vui lòng thử lại.');
    } finally {
        button.disabled = false;
    }
});
</script>
@stack('scripts')
</body>
</html>
