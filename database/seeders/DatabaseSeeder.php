<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@fashion.test'],
            ['name' => 'Fashion Admin', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'user@fashion.test'],
            ['name' => 'Fashion User', 'password' => Hash::make('password'), 'role' => 'user']
        );

        $data = [
            ['name' => 'Áo thun', 'description' => 'Áo thun mặc hằng ngày'],
            ['name' => 'Áo sơ mi', 'description' => 'Áo sơ mi đi học, đi làm'],
            ['name' => 'Quần jeans', 'description' => 'Quần jeans năng động'],
            ['name' => 'Váy đầm', 'description' => 'Váy đầm thời trang'],
            ['name' => 'Đồ ngủ nam', 'description' => 'Các sản phẩm đồ ngủ dành cho nam'],
            ['name' => 'Đồ ngủ nữ', 'description' => 'Các sản phẩm đồ ngủ dành cho nữ'],
            ['name' => 'Đồ ngủ trẻ em', 'description' => 'Các sản phẩm đồ ngủ dành cho trẻ em'],
            ['name' => 'Phụ kiện', 'description' => 'Phụ kiện thời trang'],
        ];

        foreach ($data as $row) {
            $category = Category::firstOrCreate(['name' => $row['name']], ['description' => $row['description']]);
            $samples = match ($category->name) {
                'Đồ ngủ nam' => [
                    ['name' => 'Bộ đồ ngủ nam cotton', 'price' => 259000, 'description' => 'Bộ đồ ngủ nam cotton mềm mại, thoáng mát.', 'stock' => 20, 'collection' => 'BST Tí ta tí tởn'],
                    ['name' => 'Đồ ngủ nam sọc caro', 'price' => 289000, 'description' => 'Đồ ngủ nam họa tiết caro trẻ trung.', 'stock' => 15, 'collection' => 'BST Tí ta tí tởn'],
                ],
                'Đồ ngủ nữ' => [
                    ['name' => 'Bộ đồ ngủ nữ pastel', 'price' => 279000, 'description' => 'Bộ đồ ngủ nữ tông pastel nhẹ nhàng.', 'stock' => 20, 'collection' => 'BST Nhí nha nhí nhảnh'],
                    ['name' => 'Đồ ngủ nữ tay ngắn', 'price' => 249000, 'description' => 'Thiết kế thoải mái, phù hợp mặc ở nhà.', 'stock' => 18, 'collection' => 'BST Nhí nha nhí nhảnh'],
                ],
                'Đồ ngủ trẻ em' => [
                    ['name' => 'Bộ đồ ngủ trẻ em dễ thương', 'price' => 199000, 'description' => 'Chất vải mềm, phù hợp cho bé.', 'stock' => 25, 'collection' => 'BST Tếu ta tếu táo'],
                    ['name' => 'Đồ ngủ trẻ em họa tiết vui nhộn', 'price' => 219000, 'description' => 'Họa tiết đáng yêu cho bé.', 'stock' => 20, 'collection' => 'BST Tếu ta tếu táo'],
                ],
                'Phụ kiện' => [
                    ['name' => 'Túi vải thời trang', 'price' => 99000, 'description' => 'Túi vải tiện dụng, dễ phối đồ.', 'stock' => 30],
                    ['name' => 'Băng đô vải', 'price' => 59000, 'description' => 'Phụ kiện nhỏ xinh dùng hằng ngày.', 'stock' => 30],
                ],
                default => [
                    ['name' => 'Áo thun basic cotton', 'price' => 129000, 'description' => 'Áo thun cotton mềm mại, dễ phối đồ.', 'stock' => 30],
                    ['name' => 'Áo kiểu thời trang', 'price' => 219000, 'description' => 'Thiết kế hiện đại, phù hợp nhiều dịp.', 'stock' => 18],
                ],
            };
            foreach ($samples as $sample) {
                Product::firstOrCreate(
                    ['category_id' => $category->id, 'name' => $sample['name']],
                    $sample
                );
            }
        }
    }
}
