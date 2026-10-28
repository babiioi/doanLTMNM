@extends('admin.layouts.main')
@section('title', 'Quản lý sản phẩm')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3"><h1 class="h3">Sản phẩm</h1><a class="btn btn-dark" href="{{ route('admin.products.create') }}">+ Thêm sản phẩm</a></div>
<form class="row g-2 mb-3">
    <div class="col-md-4"><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Tìm tên sản phẩm"></div>
    <div class="col-md-3"><select class="form-select" name="category_id"><option value="">Tất cả danh mục</option>@foreach($categories as $c)<option value="{{ $c->id }}" @selected(request('category_id') == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-auto"><button class="btn btn-outline-dark">Lọc</button></div>
</form>
<div class="table-responsive bg-white rounded shadow-sm"><table class="table table-hover align-middle mb-0">
<thead><tr><th>#</th><th>Ảnh</th><th>Tên sản phẩm</th><th>Danh mục</th><th>Bộ sưu tập</th><th>Giá</th><th>Tồn kho</th><th class="text-end">Thao tác</th></tr></thead><tbody>
@forelse($products as $product)
<tr><td>{{ $products->firstItem() + $loop->index }}</td><td>@if($product->image)<img src="{{ asset('storage/'.$product->image) }}" alt="" width="56" height="56" style="object-fit:cover">@else—@endif</td><td>{{ $product->name }}</td><td>{{ $product->category?->name }}</td><td>{{ $product->collection ?: '—' }}</td><td>{{ number_format($product->price,0,',','.') }} đ</td><td>{{ $product->stock }}</td><td class="text-end text-nowrap">
<a class="btn btn-sm btn-outline-primary" href="{{ route('admin.products.edit', $product) }}">Sửa</a>
<form class="d-inline" method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Bạn chắc chắn muốn xóa sản phẩm này?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Xóa</button></form>
</td></tr>
@empty<tr><td colspan="8" class="text-center py-4">Chưa có sản phẩm.</td></tr>@endforelse
</tbody></table></div>
<div class="mt-3">{{ $products->links('pagination::bootstrap-5') }}</div>
@endsection
