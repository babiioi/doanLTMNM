
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Quản trị cửa hàng thời trang
        </h2>
    </x-slot>

    <div class="py-8" style="background: #f3f4f6; min-height: 80vh;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <h3 class="text-2xl font-bold text-gray-800 mb-2">
                Tổng quan cửa hàng
            </h3>

            <p class="text-gray-500 mb-6">
                Chào mừng bạn đến với hệ thống quản lý cửa hàng thời trang.
            </p>

            {{-- Thống kê --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

                <div class="bg-white p-6 rounded-xl shadow-sm border">
                    <p class="text-gray-500 text-sm">Danh mục</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">
                        {{ $categoryCount }}
                    </h3>
                    <a href="{{ route('admin.categories.index') }}"
                       class="text-sm text-blue-600 mt-4 inline-block">
                        Quản lý danh mục →
                    </a>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border">
                    <p class="text-gray-500 text-sm">Sản phẩm</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">
                        {{ $productCount }}
                    </h3>
                    <a href="{{ route('admin.products.index') }}"
                       class="text-sm text-blue-600 mt-4 inline-block">
                        Quản lý sản phẩm →
                    </a>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border">
                    <p class="text-gray-500 text-sm">Tổng đơn hàng</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">
                        {{ $orderCount }}
                    </h3>
                    <a href="{{ route('admin.orders.index') }}"
                       class="text-sm text-blue-600 mt-4 inline-block">
                        Quản lý đơn hàng →
                    </a>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border">
                    <p class="text-gray-500 text-sm">Đơn chờ xử lý</p>
                    <h3 class="text-3xl font-bold text-orange-500 mt-2">
                        {{ $pendingOrderCount }}
                    </h3>
                    <a href="{{ route('admin.orders.index') }}"
                       class="text-sm text-blue-600 mt-4 inline-block">
                        Kiểm tra đơn hàng →
                    </a>
                </div>

            </div>

            {{-- Truy cập nhanh --}}
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    Truy cập nhanh
                </h3>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.products.index') }}"
                       class="px-5 py-3 rounded-lg text-white"
                       style="background: #4b5563;">
                        + Thêm sản phẩm
                    </a>

                    <a href="{{ route('admin.categories.index') }}"
                       class="px-5 py-3 rounded-lg text-white"
                       style="background: #6b7280;">
                        + Quản lý danh mục
                    </a>

                    <a href="{{ route('admin.orders.index') }}"
                       class="px-5 py-3 rounded-lg text-white"
                       style="background: #374151;">
                        Xem đơn hàng
                    </a>

                    <a href="{{ route('store.home') }}"
                       class="px-5 py-3 rounded-lg border text-gray-700">
                        Xem cửa hàng
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
