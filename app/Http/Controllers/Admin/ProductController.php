<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->filled('q'), fn ($q) =>
                $q->where('name', 'like', '%' . $request->q . '%'))
            ->when($request->filled('category_id'), fn ($q) =>
                $q->where('category_id', $request->integer('category_id')))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $collections = Collection::orderBy('name')->get();
        return view('admin.products.create', ['product' => new Product(), 'categories' => $categories, 'collections' => $collections]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:150'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999999'],
            'sale_price' => [
                'nullable',
                'numeric',
                'min:0',
                'lt:price',
            ],
            'description' => ['nullable', 'string', 'max:3000'],
            'stock' => ['required', 'integer', 'min:0', 'max:100000'],
            'collection' => ['nullable', 'string', 'max:100', 'exists:collections,name'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'colors' => ['nullable', 'array'],
            'colors.*.name' => ['required', 'string', 'max:80'],
            'colors.*.image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'colors.*.image_2' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'category_id.exists' => 'Danh mục không hợp lệ.',
            'name.required' => 'Vui lòng nhập tên sản phẩm.',
            'price.required' => 'Vui lòng nhập giá sản phẩm.',
            'price.numeric' => 'Giá phải là số.',
            'price.min' => 'Giá không được âm.',
            'stock.required' => 'Vui lòng nhập số lượng tồn kho.',
            'image.image' => 'Tệp tải lên phải là hình ảnh.',
            'image.mimes' => 'Ảnh chỉ nhận JPG, JPEG, PNG hoặc WEBP.',
            'image.max' => 'Ảnh không được vượt quá 2MB.',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $colors = $data['colors'] ?? [];
        unset($data['colors']);

        DB::transaction(function () use ($data, $colors, &$product) {
            $product = Product::create($data);
            $this->syncColors($product, $colors);
        });

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công.');
    }

    public function show(Product $product)
    {
        return redirect()->route('admin.products.edit', $product);
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $collections = Collection::orderBy('name')->get();
        $product->load('variants');
        return view('admin.products.edit', compact('product', 'categories', 'collections'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:150'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999999'],
            'sale_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'description' => ['nullable', 'string', 'max:3000'],
            'stock' => ['required', 'integer', 'min:0', 'max:100000'],
            'collection' => ['nullable', 'string', 'max:100', 'exists:collections,name'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'colors' => ['nullable', 'array'],
            'colors.*.name' => ['required', 'string', 'max:80'],
            'colors.*.image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'colors.*.image_2' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'name.required' => 'Vui lòng nhập tên sản phẩm.',
            'price.numeric' => 'Giá phải là số.',
            'price.min' => 'Giá không được âm.',
            'image.image' => 'Tệp tải lên phải là hình ảnh.',
            'image.mimes' => 'Ảnh chỉ nhận JPG, JPEG, PNG hoặc WEBP.',
            'image.max' => 'Ảnh không được vượt quá 2MB.',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $colors = $data['colors'] ?? [];
        unset($data['colors']);

        DB::transaction(function () use ($product, $data, $colors) {
            $product->update($data);
            $this->syncColors($product, $colors);
        });

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công.');
    }

    /** Tạo tự động S/M/L cho mỗi màu, không yêu cầu nhập tồn kho. */
    private function syncColors(Product $product, array $rows): void
    {
        $existing = $product->variants()->get();
        $byColor = $existing->groupBy(fn($v) => mb_strtolower(trim($v->color)));
        $seen = [];
        foreach ($rows as $i => $row) {
            $color = trim($row['name'] ?? '');
            $key = mb_strtolower($color);
            if ($color === '' || isset($seen[$key])) {
                throw \Illuminate\Validation\ValidationException::withMessages(["colors.$i.name" => 'Tên màu không được trống hoặc trùng.']);
            }
            $seen[$key] = true;
            $old = $byColor->get($key, collect());
            $first = $old->first();
            $images = ['image' => $first?->image, 'image_2' => $first?->image_2];
            foreach (['image', 'image_2'] as $field) {
                if (request()->hasFile("colors.$i.$field")) {
                    $images[$field] = request()->file("colors.$i.$field")->store('products/variants', 'public');
                }
            }
            foreach (['S', 'M', 'L'] as $size) {
                $variant = $old->first(fn($v) => strtoupper(trim($v->size)) === $size);
                $values = ['color' => $color, 'size' => $size, 'stock' => (int) $product->stock] + $images;
                if ($variant) $variant->update($values);
                else $product->variants()->create($values);
            }
            foreach ($old as $variant) {
                if (!in_array(strtoupper(trim($variant->size)), ['S','M','L'], true)) $variant->delete();
            }
        }
        foreach ($byColor as $key => $items) {
            if (!isset($seen[$key])) foreach ($items as $variant) $variant->delete();
        }
    }

    public function destroy(Product $product)
    {
        foreach ($product->variants as $variant) {
            // Images are shared by color; retain them to avoid breaking other sizes.
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công.');
    }
}
