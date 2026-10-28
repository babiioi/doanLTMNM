<div class="mb-3">
    <label class="form-label">Tên danh mục *</label>
    <input name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required maxlength="100">
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label class="form-label">Mô tả</label>
    <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>
    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<button class="btn btn-dark">Lưu</button> <a href="{{ route('admin.categories.index') }}" class="btn btn-light">Hủy</a>
