<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::query()->orderBy('name')->paginate(10);
        $productCounts = Product::query()->select('collection', DB::raw('COUNT(*) as total'))
            ->whereNotNull('collection')->groupBy('collection')->pluck('total', 'collection');
        return view('admin.collections.index', compact('collections', 'productCounts'));
    }

    public function create()
    {
        return view('admin.collections.create', ['collection' => new Collection()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:collections,name'],
            'description' => ['nullable', 'string', 'max:1000'],
        ], ['name.required' => 'Vui lòng nhập tên bộ sưu tập.', 'name.unique' => 'Tên bộ sưu tập đã tồn tại.']);
        $data['slug'] = $this->uniqueSlug($data['name']);
        Collection::create($data);
        return redirect()->route('admin.collections.index')->with('success', 'Thêm bộ sưu tập thành công.');
    }

    public function edit(Collection $collection)
    {
        return view('admin.collections.edit', compact('collection'));
    }

    public function update(Request $request, Collection $collection)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('collections', 'name')->ignore($collection->id)],
            'description' => ['nullable', 'string', 'max:1000'],
        ], ['name.required' => 'Vui lòng nhập tên bộ sưu tập.', 'name.unique' => 'Tên bộ sưu tập đã tồn tại.']);
        $oldName = $collection->name;
        $data['slug'] = $this->uniqueSlug($data['name'], $collection->id);
        DB::transaction(function () use ($collection, $data, $oldName) {
            $collection->update($data);
            Product::where('collection', $oldName)->update(['collection' => $data['name']]);
        });
        return redirect()->route('admin.collections.index')->with('success', 'Cập nhật bộ sưu tập thành công.');
    }

    public function destroy(Collection $collection)
    {
        DB::transaction(function () use ($collection) {
            Product::where('collection', $collection->name)->update(['collection' => null]);
            $collection->delete();
        });
        return redirect()->route('admin.collections.index')->with('success', 'Đã xóa bộ sưu tập. Sản phẩm thuộc bộ sưu tập này vẫn được giữ lại.');
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        if ($base === '') $base = 'bo-suu-tap';
        $slug = $base;
        $counter = 2;
        while (Collection::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $counter++;
        }
        return $slug;
    }
}
