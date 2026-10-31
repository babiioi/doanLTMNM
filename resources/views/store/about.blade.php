@extends('layouts.store')
@section('title', 'Câu chuyện Mơ Màng')
@section('content')
<style>
.mm-about{--ink:#46382f;--milk:#f7f0e8;color:var(--ink)}
.mm-about .hero{background:linear-gradient(130deg,#f7f0e8,#e6d4c6);padding:clamp(40px,7vw,95px) clamp(24px,7vw,100px);border-radius:30px;position:relative;overflow:hidden}
.mm-about .eyebrow{letter-spacing:.2em;text-transform:uppercase;font-size:.78rem;color:#97745e;font-weight:700}
.mm-about h1{font-size:clamp(2.5rem,5.4vw,5rem);font-weight:700;line-height:1.12;letter-spacing:-.04em}
.mm-about h2{font-size:clamp(1.8rem,3vw,2.7rem);font-weight:650;letter-spacing:-.035em}
.mm-about .lead{font-size:1.13rem;line-height:1.95;max-width:650px}
.mm-about p{line-height:1.9}
.mm-about .soft-card{background:#fff;border:1px solid #eee3d8;border-radius:24px;padding:32px;height:100%}
.mm-about .symbol{font-size:5rem;line-height:1;opacity:.5}
.mm-about .founder{background:#46382f;color:#fff;border-radius:28px;padding:clamp(30px,5vw,65px)}
 .mm-about .founder p{color:#e9dcd1}
.mm-about .soft-card{transition:transform .25s,box-shadow .25s;overflow:hidden}.mm-about .soft-card:hover{transform:translateY(-5px);box-shadow:0 18px 36px #46382f14}
.mm-about .category-photo{width:100%;height:225px;object-fit:cover;border-radius:16px;margin:16px 0;background:#f7f0e8}
.mm-about .founder{position:relative;overflow:hidden}.mm-about .founder:after{content:'✦  ☾  ✧';position:absolute;right:20px;top:12px;color:#d6bfae;opacity:.2;font-size:3rem;pointer-events:none}
.mm-about .ending{background:#f7f0e8;border-radius:26px;padding:45px 20px}.mm-about .hero:after{content:'✧';position:absolute;right:3%;bottom:1%;font-size:6rem;color:#fff8;pointer-events:none}
@media(max-width:767px){.mm-about .category-photo{height:250px}.mm-about .soft-card{padding:22px}}
</style>
<div class="mm-about">
<section class="hero mb-5"><div class="row align-items-center g-4"><div class="col-lg-8"><p class="eyebrow">Mơ Màng · Our Story</p><h1>Chạm vào dịu dàng,<br>nâng niu từng giấc ngủ.</h1><p class="lead mt-4 mb-4">Giữa những bộn bề thường ngày, Mơ Màng dành một khoảng nhỏ cho sự thoải mái, những phút giây bình yên và niềm vui được là chính mình.</p><a class="btn btn-dark rounded-pill px-4 py-3" href="{{ route('store.products.index') }}">Khám phá Mơ Màng</a></div><div class="col-lg-4 text-center"><img src="{{ asset('images/mo-mang-logo.png') }}" alt="Logo Mơ Màng" class="img-fluid" style="max-height:280px;object-fit:contain"></div></div></section>
<section class="row g-5 align-items-center py-4 mb-5"><div class="col-lg-5"><p class="eyebrow">Một chút bình yên</p><h2>Về nhà thôi, có bình yên đang đợi.</h2></div><div class="col-lg-7"><p>Một ngày đẹp không nhất thiết phải bắt đầu bằng những điều lớn lao. Đôi khi, hạnh phúc chỉ là được trở về nhà, thay một bộ đồ thật thoải mái và sống chậm lại một chút.</p><p>Mơ Màng ra đời từ những điều giản dị ấy, với mong muốn biến thời gian nghỉ ngơi thành những khoảnh khắc ấm áp, nhẹ nhàng và tích cực.</p></div></section>
<section class="mb-5"><p class="eyebrow text-center">Dành cho mọi người trong nhà</p><h2 class="text-center mb-4">Một chút Mơ Màng cho mọi nhà</h2><div class="row g-3"><div class="col-md-4"><div class="soft-card"><div class="symbol">✿</div>@if(!empty($aboutProducts['nang']))<img class="category-photo" loading="lazy" src="{{ asset('storage/'.$aboutProducts['nang']->image) }}" alt="Đồ ngủ Mơ Màng">@endif<h3 class="h4 mt-3">Dành cho nàng</h3><p>Dịu dàng, thanh lịch hay tinh nghịch – mỗi thiết kế là một cách thể hiện cá tính riêng.</p></div></div><div class="col-md-4"><div class="soft-card"><div class="symbol">☁</div>@if(!empty($aboutProducts['chang']))<img class="category-photo" loading="lazy" src="{{ asset('storage/'.$aboutProducts['chang']->image) }}" alt="Đồ ngủ Mơ Màng">@endif<h3 class="h4 mt-3">Dành cho chàng</h3><p>Đơn giản, chỉn chu và thoải mái, để những giờ phút ở nhà vẫn thật phong cách.</p></div></div><div class="col-md-4"><div class="soft-card"><div class="symbol">☾</div>@if(!empty($aboutProducts['be']))<img class="category-photo" loading="lazy" src="{{ asset('storage/'.$aboutProducts['be']->image) }}" alt="Đồ ngủ Mơ Màng">@endif<h3 class="h4 mt-3">Dành cho bé</h3><p>Sắc màu tươi vui, họa tiết ngộ nghĩnh đồng hành cùng bé trong từng giấc ngủ.</p></div></div></div></section>
<section class="founder mb-5"><div class="row g-4 align-items-center"><div class="col-lg-7"><p class="eyebrow" style="color:#dbc4b2">Câu chuyện thương hiệu</p><h2>Hai người sáng lập, một giấc mơ dịu dàng.</h2><p>Được sáng lập bởi Cao Lê Bảo Ngọc và Lê Thị Kim Xuân, Mơ Màng mong muốn xây dựng một thương hiệu đồ ngủ gần gũi, trẻ trung và có dấu ấn riêng. Với chúng mình, đồ ngủ không chỉ là trang phục mặc ở nhà mà còn là một phần của phong cách sống.</p></div><div class="col-lg-5"><div class="p-4 rounded-4" style="background:#5b493d"><small style="color:#dbc4b2">ĐỒNG SÁNG LẬP</small><h3 class="h4 mt-3">Cao Lê Bảo Ngọc</h3><h3 class="h4">Lê Thị Kim Xuân</h3></div></div></div></section>
<section class="text-center py-4 mb-4 ending"><p class="eyebrow">Một lời nhắn từ Mơ Màng</p><h2>Về nhà thôi, có bình yên đang đợi.</h2><p>Cảm ơn bạn đã để Mơ Màng trở thành một phần nhỏ trong những khoảnh khắc đời thường.</p><a class="btn btn-outline-dark rounded-pill px-4" href="{{ route('store.products.index') }}">Xem các bộ sưu tập</a></section>
</div>
@endsection
