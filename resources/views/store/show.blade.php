@extends('layouts.store')
@section('title', $product->name)

@section('content')
<a href="{{ route('store.home') }}" class="text-secondary text-decoration-none">← Quay lại sản phẩm</a>
<div class="row g-4 mt-2">
    <div class="col-md-6">
        <img id="product-main-image" src="{{ $product->image ? asset('storage/'.$product->image) : '' }}"
             class="img-fluid rounded-4 w-100 {{ $product->image ? '' : 'd-none' }}" alt="{{ $product->name }}">
        <div id="product-image-placeholder" class="rounded-4 bg-light d-flex align-items-center justify-content-center {{ $product->image ? 'd-none' : '' }}" style="height:420px">MƠ MÀNG</div>
        <div id="product-thumbnails" class="d-flex gap-2 mt-3"></div>
    </div>
    <div class="col-md-6 py-md-4">
        <div class="text-secondary">{{ $product->category?->name }}</div>
        <h1 class="display-6 fw-bold mt-2">{{ $product->name }}</h1>
        <form method="POST" action="{{ auth()->check() ? route('wishlist.toggle', $product) : route('login') }}" class="mb-3 mm-wishlist-form" data-login-url="{{ route('login') }}">@csrf
            @php $isFavorite = auth()->check() && \Illuminate\Support\Facades\DB::table('wishlists')->where('user_id', auth()->id())->where('product_id', $product->id)->exists(); @endphp
            <button class="btn btn-outline-danger btn-sm" type="submit" data-wishlist-button data-active="{{ $isFavorite ? 1 : 0 }}">{{ $isFavorite ? '♥ Bỏ khỏi yêu thích' : '♡ Thêm vào yêu thích' }}</button>
        </form>
        @if($product->sale_price && $product->sale_price < $product->price)
            <p class="fs-3 mb-1 text-danger fw-bold">{{ number_format($product->sale_price, 0, ',', '.') }}₫</p>
            <del class="text-secondary">{{ number_format($product->price, 0, ',', '.') }}₫</del>
        @else
            <p class="price fs-3">{{ number_format($product->price, 0, ',', '.') }}₫</p>
        @endif
        <button type="button" class="btn btn-outline-secondary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#sizeGuideModal">Hướng dẫn chọn size</button>
        <p>{{ $product->description ?: 'Sản phẩm thời trang dành cho phong cách hằng ngày.' }}</p>

        @php
            $variants = $product->variants->sortBy('color')->values();
            $colorData = [];
            foreach ($variants->groupBy('color') as $colorName => $rows) {
                $first = $rows->first();
                $colorData[] = ['name' => $colorName,
                    'ids' => $rows->pluck('id','size')->all(),
                    'images' => array_values(array_filter([$first->image ? asset('storage/'.$first->image) : null, $first->image_2 ? asset('storage/'.$first->image_2) : null]))];
            }
        @endphp
        <form method="POST" action="{{ route('cart.store', $product) }}" class="mt-4" id="add-to-cart-form">
            @csrf
            @if(count($colorData))
            <div class="mb-3"><label for="variant-color" class="form-label fw-semibold">Chọn màu sắc</label>
                <select id="variant-color" class="form-select" required><option value="">-- Chọn màu --</option>
                    @foreach($colorData as $c)<option value="{{ $c['name'] }}">{{ $c['name'] }}</option>@endforeach
                </select>
            </div>
            @endif
            <div class="mb-3"><label class="form-label fw-semibold">Chọn kích thước</label>
                <div class="d-flex gap-2" id="size-buttons">
                    @foreach(['S','M','L'] as $sz)<button type="button" class="btn btn-outline-dark rounded-3 px-4 size-choice" data-size="{{ $sz }}" aria-pressed="false">{{ $sz }}</button>@endforeach
                </div>
            </div>
            <input type="hidden" name="size" id="chosen-size" required>
            <input type="hidden" name="variant_id" id="variant-id">
            <p class="text-secondary small">Tồn kho chung: {{ $product->stock }} sản phẩm</p>
            <div class="d-flex flex-wrap align-items-end gap-3">
                <div><label for="quantity" class="form-label">Số lượng</label><input id="quantity" type="number" name="quantity" value="1" min="1" max="{{ max(1,min(99,$product->stock)) }}" class="form-control" style="width:100px" required></div>
                <button id="add-cart-button" class="btn btn-dark btn-lg rounded-pill px-4" disabled>{{ $product->stock > 0 ? 'Thêm vào giỏ hàng' : 'Hết hàng' }}</button>
            </div>
            @error('size')<p class="text-danger small">{{ $message }}</p>@enderror
            @error('variant_id')<p class="text-danger small">{{ $message }}</p>@enderror
        </form>
        <script>
        (() => {
            const colors = {{ Illuminate\Support\Js::from($colorData) }};
            const fallback = {{ Illuminate\Support\Js::from($product->image ? asset('storage/'.$product->image) : null) }};
            const stock = {{ (int)$product->stock }};
            const select = document.getElementById('variant-color');
            const chosenSize = document.getElementById('chosen-size');
            const variantId = document.getElementById('variant-id');
            const button = document.getElementById('add-cart-button');
            const main = document.getElementById('product-main-image');
            const placeholder = document.getElementById('product-image-placeholder');
            const thumbs = document.getElementById('product-thumbnails');
            function images(urls) {
                const sources = urls.length ? urls : (fallback ? [fallback] : []);
                thumbs.replaceChildren(); main.classList.toggle('d-none',!sources.length);
                placeholder.classList.toggle('d-none',!!sources.length);
                if (!sources.length) return;
                main.src=sources[0];
                sources.forEach((src,i)=>{
                    const thumb=document.createElement('img'); thumb.src=src;
                    thumb.alt='Ảnh '+(i+1); thumb.style.cssText='width:82px;height:82px;object-fit:cover;cursor:pointer;border:2px solid #d5c4b7;border-radius:10px';
                    thumb.addEventListener('click',()=>main.src=src); thumbs.appendChild(thumb);
                });
            }
            function refresh() {
                const color=select ? colors.find(c=>c.name===select.value) : null;
                variantId.value=color ? (color.ids[chosenSize.value] || '') : '';
                button.disabled=stock<1 || !chosenSize.value || (!!select && !color) || (!!color && !variantId.value);
                images(color ? color.images : []);
            }
            document.querySelectorAll('.size-choice').forEach(b=>b.addEventListener('click',()=>{
                chosenSize.value=b.dataset.size;
                document.querySelectorAll('.size-choice').forEach(x=>{
                    x.classList.toggle('btn-dark',x===b);x.classList.toggle('btn-outline-dark',x!==b);
                    x.setAttribute('aria-pressed',x===b?'true':'false');
                }); refresh();
            }));
            if(select)select.addEventListener('change',refresh);
            refresh();
        })();
        </script>
    </div>
</div>
<div class="modal fade" id="sizeGuideModal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Hướng dẫn chọn size</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button></div><div class="modal-body"><img src="{{ asset('images/mo-mang-size-guide.png') }}" class="img-fluid w-100" alt="Bảng hướng dẫn chọn size"></div></div></div></div>
@endsection
