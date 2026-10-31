<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


## Menu danh mục và bộ sưu tập

Thanh điều hướng đã liên kết với bộ lọc sản phẩm:
- Danh mục: Đồ ngủ nam, Đồ ngủ nữ, Đồ ngủ trẻ em, Phụ kiện.
- Bộ sưu tập: BST Tí ta tí tởn, BST Nhí nha nhí nhảnh, BST Tếu ta tếu táo.

Sau khi cập nhật mã nguồn, chạy `php artisan migrate --seed` để thêm cột bộ sưu tập và các danh mục mới. Khi thêm/sửa sản phẩm trong trang Quản trị, chọn đúng danh mục và bộ sưu tập để sản phẩm xuất hiện trong mục tương ứng.

## Biến thể màu sắc và kích thước sản phẩm (Mơ Màng)

- Trong trang Quản trị → Sản phẩm → Thêm/Sửa, thêm từng tổ hợp màu + size, nhập tồn kho và tải ảnh cho màu đó (có thể tải cùng một ảnh cho các size cùng màu).
- Trang chi tiết sản phẩm cho phép khách chọn màu, size; ảnh và tồn kho thay đổi theo biến thể đã chọn.
- Giỏ hàng, checkout và chi tiết đơn hàng lưu đúng màu/size; khi đặt hàng, hệ thống trừ tồn kho của biến thể và cập nhật tồn kho tổng.
- Khi đơn hàng bị hủy trong trang quản trị, hệ thống hoàn lại tồn kho của biến thể.
- Sản phẩm chưa khai báo biến thể vẫn hoạt động theo cơ chế tồn kho chung cũ.

Sau khi cập nhật source, chạy `php artisan migrate` để tạo bảng biến thể và bổ sung thông tin màu/size cho chi tiết đơn hàng. Không chạy `migrate:fresh` vì lệnh đó xóa dữ liệu hiện có. Nếu vừa tải ảnh lên mà ảnh chưa hiển thị, kiểm tra liên kết lưu trữ bằng `php artisan storage:link`.
