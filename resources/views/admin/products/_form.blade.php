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

    <div class="col-md-4 mb-3"><label class="form-label">Tồn kho chung của sản phẩm *</label><input type="number" min="0" max="100000" name="stock" class="form-control" value="{{ old('stock', $product->stock ?? 0) }}" required><div class="form-text">Không chia theo màu hoặc size.</div></div>
</div>
<div class="card border mb-3"><div class="card-header bg-light fw-semibold">Màu sắc và 2 ảnh theo màu</div><div class="card-body">
<p class="text-secondary small">Size S, M, L được tạo tự động cho mọi màu. Không cần nhập size hoặc tồn kho riêng cho màu. Thêm từng màu và tải lên hai ảnh của màu đó.</p>
@php
$colorRows = old('colors');
if ($colorRows === null) {
    $colorRows = isset($product) && $product->exists ? $product->variants->groupBy('color')->map(fn($items) => ['name' => $items->first()->color, 'image' => $items->first()->image, 'image_2' => $items->first()->image_2])->values()->all() : [];
}
@endphp
<div id="color-rows">
@foreach($colorRows as $i => $row)
<div class="row g-2 align-items-end border rounded-3 p-2 mb-2 color-row">
<div class="col-md-3"><label class="form-label">Tên màu</label><input name="colors[{{ $i }}][name]" class="form-control" value="{{ $row['name'] ?? '' }}" maxlength="80" required></div>
<div class="col-md-4"><label class="form-label">Ảnh 1</label><input type="file" name="colors[{{ $i }}][image]" accept=".jpg,.jpeg,.png,.webp" class="form-control">@if(!empty($row['image']))<small>Đã có: {{ basename($row['image']) }}</small>@endif</div>
<div class="col-md-4"><label class="form-label">Ảnh 2</label><input type="file" name="colors[{{ $i }}][image_2]" accept=".jpg,.jpeg,.png,.webp" class="form-control">@if(!empty($row['image_2']))<small>Đã có: {{ basename($row['image_2']) }}</small>@endif</div>
<div class="col-md-1"><button type="button" class="btn btn-outline-danger remove-color">×</button></div>
</div>
@endforeach
</div>
<button type="button" class="btn btn-outline-dark btn-sm" id="add-color">+ Thêm màu</button>
@foreach($errors->getMessages() as $field => $messages)
@if(str_starts_with($field, 'colors.'))<div class="text-danger small">{{ implode(' ', $messages) }}</div>@endif
@endforeach
</div></div>
<script>
(()=>{const wrap=document.getElementById('color-rows');let next={{ count($colorRows) }};
document.getElementById('add-color').addEventListener('click',()=>{const i=next++;const row=document.createElement('div');row.className='row g-2 align-items-end border rounded-3 p-2 mb-2 color-row';row.innerHTML=`<div class="col-md-3"><label class="form-label">Tên màu</label><input name="colors[${i}][name]" class="form-control" maxlength="80" required></div><div class="col-md-4"><label class="form-label">Ảnh 1</label><input type="file" name="colors[${i}][image]" accept=".jpg,.jpeg,.png,.webp" class="form-control"></div><div class="col-md-4"><label class="form-label">Ảnh 2</label><input type="file" name="colors[${i}][image_2]" accept=".jpg,.jpeg,.png,.webp" class="form-control"></div><div class="col-md-1"><button type="button" class="btn btn-outline-danger remove-color">×</button></div>`;wrap.appendChild(row)});
wrap.addEventListener('click',e=>{if(e.target.classList.contains('remove-color'))e.target.closest('.color-row').remove()});})();
</script>
<div class="mb-3"><label class="form-label">Mô tả</label><textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>@error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Ảnh sản phẩm (JPG, PNG, WEBP; tối đa 2MB)</label><input type="file" name="image" accept=".jpg,.jpeg,.png,.webp" class="form-control @error('image') is-invalid @enderror">@error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
@if($product->image)<img src="{{ asset('storage/'.$product->image) }}" class="mt-2 rounded" width="120" alt="Ảnh hiện tại">@endif</div>
<button class="btn btn-dark">Lưu sản phẩm</button> <a href="{{ route('admin.products.index') }}" class="btn btn-light">Hủy</a>
