```blade
@extends('admin.layouts.main')

@section('title', 'Quản lý sản phẩm')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="page-heading mb-0">Sản phẩm</h1>

    <a class="btn btn-dark" href="{{ route('admin.products.create') }}">
        <i class="bi bi-plus-lg"></i> Thêm sản phẩm
    </a>
</div>

{{-- Tìm kiếm và lọc sản phẩm --}}
<form class="row g-2 mb-4" method="GET">
    <div class="col-md-4">
        <input
            class="form-control"
            name="q"
            value="{{ request('q') }}"
            placeholder="Tìm tên sản phẩm"
        >
    </div>

    <div class="col-md-3">
        <select class="form-select" name="category_id">
            <option value="">Tất cả danh mục</option>

            @foreach($categories as $c)
                <option
                    value="{{ $c->id }}"
                    @selected(request('category_id') == $c->id)
                >
                    {{ $c->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-auto">
        <button class="btn btn-outline-dark" type="submit">
            <i class="bi bi-funnel"></i> Lọc
        </button>
    </div>
</form>

{{-- Bảng sản phẩm --}}
<div class="table-responsive bg-white rounded shadow-sm product-table-wrapper">
    <table class="table table-hover align-middle mb-0 product-table">
        <thead class="table-light">
            <tr>
                <th></th>
                <th>Ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Danh mục</th>
                <th>Bộ sưu tập</th>
                <th>Giá</th>
                <th>Tồn kho</th>
                <th>Thao tác</th>
            </tr>
        </thead>

        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $products->firstItem() + $loop->index }}</td>

                    <td>
                        @if($product->image)
                            <img
                                src="{{ asset('storage/' . $product->image) }}"
                                alt="{{ $product->name }}"
                                class="product-thumbnail"
                            >
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>

                    <td class="product-name">
                        {{ $product->name }}
                    </td>

                    <td>
                        {{ $product->category?->name ?? '—' }}
                    </td>

                    <td>
                        {{ $product->collection ?: '—' }}
                    </td>

                    <td class="text-nowrap">
                        {{ number_format($product->price, 0, ',', '.') }} đ
                    </td>

                    <td>{{ $product->stock }}</td>

                    <td class="text-nowrap">
                        <a
                            class="btn btn-sm btn-outline-primary action-icon"
                            href="{{ route('admin.products.edit', $product) }}"
                            title="Sửa sản phẩm"
                            aria-label="Sửa sản phẩm"
                        >
                            <i class="bi bi-pencil"></i>
                        </a>

                        <form
                            class="d-inline"
                            method="POST"
                            action="{{ route('admin.products.destroy', $product) }}"
                            onsubmit="return confirm('Bạn chắc chắn muốn xóa sản phẩm này?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-sm btn-outline-danger action-icon"
                                title="Xóa sản phẩm"
                                aria-label="Xóa sản phẩm"
                            >
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-4">
                        Chưa có sản phẩm.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $products->links('pagination::bootstrap-5') }}
</div>

<style>
    /* Khung bảng: nếu màn hình hẹp, chỉ bảng cuộn ngang */
    .product-table-wrapper {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
    }

    /* Bảng */
    .product-table {
        width: 100%;
        min-width: 850px;
        table-layout: fixed;
        margin-bottom: 0;
    }

    .product-table th,
    .product-table td {
        padding: 12px 8px;
        text-align: center;
        vertical-align: middle;
        overflow-wrap: break-word;
    }

    .product-table thead th {
        font-weight: 700;
        white-space: nowrap;
    }

    /* # */
    .product-table th:nth-child(1),
    .product-table td:nth-child(1) {
        width: 4% !important;
    }

    /* Ảnh */
    .product-table th:nth-child(2),
    .product-table td:nth-child(2) {
        width: 11% !important;
    }

    /* Tên sản phẩm */
    .product-table th:nth-child(3),
    .product-table td:nth-child(3) {
        width: 12% !important;
    }

    /* Danh mục */
    .product-table th:nth-child(4),
    .product-table td:nth-child(4) {
        width: 19% !important;
    }

    /* Bộ sưu tập */
    .product-table th:nth-child(5),
    .product-table td:nth-child(5) {
        width: 18% !important;
    }

    /* Giá */
    .product-table th:nth-child(6),
    .product-table td:nth-child(6) {
        width: 13% !important;
        white-space: nowrap;
    }

    /* Tồn kho */
    .product-table th:nth-child(7),
    .product-table td:nth-child(7) {
        width: 8% !important;
        white-space: nowrap;
    }

    /* Thao tác */
    .product-table th:nth-child(8),
    .product-table td:nth-child(8) {
        width: 15% !important;
        white-space: nowrap;
    }

    /* Ảnh sản phẩm */
    .product-thumbnail {
        display: block;
        width: 75px;
        height: 75px;
        max-width: 100%;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e5e5e5;
        margin: 0 auto;
    }

    /* Tên sản phẩm */
    .product-name {
        font-weight: 600;
        color: #333;
    }

    /* Nút sửa và xóa */
    .product-table .action-icon {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection
