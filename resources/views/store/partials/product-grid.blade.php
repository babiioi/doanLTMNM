<div class="row g-4">
@forelse($products as $product)
    <div class="col-6 col-lg-3">
        <div class="card product-card h-100 shadow-sm position-relative">
            <form method="POST" action="{{ auth()->check() ? route('wishlist.toggle', $product) : route('login') }}" class="position-absolute mm-wishlist-form" data-login-url="{{ route('login') }}" style="top:10px;right:10px;z-index:2">
                @csrf
                @php $isFavorite = auth()->check() && \Illuminate\Support\Facades\DB::table('wishlists')->where('user_id', auth()->id())->where('product_id', $product->id)->exists(); @endphp
                <button type="submit" class="btn btn-light rounded-circle shadow-sm" aria-label="{{ $isFavorite ? 'Bỏ yêu thích' : 'Thêm yêu thích' }}" title="{{ $isFavorite ? 'Bỏ yêu thích' : 'Thêm yêu thích' }}" data-wishlist-button data-active="{{ $isFavorite ? 1 : 0 }}" style="font-size:23px;color:{{ $isFavorite ? '#d43d60' : '#555' }}">{{ $isFavorite ? '♥' : '♡' }}</button>
            </form>
            <a class="text-decoration-none text-dark" href="{{ route('store.products.show', $product) }}">
                @if($product->image)
                    <img
                        class="card-img-top product-img"
                        src="{{ asset('storage/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        style="width: 100%; height: 280px; object-fit: cover;"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                    >
                @else
                    <div class="product-img d-flex align-items-center justify-content-center text-secondary"
                        style="height: 280px;">
                        Chưa có ảnh
                    </div>
                @endif
            </a>
            <div class="card-body d-flex flex-column">
                <div class="small text-secondary">{{ $product->category?->name }}</div>
                <a class="text-decoration-none text-dark" href="{{ route('store.products.show', $product) }}"><h3 class="h6 mt-1">{{ $product->name }}</h3></a>
                                
                @if($product->sale_price !== null && $product->sale_price < $product->price)
                    <div class="price mb-3">
                        <span class="text-danger fw-bold">
                            {{ number_format($product->sale_price, 0, ',', '.') }} đ
                        </span>
                        <span class="text-secondary text-decoration-line-through small ms-1">
                            {{ number_format($product->price, 0, ',', '.') }} đ
                        </span>
                    </div>
                @else
                    <div class="price mb-3">
                        {{ number_format($product->price, 0, ',', '.') }} đ
                    </div>
                @endif

                @if($product->stock > 0)
                    <a href="{{ route('store.products.show', $product) }}" class="btn btn-outline-dark btn-sm w-100 mt-auto">Thêm vào giỏ</a>
                @else
                    <button class="btn btn-secondary btn-sm w-100 mt-auto" disabled>Hết hàng</button>
                @endif
            </div>
        </div>
    </div>
@empty
    <div class="col-12"><div class="alert alert-light border">Chưa có sản phẩm trong mục này.</div></div>
@endforelse
</div>
