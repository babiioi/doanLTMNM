<div class="mb-3">
<label class="form-label">Danh mục *</label>
<select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
<option value="">-- Chọn danh mục --</option>
@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>@endforeach
</select>
@error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
<label class="form-label">Bộ sưu tập</label>
<select name="collection" class="form-select @error('collection') is-invalid @enderror">
<option value="">-- Không thuộc bộ sưu tập --</option>
@foreach($collections as $item)
<option value="{{ $item->name }}" @selected(old('collection', $product->collection) === $item->name)>{{ $item->name }}</option>
@endforeach
</select>
@error('collection')<div class="invalid-feedback">{{ $message }}</div>@enderror
<div class="form-text">Chọn bộ sưu tập để sản phẩm xuất hiện khi khách nhấn vào mục tương ứng trên menu.</div>
</div>
<div class="mb-3"><label class="form-label">Tên sản phẩm *</label><input name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required maxlength="150">@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Giá gốc (VNĐ) *</label>
        <input
            type="number"
            min="0"
            step="1000"
            name="price"
            class="form-control @error('price') is-invalid @enderror"
            value="{{ old('price', $product->price) }}"
            required
        >
        @error('price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Giá khuyến mãi (VNĐ)</label>
        <input
            type="number"
            min="0"
            step="1000"
            name="sale_price"
            class="form-control @error('sale_price') is-invalid @enderror"
            value="{{ old('sale_price', $product->sale_price) }}"
            placeholder="Để trống nếu không sale"
        >
        @error('sale_price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-text">Giá sale phải thấp hơn giá gốc.</div>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Số lượng tồn kho *</label>
        <input
            type="number"
            min="0"
            name="stock"
            class="form-control @error('stock') is-invalid @enderror"
            value="{{ old('stock', $product->stock ?? 0) }}"
            required
        >
        @error('stock')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="mb-3"><label class="form-label">Mô tả</label><textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>@error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Ảnh sản phẩm (JPG, PNG, WEBP; tối đa 2MB)</label><input type="file" name="image" accept=".jpg,.jpeg,.png,.webp" class="form-control @error('image') is-invalid @enderror">@error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
@if($product->image)<img src="{{ asset('storage/'.$product->image) }}" class="mt-2 rounded" width="120" alt="Ảnh hiện tại">@endif</div>
<button class="btn btn-dark">Lưu sản phẩm</button> <a href="{{ route('admin.products.index') }}" class="btn btn-light">Hủy</a>
