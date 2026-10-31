@extends('layouts.store')
@section('title', 'Mơ Màng - Trang chủ')

@section('content')
{{-- 1. Banner bộ sưu tập mới --}}
<section class="home-hero mb-4">
    <div class="container-fluid px-0">
    <div class="banner-slider" id="bannerSlider">

        <div class="banner-slides">
            <img src="{{ asset('storage/banners/banner1.webp') }}"
                 alt="Banner 1" class="banner-slide active">

            <img src="{{ asset('storage/banners/banner2.png') }}"
                 alt="Banner 2" class="banner-slide">

            <img src="{{ asset('storage/banners/banner3.png') }}"
                 alt="Banner 3" class="banner-slide">

            <img src="{{ asset('storage/banners/banner4.png') }}"
                 alt="Banner 4" class="banner-slide">
        </div>

        <button type="button" class="banner-arrow banner-prev"
                aria-label="Ảnh trước">&#10094;</button>

        <button type="button" class="banner-arrow banner-next"
                aria-label="Ảnh tiếp theo">&#10095;</button>

        <div class="banner-dots">
            <button type="button" class="banner-dot active"
                    aria-label="Ảnh 1"></button>
            <button type="button" class="banner-dot"
                    aria-label="Ảnh 2"></button>
            <button type="button" class="banner-dot"
                    aria-label="Ảnh 3"></button>
            <button type="button" class="banner-dot"
                    aria-label="Ảnh 4"></button>
        </div>
    </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const slider = document.getElementById('bannerSlider');
    if (!slider) return;

    const slides = slider.querySelectorAll('.banner-slide');
    const dots = slider.querySelectorAll('.banner-dot');
    const prev = slider.querySelector('.banner-prev');
    const next = slider.querySelector('.banner-next');

    let current = 0;
    let timer;

    function showSlide(index) {
        current = (index + slides.length) % slides.length;

        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === current);
        });

        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === current);
        });
    }

    function startAutoSlide() {
        clearInterval(timer);
        timer = setInterval(() => {
            showSlide(current + 1);
        }, 10000);
    }

    prev.addEventListener('click', () => {
        showSlide(current - 1);
        startAutoSlide();
    });

    next.addEventListener('click', () => {
        showSlide(current + 1);
        startAutoSlide();
    });

    dots.forEach((dot, i) => {
        dot.addEventListener('click', () => {
            showSlide(i);
            startAutoSlide();
        });
    });

    showSlide(0);
    startAutoSlide();
});
</script>


{{-- 2. Các chương trình khuyến mãi --}}
<section class="mb-5">
    <div class="d-flex justify-content-between align-items-end mb-3">
        <div>
            <h2 class="h3 section-heading mb-1">Sản phẩm đang sale</h2>
            <p class="text-secondary mb-0">Ưu đãi hấp dẫn dành cho bạn</p>
        </div>

        <a href="{{ route('store.products.index') }}" class="text-dark">
            Xem tất cả →
        </a>
    </div>

    @include('store.partials.product-grid', [
        'products' => $saleProducts
    ])
</section>

{{-- 3. Thanh quyền lợi khách hàng --}}
<section class="service-bar rounded-4 mb-5"><div class="row g-0">
    <div class="col-6 col-lg-3"><div class="service-item"><strong>Miễn phí vận chuyển</strong><span>Đơn từ 399K</span></div></div>
    <div class="col-6 col-lg-3"><div class="service-item"><strong>Đổi hàng tận nhà</strong><span>Trong vòng 15 ngày</span></div></div>
    <div class="col-6 col-lg-3"><div class="service-item"><strong>Thanh toán COD</strong><span>Yên tâm mua sắm</span></div></div>
    <div class="col-6 col-lg-3"><div class="service-item"><strong>Hotline: 094.9675.865</strong><span>Hỗ trợ bạn từ 8h30–24h00</span></div></div>
</div></section>


{{-- 5. Sản phẩm bán chạy --}}
<section class="mb-5">
    <div class="d-flex justify-content-between align-items-end mb-3"><div><h2 class="h3 section-heading mb-1">Sản phẩm bán chạy</h2><p class="text-secondary mb-0">Được khách hàng lựa chọn nhiều</p></div><a href="{{ route('store.products.index') }}" class="text-dark">Xem tất cả →</a></div>
    @include('store.partials.product-grid', ['products' => $bestSellers])
</section>

{{-- 6. Bộ sưu tập mới --}}
<section class="mb-5">
    <div class="d-flex justify-content-between align-items-end mb-3">
        <div>
            <h2 class="h3 section-heading mb-1">
                Bộ sưu tập mới
            </h2>
            <p class="text-secondary mb-0">
                Khám phá phong cách dành riêng cho bạn
            </p>
        </div>

        <a href="{{ route('store.products.index') }}"
           class="text-dark">
            Khám phá ngay →
        </a>
    </div>

    <div class="row g-3">
        @forelse($collections as $collection)
            <div class="col-6 col-md-3">
                <a href="{{ route('store.products.index', [
                    'collection' => $collection->slug
                ]) }}"
                   class="text-decoration-none text-dark">

                    <div class="rounded-4 p-4 h-100
                                d-flex flex-column justify-content-end"
                         style="min-height:180px;
                                background:linear-gradient(
                                    135deg, #f0f0f0, #dcdcdc
                                )">

                        <span class="small text-secondary">
                            FASHION COLLECTION
                        </span>

                        <h3 class="h5 fw-bold mt-2 mb-0">
                            {{ $collection->name }}
                        </h3>

                        <span class="small mt-2">
                            Khám phá ngay →
                        </span>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <p class="text-secondary">
                    Các bộ sưu tập sẽ được cập nhật sớm.
                </p>
            </div>
        @endforelse
    </div>
</section>


{{-- 7. Tìm hiểu về chúng tôi --}}
<section class="rounded-4 p-4 p-md-5 mb-2" style="background:#eee7e1"><div class="row align-items-center g-3">
    <div class="col-lg-8"><p class="small text-uppercase mb-2">Our story</p><h2 class="h2 fw-bold">Tìm hiểu về chúng tôi</h2><p class="mb-0 text-secondary">Mơ Màng mong muốn giúp bạn tìm thấy những thiết kế phù hợp với phong cách riêng và dễ dàng mua sắm mỗi ngày.</p></div>
    <div class="col-lg-4 text-lg-end"><a href="{{ route('store.about') }}" class="btn btn-dark rounded-pill px-4">Về Mơ Màng</a></div>
</div></section>
@endsection
