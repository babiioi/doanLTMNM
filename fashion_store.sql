-- --------------------------------------------------------
-- Máy chủ:                      127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Phiên bản:           12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for fashion_store
CREATE DATABASE IF NOT EXISTS `fashion_store` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `fashion_store`;

-- Dumping structure for table fashion_store.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fashion_store.cache: ~0 rows (approximately)

-- Dumping structure for table fashion_store.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fashion_store.cache_locks: ~0 rows (approximately)

-- Dumping structure for table fashion_store.carts
CREATE TABLE IF NOT EXISTS `carts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fashion_store.carts: ~0 rows (approximately)

-- Dumping structure for table fashion_store.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fashion_store.categories: ~4 rows (approximately)
INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'Đồ ngủ nữ', 'Dịu dàng một chút, đáng yêu một chút, còn lại cứ là chính mình. Mơ Màng cùng nàng biến giờ đi ngủ thành khoảng thời gian êm ái và thoải mái nhất', '2026-10-24 00:16:21', '2026-10-28 10:00:28'),
	(2, 'Đồ ngủ nam', 'Chất riêng trong từng lựa chọn, thoải mái trong từng khoảnh khắc. Mơ Màng đồng hành cùng chàng từ những ngày bận rộn đến những tối thảnh thơi.', '2026-10-24 00:16:21', '2026-10-28 10:06:57'),
	(3, 'Đồ ngủ trẻ em', 'Tinh nghịch một chút, lí lắc một chút, mỗi ngày đều là một cuộc phiêu lưu. Mơ Màng cùng bé biến giờ đi ngủ thành thế giới nhỏ ngập tràn niềm vui và những giấc mơ đầy màu sắc.', '2026-10-24 00:16:21', '2026-10-28 10:07:50'),
	(4, 'Phụ kiện', NULL, '2026-10-24 00:16:21', '2026-10-30 22:14:58');

-- Dumping structure for table fashion_store.collections
CREATE TABLE IF NOT EXISTS `collections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `collections_name_unique` (`name`),
  UNIQUE KEY `collections_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fashion_store.collections: ~6 rows (approximately)
INSERT INTO `collections` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
	(2, 'BST Nhí nha nhí nhảnh', 'bst-nhi-nha-nhi-nhanh', NULL, '2026-10-26 09:25:03', '2026-10-26 09:25:03'),
	(3, 'BST Tếu ta tếu táo', 'bst-teu-ta-teu-tao', NULL, '2026-10-26 09:25:03', '2026-10-26 09:25:03'),
	(4, 'BST Ngày không báo thức', 'bst-ngay-khong-bao-thuc', NULL, '2026-10-28 11:48:33', '2026-10-28 20:39:28'),
	(5, 'BST Đầu óc trên mây', 'bst-dau-oc-tren-may', NULL, '2026-10-28 20:38:28', '2026-10-28 20:39:15'),
	(6, 'BST Ngủ quên mất tiêu', 'bst-ngu-quen-mat-tieu', NULL, '2026-10-28 20:39:02', '2026-10-28 20:39:51'),
	(7, 'BST Chuyện ngày bình thường', 'bst-chuyen-ngay-binh-thuong', NULL, '2026-10-28 20:40:50', '2026-10-28 20:40:50'),
	(8, 'BST Sau giờ tan ca', 'bst-sau-gio-tan-ca', NULL, '2026-10-28 20:41:24', '2026-10-28 20:41:24'),
	(9, 'BST Ở nhà là nhất', 'bst-o-nha-la-nhat', NULL, '2026-10-28 20:42:09', '2026-10-28 20:42:09'),
	(10, 'BST Biệt đội tí hon', 'bst-biet-doi-ti-hon', NULL, '2026-10-28 20:42:47', '2026-10-28 20:42:47'),
	(11, 'BST Lắc la lắc lư', 'bst-lac-la-lac-lu', NULL, '2026-10-28 20:43:04', '2026-10-28 20:43:04'),
	(12, 'BST Bé ngoan đi ngủ', 'bst-be-ngoan-di-ngu', NULL, '2026-10-28 20:43:26', '2026-10-28 20:43:26'),
	(13, 'BST Bịt Mắt Trốn Cả Thế Giới', 'bst-bit-mat-tron-ca-the-gioi', NULL, '2026-10-31 00:34:48', '2026-10-31 01:15:49'),
	(14, 'BST Băng đô của Mơ', 'bst-bang-do-cua-mo', NULL, '2026-10-31 00:54:11', '2026-10-31 01:09:22'),
	(15, 'BST Ếch Ộp Ộp Ộp', 'bst-ech-op-op-op', NULL, '2026-10-31 01:07:29', '2026-10-31 01:08:50'),
	(17, 'BST Đi ngủ cũng ấm', 'bst-di-ngu-cung-am', NULL, '2026-10-31 01:30:59', '2026-10-31 01:30:59');

-- Dumping structure for table fashion_store.contact_messages
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fashion_store.contact_messages: ~0 rows (approximately)

-- Dumping structure for table fashion_store.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fashion_store.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table fashion_store.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fashion_store.jobs: ~0 rows (approximately)

-- Dumping structure for table fashion_store.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fashion_store.job_batches: ~0 rows (approximately)

-- Dumping structure for table fashion_store.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fashion_store.migrations: ~20 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2026_01_01_000001_add_role_to_users_table', 1),
	(5, '2026_01_01_000002_create_categories_table', 1),
	(6, '2026_01_01_000003_create_products_table', 1),
	(7, '2026_10_25_000001_create_orders_table', 2),
	(8, '2026_10_25_000002_create_order_items_table', 2),
	(9, '2026_10_26_000001_add_collection_to_products_table', 3),
	(10, '2026_10_26_000002_create_collections_table', 4),
	(11, '2026_10_27_095421_add_sale_price_to_products_table', 5),
	(12, '2026_10_30_000001_create_product_variants_table', 6),
	(13, '2026_10_30_000002_add_variant_to_order_items_table', 6),
	(14, '2026_10_31_000001_add_second_image_to_product_variants', 7),
	(15, '2026_10_31_090000_create_wishlists_table', 8),
	(16, '2026_10_29_173856_add_shipping_fee_to_orders_table', 9),
	(17, '2026_10_29_180938_add_shipping_fee_to_orders_table', 9),
	(18, '2026_10_29_184344_add_shipping_address_fields_to_users_table', 9),
	(19, '2026_10_30_180210_add_discount_fields_to_orders_table', 9),
	(20, '2026_10_31_134304_create_contact_messages_table', 10),
	(21, '2026_11_02_130022_add_cart_to_users_table', 11),
	(22, '2026_11_02_130418_create_carts_table', 11);

-- Dumping structure for table fashion_store.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `customer_name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_address` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `subtotal` decimal(12,2) NOT NULL,
  `shipping_fee` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total` decimal(12,2) NOT NULL,
  `payment_method` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cod',
  `payment_status` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `status` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `discount_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_user_id_created_at_index` (`user_id`,`created_at`),
  KEY `orders_status_created_at_index` (`status`,`created_at`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fashion_store.orders: ~11 rows (approximately)
INSERT INTO `orders` (`id`, `order_number`, `user_id`, `customer_name`, `customer_phone`, `shipping_address`, `note`, `subtotal`, `shipping_fee`, `total`, `payment_method`, `payment_status`, `status`, `created_at`, `updated_at`, `discount_code`, `discount_amount`) VALUES
	(1, 'FS261025Z9QIGN', 3, 'Bảo Ngọc', '0949675865', '140 Lê Trọng Tấn, phường Tây Thạnh, thành phố Hồ Chí Minh', 'giao vào trọ', 348000.00, 0.00, 348000.00, 'bank_transfer', 'paid', 'completed', '2026-10-25 04:22:51', '2026-11-01 23:04:27', NULL, 0.00),
	(2, 'FS261026VHLAO8', 3, 'Bảo Ngọc', '0949675865', '150 Lê Trọng Tấn', NULL, 219000.00, 0.00, 219000.00, 'bank_transfer', 'paid', 'shipped', '2026-10-26 07:41:55', '2026-10-26 09:31:17', NULL, 0.00),
	(3, 'FS2610296PBL4O', 1, 'Quốc Huy', '0939001799', 'Nguyễn Thị Mỹ Tiên', NULL, 1000000.00, 0.00, 1000000.00, 'bank_transfer', 'unpaid', 'pending', '2026-10-29 08:14:45', '2026-10-29 08:14:45', NULL, 0.00),
	(4, 'FS2610315HHCX9', 1, 'Fashion Admin', '00000985628', 'bsbdndn', NULL, 3038000.00, 0.00, 3038000.00, 'bank_transfer', 'paid', 'completed', '2026-10-30 19:37:44', '2026-11-01 23:04:54', NULL, 0.00),
	(5, 'FS261031XRC32Z', 1, 'Fashion Admin', '0939993443', 'tân khánh đông', NULL, 890000.00, 0.00, 890000.00, 'bank_transfer', 'paid', 'cancelled', '2026-10-30 20:17:00', '2026-11-02 06:14:52', NULL, 0.00),
	(6, 'FS261031W43C2Y', 1, 'Fashion Admin', '093993371', 'Nhà Xuân Tới', NULL, 1000000.00, 0.00, 1000000.00, 'bank_transfer', 'unpaid', 'pending', '2026-10-30 21:14:34', '2026-10-30 21:14:34', NULL, 0.00),
	(7, 'FS2610310F78SW', 1, 'Lê Văn Nâu', '0939001799', '211 Khánh Nghĩa Tân Khánh Đông, Xã Tân Khánh Đông, Thành phố Sa Đéc, Đồng Tháp', NULL, 2389000.00, 30000.00, 2419000.00, 'bank_transfer', 'unpaid', 'pending', '2026-10-31 02:58:02', '2026-10-31 02:58:02', NULL, 0.00),
	(8, 'FS261031FESQBP', 1, 'Lê Văn Nâu', '0939001799', '211 Khánh Nghĩa Tân Khánh Đông, Xã Tân Khánh Đông, Thành phố Sa Đéc, Đồng Tháp', NULL, 99000.00, 30000.00, 129000.00, 'cod', 'paid', 'completed', '2026-10-31 03:25:02', '2026-10-31 10:54:30', NULL, 0.00),
	(9, 'FS261031DZ949S', 1, 'Lê Văn Nâu', '0939001799', '211 Khánh Nghĩa Tân Khánh Đông, Xã Tân Khánh Đông, Thành phố Sa Đéc, Đồng Tháp', NULL, 1000000.00, 30000.00, 1030000.00, 'bank_transfer', 'paid', 'completed', '2026-10-31 03:25:48', '2026-11-01 23:04:43', NULL, 0.00),
	(10, 'FS261031MLG6O3', 4, 'Lê Xuân Tới', '0939993443', '211 Khánh Nghĩa Tân Khánh Đông, Xã Tân Khánh Đông, Thành phố Sa Đéc, Đồng Tháp', NULL, 1180000.00, 30000.00, 1210000.00, 'bank_transfer', 'unpaid', 'pending', '2026-10-31 11:05:31', '2026-10-31 11:05:31', NULL, 0.00),
	(11, 'FS261101NUH40M', 4, 'Lê Thị Kim Xuân', '0939001799', '211 Khánh Nghĩa Tân Khánh Đông, Xã Tân Khánh Đông, Thành phố Sa Đéc, Đồng Tháp', NULL, 490000.00, 30000.00, 520000.00, 'cod', 'unpaid', 'pending', '2026-10-31 23:01:40', '2026-10-31 23:01:40', NULL, 0.00),
	(12, 'FS261102RPF0EU', 3, 'Bảo Ngọc', '0949675865', '127 Lê Lư, Phường Phú Thọ Hòa, Quận Tân Phú, Hồ Chí Minh', NULL, 219000.00, 30000.00, 249000.00, 'cod', 'paid', 'completed', '2026-11-02 06:12:17', '2026-11-02 06:13:14', NULL, 0.00);

-- Dumping structure for table fashion_store.order_items
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `product_variant_id` bigint unsigned DEFAULT NULL,
  `product_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_color` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_size` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_price` decimal(12,2) NOT NULL,
  `quantity` int unsigned NOT NULL,
  `line_total` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  KEY `order_items_product_variant_id_foreign` (`product_variant_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  CONSTRAINT `order_items_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fashion_store.order_items: ~20 rows (approximately)
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_variant_id`, `product_name`, `product_color`, `product_size`, `product_price`, `quantity`, `line_total`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, NULL, 'Áo thun basic cotton', NULL, NULL, 129000.00, 1, 129000.00, '2026-10-25 04:22:51', '2026-10-25 04:22:51'),
	(2, 1, 2, NULL, 'Áo kiểu thời trang', NULL, NULL, 219000.00, 1, 219000.00, '2026-10-25 04:22:51', '2026-10-25 04:22:51'),
	(3, 2, NULL, NULL, 'Áo kiểu thời trang', NULL, NULL, 219000.00, 1, 219000.00, '2026-10-26 07:41:55', '2026-10-26 07:41:55'),
	(4, 3, 40, NULL, 'Bé Hồng Iu Iu', NULL, NULL, 1000000.00, 1, 1000000.00, '2026-10-29 08:14:45', '2026-10-29 08:14:45'),
	(5, 4, 42, NULL, 'Bé Cưng Xanh Lá', NULL, NULL, 679000.00, 2, 1358000.00, '2026-10-30 19:37:44', '2026-10-30 19:37:44'),
	(6, 4, 31, NULL, 'Không Bận Rộn', NULL, NULL, 780000.00, 1, 780000.00, '2026-10-30 19:37:44', '2026-10-30 19:37:44'),
	(7, 4, 45, NULL, 'Cục Cưng Ơi Ngủ Thôi', 'Đỏ', 'S', 900000.00, 1, 900000.00, '2026-10-30 19:37:44', '2026-10-30 19:37:44'),
	(8, 5, 18, NULL, 'Pink Pink Tích Cực', NULL, 'M', 890000.00, 1, 890000.00, '2026-10-30 20:17:00', '2026-10-30 20:17:00'),
	(9, 6, 40, NULL, 'Bé Hồng Iu Iu', NULL, 'M', 1000000.00, 1, 1000000.00, '2026-10-30 21:14:34', '2026-10-30 21:14:34'),
	(10, 7, 34, 70, 'Hơi Khác Một Chút', 'Đen sọc họa tiết', 'L', 1000000.00, 1, 1000000.00, '2026-10-31 02:58:02', '2026-10-31 02:58:02'),
	(11, 7, 51, 203, 'Đô Bi Chấm', 'Xanh bi', NULL, 130000.00, 1, 130000.00, '2026-10-31 02:58:02', '2026-10-31 02:58:02'),
	(12, 7, 52, 205, 'Ếch Ộp Buồn Ngủ Rồi', 'Ếch 1', NULL, 99000.00, 1, 99000.00, '2026-10-31 02:58:02', '2026-10-31 02:58:02'),
	(13, 7, 17, 123, 'Ôm Lấy Giấc Ngủ', 'Xanh kẻ sọc', 'M', 700000.00, 1, 700000.00, '2026-10-31 02:58:02', '2026-10-31 02:58:02'),
	(14, 7, NULL, NULL, 'Bé Xinh Ơi Đi Ngủ', 'Em hồng', NULL, 230000.00, 1, 230000.00, '2026-10-31 02:58:02', '2026-10-31 02:58:02'),
	(15, 7, 49, 196, 'Bebibebu', 'Trắng họa tiết đỏ', NULL, 230000.00, 1, 230000.00, '2026-10-31 02:58:02', '2026-10-31 02:58:02'),
	(16, 8, 52, 205, 'Ếch Ộp Buồn Ngủ Rồi', 'Ếch 1', NULL, 99000.00, 1, 99000.00, '2026-10-31 03:25:02', '2026-10-31 03:25:02'),
	(17, 9, 34, 69, 'Hơi Khác Một Chút', 'Đen sọc họa tiết', 'M', 1000000.00, 1, 1000000.00, '2026-10-31 03:25:48', '2026-10-31 03:25:48'),
	(18, 10, 5, 189, 'Đồ ngủ nữ - Hồng Hết Hôm Nay', 'Đỏ dâu', 'M', 290000.00, 1, 290000.00, '2026-10-31 11:05:31', '2026-10-31 11:05:31'),
	(19, 10, 37, 62, 'Đồ ngủ trẻ em -Bé Nâu Ấm Áp', 'Nâu ấm họa tiết', 'S', 890000.00, 1, 890000.00, '2026-10-31 11:05:31', '2026-10-31 11:05:31'),
	(20, 11, 41, 84, 'Đồ ngủ trẻ em - Bé Xanh Baby Blue', 'Xanh baby kẻ sọc', 'M', 490000.00, 1, 490000.00, '2026-10-31 23:01:40', '2026-10-31 23:01:40'),
	(21, 12, 2, 171, 'Đồ ngủ nữ - Mùa Nắng Đến Rồi', 'Vàng kẻ', 'M', 219000.00, 1, 219000.00, '2026-11-02 06:12:17', '2026-11-02 06:12:17');

-- Dumping structure for table fashion_store.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fashion_store.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table fashion_store.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `sale_price` decimal(12,2) DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock` int unsigned NOT NULL DEFAULT '0',
  `collection` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_name_index` (`name`),
  KEY `products_collection_index` (`collection`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fashion_store.products: ~51 rows (approximately)
INSERT INTO `products` (`id`, `category_id`, `name`, `price`, `sale_price`, `description`, `image`, `stock`, `collection`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Đồ ngủ nữ - Ngày Thảnh Thơi', 129000.00, NULL, 'Họa tiết kết hợp với các đường viền nổi bật tạo cảm giác năng động, có chút tinh nghịch. Mặc ở nhà vẫn thoải mái để thể hiện phong cách thời trang riêng của bạn', 'products/YwfN1abmi5IfLAatKSQuenKrYQnfoLsSemFMiONj.jpg', 5, 'BST Nhí nha nhí nhảnh', '2026-10-24 00:16:21', '2026-10-31 10:50:54'),
	(2, 1, 'Đồ ngủ nữ - Mùa Nắng Đến Rồi', 219000.00, NULL, 'Gam màu ấm áp kết hợp họa tiết sọc tạo vẻ trẻ trung, khác biệt mà không cần quá nhiều chi tiết. Một bộ đồ dành cho những ngày muốn thư giãn thoải mái nhưng vẫn không kém phần thời trang và năng động.', 'products/PSrONoa82xep5rHct1NqvCAcNjkcBOhwsniP6o2b.webp', 16, 'BST Nhí nha nhí nhảnh', '2026-10-24 00:16:21', '2026-11-02 06:12:17'),
	(3, 1, 'Đồ ngủ nữ - Ở Nhà Vẫn Iu', 129000.00, NULL, 'Nền vải cùng đường viền đỏ tạo điểm nhấn đáng yêu và có phần tinh nghịch. Diện ở nhà thật thoải mái, để mỗi tối đều có một chút dễ thương trước khi chìm vào giấc ngủ.', 'products/GTDmiOeH2cziFj3WzsB6DknXfajeqN9QkUTGyHYs.webp', 10, 'BST Nhí nha nhí nhảnh', '2026-10-24 00:16:21', '2026-10-31 10:49:12'),
	(4, 1, 'Đồ ngủ nữ - Mơ Êm', 219000.00, NULL, 'Gam màu thanh lịch, dễ nhìn và không bao giờ quá nổi bật. Một lựa chọn nhẹ nhàng cho những ai yêu thích phong cách tối giản, muốn biến khoảng thời gian ở nhà thành lúc nghỉ ngơi đúng nghĩa.', 'products/026Pn4HJAGbGBmD0e7oXSzVWTd4Zf2i2Ag2yHopX.jpg', 18, 'BST Ngủ quên mất tiêu', '2026-10-24 00:16:21', '2026-10-31 10:51:40'),
	(5, 1, 'Đồ ngủ nữ - Hồng Hết Hôm Nay', 290000.00, NULL, 'Nhẹ nhàng và dễ thương, mẫu đồ ngủ này dành cho những ngày chỉ muốn sống chậm hơn thường lệ. Tận hưởng cảm giác thoải mái khi đọc vài trang sách, nghe một bản nhạc yêu thích hoặc đơn giản là nằm nghỉ.', 'products/9oMYzzt8JLMTJOuYgTrpPaLLekTAQyz9AWD6GIuN.webp', 29, 'BST Ngủ quên mất tiêu', '2026-10-24 00:16:21', '2026-10-31 11:05:31'),
	(9, 1, 'Đồ ngủ nữ - Chốn Vào Chăn Ngủ', 310000.00, NULL, 'Sắc đỏ đô nổi bật cùng kiểu dáng gọn gàng tạo nên vẻ cá tính mà vẫn thoải mái. Dành cho những cô nàng thích có gu riêng, kể cả lúc ở nhà và chẳng có kế hoạch đi đâu.', 'products/HiudvsNJIG2cj47UbYInrq3XeMuQq8nEdhXtLcTi.webp', 21, 'BST Nhí nha nhí nhảnh', '2026-10-26 06:38:09', '2026-11-01 00:28:46'),
	(10, 1, 'Đồ ngủ nữ - Sáng Nay Được Nghỉ', 550000.00, NULL, 'Sắc màu ngọt ngào khiến những ngày nghỉ ngơi thêm dễ thương. Một bộ đồ dành cho những ngày chỉ muốn nằm dài, nghe nhạc và tận hưởng sự thoải mái theo cách riêng.', 'products/V5QfMKQOJLmRxM0Kk6ZV9acge2tOgHQAkP5Grsnf.webp', 19, 'BST Ngày không báo thức', '2026-10-28 11:51:21', '2026-10-31 10:50:29'),
	(11, 1, 'Đồ ngủ nữ - Không Vội Đâu', 700000.00, NULL, 'Gam xanh dịu mắt kết hợp họa tiết mang đến cảm giác gần gũi và thư thái. Mặc vào những tối cần nghỉ ngơi, tạm gác chuyện ngoài kia để dành thời gian chăm sóc bản thân.', 'products/DZgC84qhRzNjxQi5DCDEJQm5VlfFA3CQMRRKl69z.jpg', 5, 'BST Ngày không báo thức', '2026-10-28 11:53:28', '2026-11-01 00:28:25'),
	(12, 1, 'Đồ ngủ nữ - Ngủ Thêm Tí Đi', 450000.00, NULL, 'Chút sắc hồng để phòng ngủ thêm tươi tắn. Thiết kế mang vẻ nữ tính nhưng không quá điệu, phù hợp cho những buổi tối thư giãn và những sáng cuối tuần thong thả.', 'products/zsXOzTPNzOA8XvVYK6qGOFflAFSP5V3iyU5ckGPl.webp', 12, 'BST Ngày không báo thức', '2026-10-28 11:57:18', '2026-11-01 00:24:54'),
	(13, 1, 'Đồ ngủ nữ - Yên Giấc Ngủ Ngon', 540000.00, NULL, 'Tối giản, sáng sủa và dễ mặc, sắc trắng chấm bi mang lại vẻ nhẹ nhàng mà vẫn có nét đáng yêu. Một lựa chọn dành cho những ai thích sự gọn gàng, thoải mái và không cần cầu kỳ mà vẫn nổi bật', 'products/ssUsndwXXOy8DDSVeX5pe7xtKOsYtLsGk74K9CB1.webp', 16, 'BST Ngày không báo thức', '2026-10-28 11:59:06', '2026-10-31 10:49:44'),
	(14, 1, 'Đồ ngủ nữ - Hôm Nay Lười Xíu', 350000.00, NULL, 'Deadline ngoài kia cứ để ngoài kia! Về nhà là lúc thay đồ, thả lỏng và dành thời gian cho bản thân. Thiết kế mang tinh thần trẻ trung, gần gũi, phù hợp cho những buổi tối nghỉ ngơi hay cuối tuần lười biếng. Đôi khi, không làm gì cả cũng là một kế hoạch tuyệt vời.', 'products/rMsTDDx1j3R9KaLv6hx3BS7kt047hafThwWIzqfM.webp', 29, 'BST Ngủ quên mất tiêu', '2026-10-28 21:17:23', '2026-11-01 00:24:28'),
	(15, 1, 'Đồ ngủ nữ - Ngủ Ngon Là Đủ', 670000.00, 450000.00, 'Không cần một ngày thật hoàn hảo, chỉ cần tối nay được nghỉ ngơi thật yên bình. Với tinh thần nhẹ nhàng và gần gũi, bộ đồ ngủ này gợi nhắc bạn rằng chăm sóc bản thân có thể bắt đầu từ những điều giản dị nhất: mặc thứ mình thích, nghỉ khi thấy mệt và ngủ một giấc thật ngon.', 'products/81fYN0ZgNkC6xqJcsJ77FyLWPqwmigk8roEDvdkr.webp', 2, 'BST Ngủ quên mất tiêu', '2026-10-28 21:19:58', '2026-11-01 23:02:36'),
	(16, 1, 'Đồ ngủ nữ - Tím Tím Thảnh Thơi', 700000.00, NULL, 'Khép lại hôm nay bằng một chút thoải mái, để ngày mai bắt đầu với nguồn năng lượng mới. Dành cho những buổi tối muốn gác lại lo toan, tận hưởng thời gian ở nhà và chuẩn bị cho một ngày mới theo cách nhẹ nhàng nhất. Chúc bạn ngủ ngon và mai lại có thêm nhiều điều vui nhé!', 'products/EPiyWQUMUCrEmRKAaFwM3z8SkHF0HiPmIJn38k4G.webp', 32, 'BST Đầu óc trên mây', '2026-10-28 21:24:57', '2026-10-31 10:48:45'),
	(17, 1, 'Đồ ngủ nữ - Ôm Lấy Giấc Ngủ', 700000.00, 421000.00, 'Sắc xanh mát mắt cùng họa tiết sọc tạo cảm giác tươi mới, nhẹ nhàng. Một người bạn đồng hành cho những buổi tối thư giãn, giúp bạn tạm quên deadline và tận hưởng thời gian của riêng mình.', 'products/DqhFV61HZkSodNnOZ77m7n1lg7Nnq5NyzsAiH9rN.webp', 2, 'BST Đầu óc trên mây', '2026-10-28 21:26:36', '2026-11-01 23:02:19'),
	(18, 1, 'Đồ ngủ nữ - Pink Pink Coco', 890000.00, NULL, 'Gam hồng tươi tắn giúp bộ đồ thêm nổi bật và tràn đầy sức sống. Dành cho những cô nàng thích sự đáng yêu, muốn bắt đầu buổi sáng thật nhẹ nhàng và kết thúc ngày dài bằng một tâm trạng dễ chịu.', 'products/p3c6rbKjkdGMJLmIXXTT3vwrRlmdjK6LQE5EPFFl.webp', 6, 'BST Đầu óc trên mây', '2026-10-28 21:28:24', '2026-11-02 06:14:52'),
	(19, 1, 'Đồ ngủ nữ - Tím Iu Tím Iu', 450000.00, NULL, 'Sắc tím dịu dàng kết hợp họa tiết sọc mang  mơ mộng nhưng không quá điệu đà. Mặc vào những ngày muốn sống chậm, tự thưởng cho mình một buổi tối bình yên và nhớ rằng nghỉ ngơi cũng là một cách yêu thương bản thân đấy nhé.', 'products/SJgTAaCyqwMjPNEg7dWuWLust8jaVdShsKkM5CiS.webp', 20, 'BST Đầu óc trên mây', '2026-10-28 21:30:44', '2026-10-31 10:47:32'),
	(20, 2, 'Đồ ngủ nam - Khoảng Riêng', 670000.00, 429000.00, 'Phom dáng thoải mái kết hợp màu sắc nhẹ nhàng tạo cảm giác thư thái, phù hợp cho những buổi tối nghỉ ngơi sau ngày dài. Một thiết kế dành cho người thích sự đơn giản nhưng vẫn có nét riêng.', 'products/JQNsW8USY5Nv6w56hCUFjinPkx1JXcPh9382lnKj.webp', 1, 'BST Sau giờ tan ca', '2026-10-28 21:44:28', '2026-11-01 23:02:03'),
	(21, 2, 'Đồ ngủ nam - Hãy Chăm Thư Giãn', 650000.00, NULL, 'Họa tiết sọc tạo điểm nhấn vừa đủ, giúp bộ đồ giữ được nét trẻ trung lại rất khác biệt. Phù hợp cho những ngày muốn tận hưởng không gian riêng và nghỉ ngơi thật thoải mái.', 'products/4I8dJ11LSX50o5bGMMET6y4AiZC2bpDZieCzyDT1.webp', 5, 'BST Sau giờ tan ca', '2026-10-28 21:47:16', '2026-11-01 00:22:38'),
	(22, 2, 'Đồ ngủ nam - Ở Nhà', 456000.00, NULL, 'Không ép bản thân phải luôn hoàn hảo. Không cần gồng lên để chứng minh điều gì. Với chất liệu là Linen thoáng mát có độ rũ mềm mại. Giống như cách bạn cho mình một khoảng không vừa đủ.', 'products/lVNr4zeU8BtTgA4i7kvJVUgm9KUgOk5MVYmeCUL8.webp', 13, 'BST Sau giờ tan ca', '2026-10-28 21:51:56', '2026-10-31 10:46:23'),
	(23, 2, 'Đồ ngủ nam - Nâu Cuối Tuần', 430000.00, NULL, 'Họa tiết caro tông nâu tạo vẻ ngoài gần gũi, có chút cổ điển nhưng vẫn trẻ trung. Sự kết hợp giữa họa tiết quen thuộc và phom dáng thoải mái mang đến cảm giác tuy giản dị dễ mặc nhưng vẫn toát ra vibe riêng biệt.', 'products/QFGZfrDA04bfM8hbdzjplq12mCkcyUWqJ3jtx905.webp', 1, 'BST Sau giờ tan ca', '2026-10-28 21:55:02', '2026-11-01 00:21:48'),
	(24, 2, 'Đồ ngủ nam - Mặc Là Mê', 700000.00, NULL, 'Bộ đồ ngủ với thiết kế áo dài tay cài nút và quần dài đồng bộ. Gam màu trung tính tạo vẻ ngoài thanh lịch, dễ phối và không lỗi mốt. Phù hợp cho những chàng trai yêu thích phong cách tối giản, muốn giữ sự gọn gàng ngay cả trong những ngày chỉ ở nhà.', 'products/huCBk2R3oew7N4i5UzhbSRYDtVp9UqXHSagI2ASu.webp', 9, 'BST Ở nhà là nhất', '2026-10-28 21:57:55', '2026-11-01 00:20:56'),
	(25, 2, 'Đồ ngủ nam - Góc Nhà', 700000.00, NULL, 'Màu trầm mang đến cảm giác ấm áp và gần gũi. Thiết kế áo cài nút phối quần dài đồng bộ tạo tổng thể đơn giản, nam tính và phù hợp với nhiều khoảnh khắc sinh hoạt tại nhà. Mẫu đồ hướng đến sự thoải mái, giúp bạn tận hưởng khoảng thời gian nghỉ ngơi theo cách riêng.', 'products/3YmnL8NcVBXq16Bp4aFMWkmLlfxIBf08zSWffhXk.webp', 34, 'BST Ở nhà là nhất', '2026-10-28 21:59:33', '2026-10-31 10:45:37'),
	(26, 2, 'Đồ ngủ nam - Thư Thái Cuối Tuần', 340000.00, NULL, 'Tông trắng sáng kết hợp phom áo cài nút và quần dài tạo nên thiết kế tối giản, thanh lịch. Không cần nhiều chi tiết cầu kỳ, bộ đồ vẫn mang nét chỉn chu và hiện đại. Phù hợp cho những ngày thư giãn, đọc sách, xem phim hoặc dành thời gian bên gia đình.', 'products/E4tHBZZogHPtp0C1ofDulEQ80bGW8OKVvY5VxPtl.jpg', 32, 'BST Ở nhà là nhất', '2026-10-28 22:02:07', '2026-10-31 10:45:25'),
	(27, 2, 'Đồ ngủ nam - Cá Tính Chất Riêng', 500000.00, NULL, 'Bộ đồ ngủ mang vẻ ngoài hiện đại, nam tính và dễ mặc. Thiết kế áo dài tay phối quần dài đồng bộ tạo sự thống nhất, phù hợp với người yêu thích gam màu cơ bản và phong cách tối giản. Một lựa chọn để nghỉ ngơi thoải mái mà vẫn giữ được nét cá tính riêng.', 'products/tQVFpTXF4PB9nDJ7BV10P1TcIzxqsndc2Au3JDQS.webp', 15, 'BST Ở nhà là nhất', '2026-10-28 22:03:35', '2026-11-01 00:20:31'),
	(28, 2, 'Đồ ngủ nam - Chẳng Có Gì Vội', 400000.00, NULL, 'Sắc hồng dịu nhẹ tạo cảm giác tươi mới lạ mà không mất đi nét hiện đại. Một bộ đồ dành cho những ngày bình thường, khi chàng chỉ muốn ở nhà, thư giãn và tận hưởng nhịp sống riêng.', 'products/7X57lJaPptcvLamYUf6IgFvOhEyZtMJkhZ3DID5e.jpg', 20, 'BST Chuyện ngày bình thường', '2026-10-28 22:20:58', '2026-10-31 10:44:43'),
	(29, 2, 'Đồ ngủ nam - Sáng Nay Trời Đẹp', 360000.00, NULL, 'Gam xanh trong trẻo cùng kiểu dáng tối giản mang đến cảm giác thoáng đãng, dễ chịu. Như một buổi sáng không cần vội vàng, chỉ cần bắt đầu ngày mới theo cách mình thích.', 'products/q2AHIHiPZlaDGssPepKuLvEHaCl26gbRWZ6oHsag.jpg', 2, 'BST Chuyện ngày bình thường', '2026-10-28 22:22:29', '2026-11-01 00:18:53'),
	(30, 2, 'Đồ ngủ nam - Thư Giản Ngày Nghỉ', 345000.00, NULL, 'Màu sắc trang nhã dịu mắt đem đến cảm giác tươi mát và thư thái. Thiết kế dành cho những buổi tối ở nhà, xem một bộ phim hay đơn giản là nằm dài nghỉ ngơi.', 'products/Iakc4kSiKi4tcgaMJEAFNQt3uiCcfSd9SQO2zOAg.webp', 13, 'BST Chuyện ngày bình thường', '2026-10-28 22:25:12', '2026-11-01 00:18:22'),
	(31, 2, 'Đồ ngủ nam - Không Bận Rộn', 780000.00, NULL, 'Họa tiết sọc  trẻ trung, kiểu dáng cổ điển nhưng không nhàm chán. Một bộ đồ dành cho những ngày muốn tạm gác công việc sang một bên và nghỉ ngơi đúng nghĩa.', 'products/NbhCcDOrXqyz5l8PWl4Zjry2BRNoT6Os4R0p3JED.webp', 1, 'BST Chuyện ngày bình thường', '2026-10-28 22:27:20', '2026-10-31 10:43:48'),
	(32, 2, 'Đồ ngủ nam - Về Nhà Thôi', 250000.00, NULL, 'Sắc đỏ rượu vang trầm ấm tạo nên vẻ ngoài trưởng thành, sang trọng cuốn hút. Chất liệu nhẹ nhàng, phom dáng chỉn chu lịch lãm kết hợp cùng thiết kế trẻ trung thời trang rất phù hợp dành cho khoảng thời gian kết thúc một ngày bận rộn, trở về nhà và tận hưởng sự thoải mái', 'products/lS1Wo1lllIyqV7VpVjuePHc2Thp3imxBaaZbRUoq.webp', 12, 'BST Tếu ta tếu táo', '2026-10-28 22:49:40', '2026-11-01 00:17:59'),
	(33, 2, 'Đồ ngủ nam - Thu Đến Rồi Mơ', 500000.00, NULL, 'Sắc nâu chocolate trầm ấm mang đến cảm giác gần gũi và dễ chịu. Thiết kế thanh lịch cùng chất vải mềm mại khiến những buổi tối bình thường cũng trở nên thật đặc biệt, như cảm giác được trở về nhà sau một ngày dài.', 'products/AtrT5vcWAxFSl22aHX7QP4mtC4OR6ZqFlRZJ52JT.webp', 5, 'BST Tếu ta tếu táo', '2026-10-28 23:08:07', '2026-10-31 10:43:10'),
	(34, 2, 'Đồ ngủ nam - Hơi Khác Một Chút', 1000000.00, NULL, 'Sắc đen tối giản kết hợp chất mềm mượt tạo vẻ bí ẩn, nam tính và đầy cuốn hút, cổ áo cách điệu tạo điểm nhấn khác biệt. Thiết kế dành cho chàng trai yêu thích sự tinh tế, quyến rũ nhưng không cần phô trương.', 'products/EgfY1fWH57fJEjjMG0IwfFMiNSks0oKLia6Ai1AL.webp', 6, 'BST Tếu ta tếu táo', '2026-10-28 23:12:10', '2026-11-01 00:16:51'),
	(35, 2, 'Đồ ngủ nam - Vội Vàng Làm Chi Zậy', 580000.00, NULL, 'Màu trắng tinh khôi kết hợp kiểu dáng tối giản tạo nên vẻ ngoài nhẹ nhàng và gần gũi. Chất vải mềm mại cùng những đường nét tinh tế mang đến cảm giác dễ chịu, như một buổi sáng chậm rãi chẳng cần vội vàng.', 'products/ElMpdt9EMvSCIhpv8Ng77u9sKRH1ZSRG9OeY3CTy.jpg', 2, 'BST Tếu ta tếu táo', '2026-10-28 23:14:17', '2026-10-31 10:41:05'),
	(36, 3, 'Đồ ngủ trẻ em - Bé Đô Tinh Nghịch', 680000.00, NULL, 'Sắc đỏ nổi bật kết hợp cùng những đường kẻ nhỏ, thưa tạo nên vẻ ngoài gọn gàng mà vẫn trẻ trung. Thiết kế đơn giản, năng động, mang đến cho bé diện mạo đáng yêu và thoải mái trong từng khoảnh khắc vui chơi hay nghỉ ngơi.', 'products/aVTth4xEqeT12rcQRYPToAiTL05eSF0cMQiFkBBd.jpg', 3, 'BST Lắc la lắc lư', '2026-10-28 23:32:27', '2026-10-31 10:40:40'),
	(37, 3, 'Đồ ngủ trẻ em -Bé Nâu Ấm Áp', 890000.00, NULL, 'Sắc nâu ấm áp kết hợp cùng những họa tiết nhỏ xinh tạo nên vẻ ngoài đáng yêu và gần gũi. Thiết kế mang nét tinh nghịch, trẻ trung, giúp bé luôn thoải mái và vui vẻ trong những khoảnh khắc vui chơi hay giờ đi ngủ cùng Mơ Màng', 'products/yNIY8b7v5G5cfnIZqfuXjgQ9NpMQsoWVEKQTjHa5.webp', 3, 'BST Lắc la lắc lư', '2026-10-28 23:34:35', '2026-11-01 00:16:03'),
	(38, 3, 'Đồ ngủ trẻ em - Bé Rô Nhí Nhảnh', 568000.00, NULL, 'Sự kết hợp giữa sắc đỏ nổi bật và xám hiện đại cùng họa tiết caro kinh điển tạo nên vẻ ngoài vừa cá tính vừa đáng yêu. Thiết kế trẻ trung, năng động, giúp bé thoải mái vui chơi và tận hưởng những giây phút nghỉ ngơi thật vui vẻ cùng Mơ Màng', 'products/C5vn82sciiSTNiTpzcp2WHeIuvsCfE0P3OaUdCvm.jpg', 10, 'BST Lắc la lắc lư', '2026-10-28 23:36:42', '2026-11-01 00:15:39'),
	(39, 3, 'Đồ ngủ trẻ em - Bé Xanh Lém Lỉnh', 450000.00, 302000.00, 'Sắc xanh đen trầm mạnh mẽ mang đến vẻ ngoài cá tính và hiện đại. Thiết kế đơn giản nhưng vẫn nổi bật, phù hợp với những em bé yêu năng động, tinh nghịch, giúp bé thoải mái vui chơi và nghỉ ngơi mỗi ngày', 'products/iLKuOKzbjQlS5IP2sF2G3C35AggJ4bxj8YhUBTiS.webp', 2, 'BST Lắc la lắc lư', '2026-10-28 23:39:24', '2026-11-01 23:01:48'),
	(40, 3, 'Đồ ngủ trẻ em - Bé Hồng Iu Iu', 350000.00, 250000.00, 'Sắc hồng ngọt ngào kết hợp cùng họa tiết sọc kẻ xinh xắn tạo nên vẻ ngoài đáng yêu, tươi tắn. Một chút nhí nhảnh, một chút dễ thương, Mơ Màng mang đến cho bé bộ đồ ngủ thật xinh để mỗi ngày đều ngập tràn niềm vui và những giấc mơ ngọt ngào.', 'products/AhsHRi23xq3UETMwehNTYvT4mxoDx8xpjsbF3rir.webp', 4, 'BST Bé ngoan đi ngủ', '2026-10-28 23:41:24', '2026-11-01 23:01:28'),
	(41, 3, 'Đồ ngủ trẻ em - Bé Xanh Baby Blue', 490000.00, NULL, 'Sắc xanh baby blue dịu mắt kết hợp cùng họa tiết sọc kẻ xinh xắn tạo nên vẻ ngoài tươi sáng và đáng yêu. Trẻ trung, tinh nghịch mà vẫn nhẹ nhàng, bộ đồ ngủ giúp bé thoải mái vui chơi, nghỉ ngơi và tận hưởng những giấc mơ thật đẹp', 'products/OlTcx9KyfHQoV9XptkqmeKGZFyUfjZHjwgHgDGGE.webp', 10, 'BST Bé ngoan đi ngủ', '2026-10-28 23:44:13', '2026-10-31 23:01:40'),
	(42, 3, 'Đồ ngủ trẻ em - Bé Cưng Xanh Lá', 679000.00, NULL, 'Sắc xanh mint tươi mát kết hợp cùng họa tiết sọc kẻ xinh xắn tạo nên vẻ ngoài trẻ trung và đáng yêu. Nhẹ tênh đi ngủ mang đến cảm giác thoải mái, giúp bé thoải mái tận hưởng từng khoảnh khắc vui chơi', 'products/8t0e6w6yZdBwyGFBSpmfizVambCOj4R0CM4qNibQ.jpg', 15, 'BST Bé ngoan đi ngủ', '2026-10-28 23:46:42', '2026-11-01 00:14:37'),
	(43, 3, 'Đồ ngủ trẻ em - Bé Xám Nhí', 500000.00, NULL, 'Sắc xám nhẹ nhàng mang nét hiện đại, kết hợp cùng họa tiết sọc kẻ xinh xắn tạo nên vẻ ngoài đơn giản mà đáng yêu. Không quá cầu kỳ nhưng vẫn thật nổi bật, giúp bé thoải mái vui chơi, nghỉ ngơi thật xinh xắn nắng động', 'products/2Nbp5wh2BnC4BFeYWlByD0QEcJmFhufrUSbtzR5d.jpg', 20, 'BST Bé ngoan đi ngủ', '2026-10-28 23:48:47', '2026-10-31 10:36:01'),
	(44, 3, 'Đồ ngủ trẻ em - Bé Dâu Xứ Sở Babu', 900000.00, 434000.00, 'Sắc đỏ tươi tắn mang đến vẻ ngoài đáng yêu và tràn đầy sức sống. Nổi bật mà vẫn ngọt ngào, bộ đồ ngủ giúp bé thêm xinh xắn, thoải mái vui chơi và biến mỗi ngày thành những khoảnh khắc tuổi thơ đầy tiếng cười cùng Mơ Màng', 'products/Px6sMVMM5dbpRaLIWFeYi6TMMGbd4hgkD0uiK1IK.webp', 3, 'BST Biệt đội tí hon', '2026-10-28 23:51:29', '2026-11-01 23:01:00'),
	(45, 3, 'Đồ ngủ trẻ em - Cục Cưng Ơi Ngủ Thôi', 144000.00, NULL, 'Sắc đỏ tươi tắn cùng họa tiết sọc kẻ xinh xắn tạo nên vẻ ngoài yêu ơi là yêu! Một chút tinh nghịch, một chút ngọt ngào, bộ đồ ngủ khiến bé thêm đáng yêu và mang đến thật nhiều niềm vui trong những khoảnh khắc thường ngày cùng Mơ Màng', 'products/uNZJcswuSbAGxTTDCF5MJzCohxhLbVEtE1Vb6sM2.webp', 9, 'BST Biệt đội tí hon', '2026-10-28 23:52:57', '2026-10-31 23:55:44'),
	(46, 4, 'Phụ kiện - Bịch mắt Tím tíu tìu tiu', 320000.00, NULL, 'Sắc tím ngọt ngào mang đến nét đáng yêu và một chút mơ màng cho những giờ phút nghỉ ngơi. Chiếc bịt mắt nhỏ xinh vừa tiện lợi, vừa là điểm nhấn dễ thương cho góc ngủ của bạn. Cùng Mơ Màng khép lại ngày dài, gác lại những bộn bề và chìm vào những giấc mơ thật đẹp nhé!', 'products/x9LjmNNAR3eSU7UPLG0UrRToB7CThU4f2l2AqWIr.jpg', 11, 'BST Bịt Mắt Trốn Cả Thế Giới', '2026-10-29 08:24:10', '2026-11-01 00:11:20'),
	(47, 4, 'Phụ kiện - Bịt mắt Ngủ Một Chút', 230000.00, NULL, 'Mang sắc xanh tươi mát, chiếc bịt mắt nhỏ xinh như một chiếc lá non, thổi làn gió dịu dàng vào góc nghỉ ngơi của bạn. Gác lại những bộn bề, bịt mắt lại và cho bản thân một khoảng trời riêng để thư giãn, mơ mộng và nạp đầy năng lượng cho ngày mới cùng Mơ Màng.', 'products/bqNxybvO3d9MYqdsFkbFQu18oIOlVhX49kqx8y02.webp', 12, 'BST Bịt Mắt Trốn Cả Thế Giới', '2026-10-29 08:26:14', '2026-11-01 00:11:12'),
	(48, 4, 'Phụ kiện - Bịt mắt Ngủ Thui', 280000.00, NULL, 'Một chút bí ẩn, một chút cá tính, chiếc bịt mắt màu đen là lựa chọn dành cho những ai muốn tạm gác lại thế giới bận rộn để tận hưởng khoảng trời riêng. Thiết kế đơn giản, dễ phối cùng đồ ngủ yêu thích, giúp góc nghỉ ngơi thêm chất và những phút giây thư giãn thêm trọn vẹn cùng Mơ Màng.', 'products/TVD99GBx7RqQUBgMt8yG905VkAugrkQgqRMvLV92.webp', 16, 'BST Bịt Mắt Trốn Cả Thế Giới', '2026-10-29 08:29:10', '2026-11-01 00:11:04'),
	(49, 4, 'Phụ kiện - Bịt mắt Bibubiba', 230000.00, NULL, 'Nhẹ nhàng như một đám mây nhỏ, bịt mắt ngủ màu trắng mang đến cảm giác tinh khôi, dịu dàng và thư thái. Sắc trắng thanh lịch, dễ thương, là người bạn đồng hành lý tưởng cho những giấc ngủ bình yên. Cùng Mơ Màng gác lại mọi bộn bề và tận hưởng chút thời gian thật êm ái dành riêng cho mình nhé!', 'products/yZbs85uGJtuNQGMyITjziykBy6IcCBSl0C2fVEXY.jpg', 12, 'BST Bịt Mắt Trốn Cả Thế Giới', '2026-10-31 00:45:51', '2026-11-01 00:10:55'),
	(50, 4, 'Phụ kiện - Bịt mắt Ngủ Rồi Trời Ơi', 200000.00, NULL, NULL, 'products/X0vDq0GjpLWUEaEhz4Ae4vvtf2rvDwauZhAJ1dkL.webp', 15, 'BST Bịt Mắt Trốn Cả Thế Giới', '2026-10-31 00:47:49', '2026-11-01 00:10:27'),
	(51, 4, 'Phụ kiện - Băng đô Đô Bi Chấm', 130000.00, NULL, 'Một chút chấm bi tinh nghịch, một chút đáng yêu cho giấc ngủ thêm ngọt ngào! họa tiết chấm bi mang nét trẻ trung, xinh xắn. Cùng Mơ Màng tạm gác những bộn bề và chìm vào giấc ngủ thật êm nhé!', 'products/xZgczEJ2GG1YZaWIMRELGrAYLNvkv074hhLY8HZa.webp', 4, 'BST Băng đô của Mơ', '2026-10-31 00:59:07', '2026-11-01 00:10:19'),
	(52, 4, 'Phụ kiện - Băng đô Ếch Ộp Buồn Ngủ Rồi', 99000.00, NULL, 'Ộp ộp! Chú ếch nhỏ cũng đến giờ đi ngủ rồi đây! Chiếc băng đô hình ếch xanh ngộ nghĩnh giúp giữ mái tóc gọn gàng trong lúc chăm sóc da trước giờ ngủ. Một chút đáng yêu cho thói quen mỗi tối, để bạn thư giãn, tạm biệt ngày dài và sẵn sàng bước vào những giấc mơ ngọt ngào cùng Mơ Màng!', 'products/tzeGybp4DKyUn6ptvZ52XT7wWcORR06J9IjtZIjw.webp', 19, 'BST Ếch Ộp Ộp Ộp', '2026-10-31 01:13:15', '2026-11-01 00:10:10'),
	(54, 4, 'Phụ kiện - Tất Đi Ngủ', 80000.00, NULL, 'Đôi chân cũng cần được vỗ về sau một ngày dài chứ nhỉ? Những đôi tất ngủ mềm mại, êm ái giúp giữ ấm đôi chân, mang đến cảm giác dễ chịu trong từng khoảnh khắc nghỉ ngơi. Dù là cuộn mình trong chăn hay tận hưởng một tối lười biếng, hãy để Mơ Màng cùng bạn giữ chút ấm áp và sẵn sàng cho những giấc mơ thật ngọt ngào nhé!', 'products/9VZijQ1GedpKtNFbjqcaNQpfC0NXWMBJMFAF1Z5V.webp', 9, 'BST Đi ngủ cũng ấm', '2026-10-31 01:34:15', '2026-11-01 00:09:53');

-- Dumping structure for table fashion_store.product_variants
CREATE TABLE IF NOT EXISTS `product_variants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `color` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_variants_product_id_color_size_unique` (`product_id`,`color`,`size`),
  KEY `product_variants_product_id_color_index` (`product_id`,`color`),
  CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=215 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fashion_store.product_variants: ~171 rows (approximately)
INSERT INTO `product_variants` (`id`, `product_id`, `color`, `size`, `image`, `image_2`, `stock`, `created_at`, `updated_at`) VALUES
	(20, 38, 'Caro đỏ', 'S', 'products/variants/Rjb0aY46vJYSKiPLyhmJNa5668tXm5B0Xd3ujZe3.webp', 'products/variants/zuYIkzdhPOmx2DL2j1U4dpd7rxQhXoeTLfFuXiw7.jpg', 10, '2026-10-30 22:21:32', '2026-10-30 22:21:32'),
	(21, 38, 'Caro đỏ', 'M', 'products/variants/Rjb0aY46vJYSKiPLyhmJNa5668tXm5B0Xd3ujZe3.webp', 'products/variants/zuYIkzdhPOmx2DL2j1U4dpd7rxQhXoeTLfFuXiw7.jpg', 10, '2026-10-30 22:21:32', '2026-10-30 22:21:32'),
	(22, 38, 'Caro đỏ', 'L', 'products/variants/Rjb0aY46vJYSKiPLyhmJNa5668tXm5B0Xd3ujZe3.webp', 'products/variants/zuYIkzdhPOmx2DL2j1U4dpd7rxQhXoeTLfFuXiw7.jpg', 10, '2026-10-30 22:21:32', '2026-10-30 22:21:32'),
	(26, 40, 'Hồng kẻ sọc', 'S', 'products/variants/BYS74vZMz4wQCe6T6yg3oANx5WZ3vcOUXM2e7LNC.jpg', 'products/variants/3Q9L4NqLyMxUnqA3IVZHA2cgEeDY9XiKbSJBlDfN.webp', 4, '2026-10-30 22:23:13', '2026-10-30 22:23:13'),
	(27, 40, 'Hồng kẻ sọc', 'M', 'products/variants/BYS74vZMz4wQCe6T6yg3oANx5WZ3vcOUXM2e7LNC.jpg', 'products/variants/3Q9L4NqLyMxUnqA3IVZHA2cgEeDY9XiKbSJBlDfN.webp', 4, '2026-10-30 22:23:13', '2026-10-30 22:23:13'),
	(28, 40, 'Hồng kẻ sọc', 'L', 'products/variants/BYS74vZMz4wQCe6T6yg3oANx5WZ3vcOUXM2e7LNC.jpg', 'products/variants/3Q9L4NqLyMxUnqA3IVZHA2cgEeDY9XiKbSJBlDfN.webp', 4, '2026-10-30 22:23:13', '2026-10-30 22:23:13'),
	(32, 42, 'Xanh lá non', 'S', 'products/variants/B69b6yWspNtQy5k4uWAKvJ4QPmhAevSvZiHpnEwE.webp', 'products/variants/hoPObufzBaJtTkNZrYpS1SeNJpPS4YVSxYzh5wfa.webp', 15, '2026-10-30 22:25:19', '2026-10-31 01:37:05'),
	(33, 42, 'Xanh lá non', 'M', 'products/variants/B69b6yWspNtQy5k4uWAKvJ4QPmhAevSvZiHpnEwE.webp', 'products/variants/hoPObufzBaJtTkNZrYpS1SeNJpPS4YVSxYzh5wfa.webp', 15, '2026-10-30 22:25:19', '2026-10-31 01:37:05'),
	(34, 42, 'Xanh lá non', 'L', 'products/variants/B69b6yWspNtQy5k4uWAKvJ4QPmhAevSvZiHpnEwE.webp', 'products/variants/hoPObufzBaJtTkNZrYpS1SeNJpPS4YVSxYzh5wfa.webp', 15, '2026-10-30 22:25:19', '2026-10-31 01:37:05'),
	(38, 35, 'Trắng sọc kẻ', 'S', 'products/variants/u8WH4Rhg3GcPGKtdOHBmm12dI3BWSCiHhXGsBpO5.jpg', 'products/variants/yupyu95EVV4hofpEgdlB3LmJg1vHMMhoMno2Kivy.jpg', 2, '2026-10-30 22:30:25', '2026-10-30 22:30:25'),
	(39, 35, 'Trắng sọc kẻ', 'M', 'products/variants/u8WH4Rhg3GcPGKtdOHBmm12dI3BWSCiHhXGsBpO5.jpg', 'products/variants/yupyu95EVV4hofpEgdlB3LmJg1vHMMhoMno2Kivy.jpg', 2, '2026-10-30 22:30:25', '2026-10-30 22:30:25'),
	(40, 35, 'Trắng sọc kẻ', 'L', 'products/variants/u8WH4Rhg3GcPGKtdOHBmm12dI3BWSCiHhXGsBpO5.jpg', 'products/variants/yupyu95EVV4hofpEgdlB3LmJg1vHMMhoMno2Kivy.jpg', 2, '2026-10-30 22:30:25', '2026-10-30 22:30:25'),
	(44, 33, 'Nâu cà phê sữa', 'S', 'products/variants/dLzpLeTBmiKQE6ziHZArJkaA8P2yJJHLCOefgPMw.webp', 'products/variants/I8hKRVSWi4JoJYFbkV86oKfN0BHPaigP848el1N4.jpg', 5, '2026-10-30 22:32:40', '2026-10-30 22:32:40'),
	(45, 33, 'Nâu cà phê sữa', 'M', 'products/variants/dLzpLeTBmiKQE6ziHZArJkaA8P2yJJHLCOefgPMw.webp', 'products/variants/I8hKRVSWi4JoJYFbkV86oKfN0BHPaigP848el1N4.jpg', 5, '2026-10-30 22:32:40', '2026-10-30 22:32:40'),
	(46, 33, 'Nâu cà phê sữa', 'L', 'products/variants/dLzpLeTBmiKQE6ziHZArJkaA8P2yJJHLCOefgPMw.webp', 'products/variants/I8hKRVSWi4JoJYFbkV86oKfN0BHPaigP848el1N4.jpg', 5, '2026-10-30 22:32:40', '2026-10-30 22:32:40'),
	(50, 45, 'Đỏ sọc', 'S', NULL, NULL, 9, '2026-10-30 22:39:02', '2026-10-30 22:39:02'),
	(51, 45, 'Đỏ sọc', 'M', NULL, NULL, 9, '2026-10-30 22:39:02', '2026-10-30 22:39:02'),
	(52, 45, 'Đỏ sọc', 'L', NULL, NULL, 9, '2026-10-30 22:39:02', '2026-10-30 22:39:02'),
	(53, 44, 'Đỏ họa tiết', 'S', NULL, NULL, 3, '2026-10-30 22:39:33', '2026-10-30 22:39:33'),
	(54, 44, 'Đỏ họa tiết', 'M', NULL, NULL, 3, '2026-10-30 22:39:33', '2026-10-30 22:39:33'),
	(55, 44, 'Đỏ họa tiết', 'L', NULL, NULL, 3, '2026-10-30 22:39:33', '2026-10-30 22:39:33'),
	(56, 43, 'Xám trơn', 'S', NULL, NULL, 20, '2026-10-30 22:39:59', '2026-10-31 01:37:45'),
	(57, 43, 'Xám trơn', 'M', NULL, NULL, 20, '2026-10-30 22:39:59', '2026-10-31 01:37:45'),
	(58, 43, 'Xám trơn', 'L', NULL, NULL, 20, '2026-10-30 22:39:59', '2026-10-31 01:37:45'),
	(59, 39, 'Xanh đen trơn', 'S', NULL, NULL, 2, '2026-10-30 22:42:36', '2026-10-30 22:42:36'),
	(60, 39, 'Xanh đen trơn', 'M', NULL, NULL, 2, '2026-10-30 22:42:36', '2026-10-30 22:42:36'),
	(61, 39, 'Xanh đen trơn', 'L', NULL, NULL, 2, '2026-10-30 22:42:36', '2026-10-30 22:42:36'),
	(62, 37, 'Nâu ấm họa tiết', 'S', NULL, NULL, 3, '2026-10-30 22:43:22', '2026-11-01 00:16:03'),
	(63, 37, 'Nâu ấm họa tiết', 'M', NULL, NULL, 3, '2026-10-30 22:43:22', '2026-11-01 00:16:03'),
	(64, 37, 'Nâu ấm họa tiết', 'L', NULL, NULL, 3, '2026-10-30 22:43:22', '2026-11-01 00:16:03'),
	(65, 36, 'Đỏ sọc mini', 'S', NULL, NULL, 3, '2026-10-30 22:44:11', '2026-10-30 22:44:11'),
	(66, 36, 'Đỏ sọc mini', 'M', NULL, NULL, 3, '2026-10-30 22:44:11', '2026-10-30 22:44:11'),
	(67, 36, 'Đỏ sọc mini', 'L', NULL, NULL, 3, '2026-10-30 22:44:11', '2026-10-30 22:44:11'),
	(68, 34, 'Đen sọc họa tiết', 'S', 'products/variants/TUUSywoErMh16etKFi1ey22Rn2KuSVChA6rMG26C.webp', 'products/variants/W6Ah7UGNUlKOQwMLEi2hit7eZNOzMIrHOxOHypIZ.webp', 6, '2026-10-30 23:03:39', '2026-10-31 10:42:29'),
	(69, 34, 'Đen sọc họa tiết', 'M', 'products/variants/TUUSywoErMh16etKFi1ey22Rn2KuSVChA6rMG26C.webp', 'products/variants/W6Ah7UGNUlKOQwMLEi2hit7eZNOzMIrHOxOHypIZ.webp', 6, '2026-10-30 23:03:39', '2026-10-31 10:42:29'),
	(70, 34, 'Đen sọc họa tiết', 'L', 'products/variants/TUUSywoErMh16etKFi1ey22Rn2KuSVChA6rMG26C.webp', 'products/variants/W6Ah7UGNUlKOQwMLEi2hit7eZNOzMIrHOxOHypIZ.webp', 6, '2026-10-30 23:03:39', '2026-10-31 10:42:29'),
	(71, 32, 'Đỏ rượu vang', 'S', NULL, NULL, 12, '2026-10-30 23:05:03', '2026-10-30 23:05:03'),
	(72, 32, 'Đỏ rượu vang', 'M', NULL, NULL, 12, '2026-10-30 23:05:03', '2026-10-30 23:05:03'),
	(73, 32, 'Đỏ rượu vang', 'L', NULL, NULL, 12, '2026-10-30 23:05:03', '2026-10-30 23:05:03'),
	(74, 31, 'Xanh kẻ sọc', 'S', 'products/variants/yyPZG7OwLhKrrmscT1S2QtYmvF9Y9rldmTjTVB40.webp', 'products/variants/VvJxUPudeHRb8qLgKvHRoKbI3833LpNemxLhAvn8.webp', 1, '2026-10-30 23:07:03', '2026-10-30 23:14:45'),
	(75, 31, 'Xanh kẻ sọc', 'M', 'products/variants/yyPZG7OwLhKrrmscT1S2QtYmvF9Y9rldmTjTVB40.webp', 'products/variants/VvJxUPudeHRb8qLgKvHRoKbI3833LpNemxLhAvn8.webp', 1, '2026-10-30 23:07:03', '2026-10-30 23:14:45'),
	(76, 31, 'Xanh kẻ sọc', 'L', 'products/variants/yyPZG7OwLhKrrmscT1S2QtYmvF9Y9rldmTjTVB40.webp', 'products/variants/VvJxUPudeHRb8qLgKvHRoKbI3833LpNemxLhAvn8.webp', 1, '2026-10-30 23:07:03', '2026-10-30 23:14:45'),
	(77, 30, 'Xanh lá mạ', 'S', 'products/variants/EjwJcHYDjiih3nVEsO2MxD0A61Yc43CorRrYd0JS.webp', 'products/variants/xvpxfrhuPHc0eL3pNF3Mopw82LwSOa7PKTNWe0IC.webp', 13, '2026-10-30 23:08:51', '2026-10-30 23:08:51'),
	(78, 30, 'Xanh lá mạ', 'M', 'products/variants/EjwJcHYDjiih3nVEsO2MxD0A61Yc43CorRrYd0JS.webp', 'products/variants/xvpxfrhuPHc0eL3pNF3Mopw82LwSOa7PKTNWe0IC.webp', 13, '2026-10-30 23:08:51', '2026-10-30 23:08:51'),
	(79, 30, 'Xanh lá mạ', 'L', 'products/variants/EjwJcHYDjiih3nVEsO2MxD0A61Yc43CorRrYd0JS.webp', 'products/variants/xvpxfrhuPHc0eL3pNF3Mopw82LwSOa7PKTNWe0IC.webp', 13, '2026-10-30 23:08:51', '2026-10-30 23:08:51'),
	(80, 29, 'Xanh baby', 'S', 'products/variants/4KFL8ob3CDVyNNd3i1BmMx545NlXD7xADGsxMEaE.jpg', 'products/variants/jbY22jDTGmU00zrVO56fH3e3YKv9FAINrg1TxDIN.webp', 2, '2026-10-30 23:10:01', '2026-10-30 23:10:01'),
	(81, 29, 'Xanh baby', 'M', 'products/variants/4KFL8ob3CDVyNNd3i1BmMx545NlXD7xADGsxMEaE.jpg', 'products/variants/jbY22jDTGmU00zrVO56fH3e3YKv9FAINrg1TxDIN.webp', 2, '2026-10-30 23:10:01', '2026-10-30 23:10:01'),
	(82, 29, 'Xanh baby', 'L', 'products/variants/4KFL8ob3CDVyNNd3i1BmMx545NlXD7xADGsxMEaE.jpg', 'products/variants/jbY22jDTGmU00zrVO56fH3e3YKv9FAINrg1TxDIN.webp', 2, '2026-10-30 23:10:01', '2026-10-30 23:10:01'),
	(83, 41, 'Xanh baby kẻ sọc', 'S', NULL, NULL, 11, '2026-10-30 23:10:27', '2026-10-30 23:10:27'),
	(84, 41, 'Xanh baby kẻ sọc', 'M', NULL, NULL, 11, '2026-10-30 23:10:27', '2026-10-30 23:10:27'),
	(85, 41, 'Xanh baby kẻ sọc', 'L', NULL, NULL, 11, '2026-10-30 23:10:27', '2026-10-30 23:10:27'),
	(86, 28, 'Hồng kẻ sọc xám', 'S', 'products/variants/weXy5Zck4aTs9tCHmS0BRcm6u45xYNpmVLHVx5Mv.jpg', 'products/variants/5QCX1rjO5xQKgY4PhXHnaup0WCwKZfbfPxyVZ00T.jpg', 20, '2026-10-30 23:11:38', '2026-10-30 23:11:38'),
	(87, 28, 'Hồng kẻ sọc xám', 'M', 'products/variants/weXy5Zck4aTs9tCHmS0BRcm6u45xYNpmVLHVx5Mv.jpg', 'products/variants/5QCX1rjO5xQKgY4PhXHnaup0WCwKZfbfPxyVZ00T.jpg', 20, '2026-10-30 23:11:38', '2026-10-30 23:11:38'),
	(88, 28, 'Hồng kẻ sọc xám', 'L', 'products/variants/weXy5Zck4aTs9tCHmS0BRcm6u45xYNpmVLHVx5Mv.jpg', 'products/variants/5QCX1rjO5xQKgY4PhXHnaup0WCwKZfbfPxyVZ00T.jpg', 20, '2026-10-30 23:11:38', '2026-10-30 23:11:38'),
	(89, 27, 'Xám họa tiết hiện đại', 'S', 'products/variants/Folwic6PhS26LSg9Jk7njdcpLwRf54iG1gBdOfqh.webp', 'products/variants/By8KPqxM7GPbZQWL8Pz7JgjxJoWuMHF5jqUilCe4.jpg', 15, '2026-10-30 23:12:59', '2026-10-30 23:12:59'),
	(90, 27, 'Xám họa tiết hiện đại', 'M', 'products/variants/Folwic6PhS26LSg9Jk7njdcpLwRf54iG1gBdOfqh.webp', 'products/variants/By8KPqxM7GPbZQWL8Pz7JgjxJoWuMHF5jqUilCe4.jpg', 15, '2026-10-30 23:12:59', '2026-10-30 23:12:59'),
	(91, 27, 'Xám họa tiết hiện đại', 'L', 'products/variants/Folwic6PhS26LSg9Jk7njdcpLwRf54iG1gBdOfqh.webp', 'products/variants/By8KPqxM7GPbZQWL8Pz7JgjxJoWuMHF5jqUilCe4.jpg', 15, '2026-10-30 23:12:59', '2026-10-30 23:12:59'),
	(92, 26, 'Trắng sọc trơn', 'S', 'products/variants/3e51De3twFaORIqoXpDB4BNXLcDpCDTAwvFSxEAz.webp', 'products/variants/IKNeo8mDgJnJj83AMs2x7miqu8frCJu50O38a1Gv.jpg', 32, '2026-10-30 23:13:51', '2026-10-30 23:13:51'),
	(93, 26, 'Trắng sọc trơn', 'M', 'products/variants/3e51De3twFaORIqoXpDB4BNXLcDpCDTAwvFSxEAz.webp', 'products/variants/IKNeo8mDgJnJj83AMs2x7miqu8frCJu50O38a1Gv.jpg', 32, '2026-10-30 23:13:51', '2026-10-30 23:13:51'),
	(94, 26, 'Trắng sọc trơn', 'L', 'products/variants/3e51De3twFaORIqoXpDB4BNXLcDpCDTAwvFSxEAz.webp', 'products/variants/IKNeo8mDgJnJj83AMs2x7miqu8frCJu50O38a1Gv.jpg', 32, '2026-10-30 23:13:51', '2026-10-30 23:13:51'),
	(95, 25, 'Nâu trầm kẻ sọc', 'S', 'products/variants/pLxxhBD7R14lW1ZaGdLzLn4ktOEgpTaOPDb8I2gw.jpg', 'products/variants/cbpx111iZthlqfTWV90nxpwi2Q8XTxxb9AJylfXT.webp', 34, '2026-10-30 23:16:00', '2026-10-31 01:38:16'),
	(96, 25, 'Nâu trầm kẻ sọc', 'M', 'products/variants/pLxxhBD7R14lW1ZaGdLzLn4ktOEgpTaOPDb8I2gw.jpg', 'products/variants/cbpx111iZthlqfTWV90nxpwi2Q8XTxxb9AJylfXT.webp', 34, '2026-10-30 23:16:00', '2026-10-31 01:38:16'),
	(97, 25, 'Nâu trầm kẻ sọc', 'L', 'products/variants/pLxxhBD7R14lW1ZaGdLzLn4ktOEgpTaOPDb8I2gw.jpg', 'products/variants/cbpx111iZthlqfTWV90nxpwi2Q8XTxxb9AJylfXT.webp', 34, '2026-10-30 23:16:00', '2026-10-31 01:38:16'),
	(98, 24, 'Be sọc kẻ', 'S', 'products/variants/nN128BZhRgbW6is7pr1udIETDqujcntlqILbVxKr.webp', 'products/variants/gvog95aMzfZpWlKuCvj7kYzSpTXChufiSLOMY1hM.webp', 9, '2026-10-30 23:17:44', '2026-10-30 23:17:44'),
	(99, 24, 'Be sọc kẻ', 'M', 'products/variants/nN128BZhRgbW6is7pr1udIETDqujcntlqILbVxKr.webp', 'products/variants/gvog95aMzfZpWlKuCvj7kYzSpTXChufiSLOMY1hM.webp', 9, '2026-10-30 23:17:44', '2026-10-30 23:17:44'),
	(100, 24, 'Be sọc kẻ', 'L', 'products/variants/nN128BZhRgbW6is7pr1udIETDqujcntlqILbVxKr.webp', 'products/variants/gvog95aMzfZpWlKuCvj7kYzSpTXChufiSLOMY1hM.webp', 9, '2026-10-30 23:17:44', '2026-10-30 23:17:44'),
	(101, 24, 'Đỏ sọc kẻ', 'S', 'products/variants/tkCk22jp2iGT412IvchpryXaK71bpkLPQSAi3BRz.webp', 'products/variants/w7Ajwli57gbfymWwS2XqK5ZoSHZFnx7BxPqJzv7E.jpg', 9, '2026-10-30 23:17:44', '2026-10-30 23:17:44'),
	(102, 24, 'Đỏ sọc kẻ', 'M', 'products/variants/tkCk22jp2iGT412IvchpryXaK71bpkLPQSAi3BRz.webp', 'products/variants/w7Ajwli57gbfymWwS2XqK5ZoSHZFnx7BxPqJzv7E.jpg', 9, '2026-10-30 23:17:44', '2026-10-30 23:17:44'),
	(103, 24, 'Đỏ sọc kẻ', 'L', 'products/variants/tkCk22jp2iGT412IvchpryXaK71bpkLPQSAi3BRz.webp', 'products/variants/w7Ajwli57gbfymWwS2XqK5ZoSHZFnx7BxPqJzv7E.jpg', 9, '2026-10-30 23:17:44', '2026-10-30 23:17:44'),
	(104, 23, 'Caro nâu ấm', 'S', 'products/variants/8jHBgzK02z0fKRnlAzf1yoUZ495putjE98ycV3E6.webp', 'products/variants/yAq4wsCLeG7O7CNmSWR8ewDzkdTJHlccKsbuLlu1.webp', 1, '2026-10-30 23:19:13', '2026-10-30 23:19:13'),
	(105, 23, 'Caro nâu ấm', 'M', 'products/variants/8jHBgzK02z0fKRnlAzf1yoUZ495putjE98ycV3E6.webp', 'products/variants/yAq4wsCLeG7O7CNmSWR8ewDzkdTJHlccKsbuLlu1.webp', 1, '2026-10-30 23:19:13', '2026-10-30 23:19:13'),
	(106, 23, 'Caro nâu ấm', 'L', 'products/variants/8jHBgzK02z0fKRnlAzf1yoUZ495putjE98ycV3E6.webp', 'products/variants/yAq4wsCLeG7O7CNmSWR8ewDzkdTJHlccKsbuLlu1.webp', 1, '2026-10-30 23:19:13', '2026-10-30 23:19:13'),
	(107, 22, 'Trắng trơn', 'S', 'products/variants/rwY6gvXpSAYGR7H8bHJhG557oUk5HtKu3JnZq9hy.webp', 'products/variants/yPQOAVyuck3LVXjdX5Igl2W2EQnCCQDRfN1zMOUq.webp', 13, '2026-10-30 23:20:25', '2026-10-30 23:20:25'),
	(108, 22, 'Trắng trơn', 'M', 'products/variants/rwY6gvXpSAYGR7H8bHJhG557oUk5HtKu3JnZq9hy.webp', 'products/variants/yPQOAVyuck3LVXjdX5Igl2W2EQnCCQDRfN1zMOUq.webp', 13, '2026-10-30 23:20:25', '2026-10-30 23:20:25'),
	(109, 22, 'Trắng trơn', 'L', 'products/variants/rwY6gvXpSAYGR7H8bHJhG557oUk5HtKu3JnZq9hy.webp', 'products/variants/yPQOAVyuck3LVXjdX5Igl2W2EQnCCQDRfN1zMOUq.webp', 13, '2026-10-30 23:20:25', '2026-10-30 23:20:25'),
	(110, 21, 'Trắng kẻ đỏ', 'S', 'products/variants/rZDPPaOosxLQGiLq8TJqOIJQZtXtdxPN0AIbXdt0.webp', 'products/variants/hQwyTULUMRKptpxnwZBuulxMWtpaOYaOtKWGzrJe.webp', 5, '2026-10-30 23:22:06', '2026-11-01 00:22:38'),
	(111, 21, 'Trắng kẻ đỏ', 'M', 'products/variants/rZDPPaOosxLQGiLq8TJqOIJQZtXtdxPN0AIbXdt0.webp', 'products/variants/hQwyTULUMRKptpxnwZBuulxMWtpaOYaOtKWGzrJe.webp', 5, '2026-10-30 23:22:06', '2026-11-01 00:22:38'),
	(112, 21, 'Trắng kẻ đỏ', 'L', 'products/variants/rZDPPaOosxLQGiLq8TJqOIJQZtXtdxPN0AIbXdt0.webp', 'products/variants/hQwyTULUMRKptpxnwZBuulxMWtpaOYaOtKWGzrJe.webp', 5, '2026-10-30 23:22:06', '2026-11-01 00:22:38'),
	(113, 20, 'Xanh sọc trắng', 'S', 'products/variants/rVMwvjU5cA9tDZT3DYC8RB09Zj2q9UeK2nnE7nno.webp', 'products/variants/af8NkveSJGMZLzT2gvxS9wCDttHCkf2fuk7A2mmS.webp', 1, '2026-10-30 23:23:12', '2026-10-30 23:23:12'),
	(114, 20, 'Xanh sọc trắng', 'M', 'products/variants/rVMwvjU5cA9tDZT3DYC8RB09Zj2q9UeK2nnE7nno.webp', 'products/variants/af8NkveSJGMZLzT2gvxS9wCDttHCkf2fuk7A2mmS.webp', 1, '2026-10-30 23:23:12', '2026-10-30 23:23:12'),
	(115, 20, 'Xanh sọc trắng', 'L', 'products/variants/rVMwvjU5cA9tDZT3DYC8RB09Zj2q9UeK2nnE7nno.webp', 'products/variants/af8NkveSJGMZLzT2gvxS9wCDttHCkf2fuk7A2mmS.webp', 1, '2026-10-30 23:23:12', '2026-10-30 23:23:12'),
	(116, 19, 'Tím nhạt ngọt ngào', 'S', 'products/variants/UCb0VD3sUi3Z9jdJTtbNT2T3O8EChCltVmyLIJCV.webp', 'products/variants/Rgn5jcZUr6o52sp3jXyljnnhdybzUlNbGY6liQmj.webp', 20, '2026-10-30 23:25:05', '2026-10-30 23:25:05'),
	(117, 19, 'Tím nhạt ngọt ngào', 'M', 'products/variants/UCb0VD3sUi3Z9jdJTtbNT2T3O8EChCltVmyLIJCV.webp', 'products/variants/Rgn5jcZUr6o52sp3jXyljnnhdybzUlNbGY6liQmj.webp', 20, '2026-10-30 23:25:05', '2026-10-30 23:25:05'),
	(118, 19, 'Tím nhạt ngọt ngào', 'L', 'products/variants/UCb0VD3sUi3Z9jdJTtbNT2T3O8EChCltVmyLIJCV.webp', 'products/variants/Rgn5jcZUr6o52sp3jXyljnnhdybzUlNbGY6liQmj.webp', 20, '2026-10-30 23:25:05', '2026-10-30 23:25:05'),
	(119, 18, 'Hồng nhạt', 'S', 'products/variants/9DzIYjpaGHZOEDIZ0GJajYfQlKukaOnZH4InwRpU.webp', 'products/variants/IB2UxfShm4uT2LWzE5HLVdmstsxaHKRrknpZLSyS.webp', 6, '2026-10-30 23:26:35', '2026-11-02 06:14:52'),
	(120, 18, 'Hồng nhạt', 'M', 'products/variants/9DzIYjpaGHZOEDIZ0GJajYfQlKukaOnZH4InwRpU.webp', 'products/variants/IB2UxfShm4uT2LWzE5HLVdmstsxaHKRrknpZLSyS.webp', 6, '2026-10-30 23:26:35', '2026-11-02 06:14:52'),
	(121, 18, 'Hồng nhạt', 'L', 'products/variants/9DzIYjpaGHZOEDIZ0GJajYfQlKukaOnZH4InwRpU.webp', 'products/variants/IB2UxfShm4uT2LWzE5HLVdmstsxaHKRrknpZLSyS.webp', 6, '2026-10-30 23:26:35', '2026-11-02 06:14:52'),
	(122, 17, 'Xanh kẻ sọc', 'S', 'products/variants/9AZR3vVh8ZiQ2dwN7gcI8PNFc9a28stA3IqjNP6z.webp', 'products/variants/20w6dbDS9HCM2GnWMcU2i215mpaw99yRXX0VnQ9j.webp', 2, '2026-10-30 23:29:04', '2026-10-31 10:48:10'),
	(123, 17, 'Xanh kẻ sọc', 'M', 'products/variants/9AZR3vVh8ZiQ2dwN7gcI8PNFc9a28stA3IqjNP6z.webp', 'products/variants/20w6dbDS9HCM2GnWMcU2i215mpaw99yRXX0VnQ9j.webp', 2, '2026-10-30 23:29:04', '2026-10-31 10:48:10'),
	(124, 17, 'Xanh kẻ sọc', 'L', 'products/variants/9AZR3vVh8ZiQ2dwN7gcI8PNFc9a28stA3IqjNP6z.webp', 'products/variants/20w6dbDS9HCM2GnWMcU2i215mpaw99yRXX0VnQ9j.webp', 2, '2026-10-30 23:29:04', '2026-10-31 10:48:10'),
	(125, 16, 'Hồng tím', 'S', 'products/variants/YlQxSn7MyjgI5CHZftpl4Jgra73N2SqklA7OQ9Aq.webp', 'products/variants/jKQuiNzKXwXh76y3lT8Ailq03F6lVKCg3bWHA2j9.webp', 32, '2026-10-30 23:30:02', '2026-10-30 23:30:02'),
	(126, 16, 'Hồng tím', 'M', 'products/variants/YlQxSn7MyjgI5CHZftpl4Jgra73N2SqklA7OQ9Aq.webp', 'products/variants/jKQuiNzKXwXh76y3lT8Ailq03F6lVKCg3bWHA2j9.webp', 32, '2026-10-30 23:30:03', '2026-10-30 23:30:03'),
	(127, 16, 'Hồng tím', 'L', 'products/variants/YlQxSn7MyjgI5CHZftpl4Jgra73N2SqklA7OQ9Aq.webp', 'products/variants/jKQuiNzKXwXh76y3lT8Ailq03F6lVKCg3bWHA2j9.webp', 32, '2026-10-30 23:30:03', '2026-10-30 23:30:03'),
	(128, 15, 'Xanh mạ non kẻ sọc', 'S', 'products/variants/q4D3jbMetckcbgmkt3yNFmHrpIHpkTrh1SnheuPb.webp', 'products/variants/8UivHxQSWjz9z7YkqwKjP7L7FlxI1xAZew2wXYQk.webp', 2, '2026-10-30 23:32:53', '2026-10-30 23:32:53'),
	(129, 15, 'Xanh mạ non kẻ sọc', 'M', 'products/variants/q4D3jbMetckcbgmkt3yNFmHrpIHpkTrh1SnheuPb.webp', 'products/variants/8UivHxQSWjz9z7YkqwKjP7L7FlxI1xAZew2wXYQk.webp', 2, '2026-10-30 23:32:53', '2026-10-30 23:32:53'),
	(130, 15, 'Xanh mạ non kẻ sọc', 'L', 'products/variants/q4D3jbMetckcbgmkt3yNFmHrpIHpkTrh1SnheuPb.webp', 'products/variants/8UivHxQSWjz9z7YkqwKjP7L7FlxI1xAZew2wXYQk.webp', 2, '2026-10-30 23:32:53', '2026-10-30 23:32:53'),
	(131, 15, 'Be nhẹ nhàng', 'S', 'products/variants/HpTGIcIOz2YFJlcWHs87mdjxcMi1cfqGWIRy6y29.webp', 'products/variants/izoYwnklHcY8jlARYhws6MUQRqPgNXfhNJ59GqiE.webp', 2, '2026-10-30 23:32:53', '2026-10-30 23:32:53'),
	(132, 15, 'Be nhẹ nhàng', 'M', 'products/variants/HpTGIcIOz2YFJlcWHs87mdjxcMi1cfqGWIRy6y29.webp', 'products/variants/izoYwnklHcY8jlARYhws6MUQRqPgNXfhNJ59GqiE.webp', 2, '2026-10-30 23:32:53', '2026-10-30 23:32:53'),
	(133, 15, 'Be nhẹ nhàng', 'L', 'products/variants/HpTGIcIOz2YFJlcWHs87mdjxcMi1cfqGWIRy6y29.webp', 'products/variants/izoYwnklHcY8jlARYhws6MUQRqPgNXfhNJ59GqiE.webp', 2, '2026-10-30 23:32:53', '2026-10-30 23:32:53'),
	(134, 14, 'Nâu be kẻ sọc', 'S', 'products/variants/WHhhBzdJBgNqmgdQjE19gR7ATY9haAdrv9blXcEh.webp', 'products/variants/XA2uvfnLRk5cdNpmZtjrGVAopat451DFHgoUoubF.webp', 29, '2026-10-30 23:34:26', '2026-10-30 23:34:26'),
	(135, 14, 'Nâu be kẻ sọc', 'M', 'products/variants/WHhhBzdJBgNqmgdQjE19gR7ATY9haAdrv9blXcEh.webp', 'products/variants/XA2uvfnLRk5cdNpmZtjrGVAopat451DFHgoUoubF.webp', 29, '2026-10-30 23:34:26', '2026-10-30 23:34:26'),
	(136, 14, 'Nâu be kẻ sọc', 'L', 'products/variants/WHhhBzdJBgNqmgdQjE19gR7ATY9haAdrv9blXcEh.webp', 'products/variants/XA2uvfnLRk5cdNpmZtjrGVAopat451DFHgoUoubF.webp', 29, '2026-10-30 23:34:26', '2026-10-30 23:34:26'),
	(137, 14, 'Hồng nhạt kẻ sọc', 'S', 'products/variants/l0LmyQZhwB1l3rgpB0euLZ4kSWQSnRPcUQHDS6t8.jpg', 'products/variants/e7bfiHVoQLfsCPjwouBgCzC00wBn8XTusr7e2lNs.webp', 29, '2026-10-30 23:34:26', '2026-10-30 23:34:26'),
	(138, 14, 'Hồng nhạt kẻ sọc', 'M', 'products/variants/l0LmyQZhwB1l3rgpB0euLZ4kSWQSnRPcUQHDS6t8.jpg', 'products/variants/e7bfiHVoQLfsCPjwouBgCzC00wBn8XTusr7e2lNs.webp', 29, '2026-10-30 23:34:26', '2026-10-30 23:34:26'),
	(139, 14, 'Hồng nhạt kẻ sọc', 'L', 'products/variants/l0LmyQZhwB1l3rgpB0euLZ4kSWQSnRPcUQHDS6t8.jpg', 'products/variants/e7bfiHVoQLfsCPjwouBgCzC00wBn8XTusr7e2lNs.webp', 29, '2026-10-30 23:34:26', '2026-10-30 23:34:26'),
	(140, 13, 'Chấm bi', 'S', 'products/variants/xA95IJygY8L7pe4xCZaCZeJRiUSOvLwpmRlgh67a.webp', 'products/variants/9vI1vmIGe6r75QWsIJu6NJsJFnli28aAMNxJ5IGe.webp', 16, '2026-10-30 23:35:26', '2026-10-30 23:35:26'),
	(141, 13, 'Chấm bi', 'M', 'products/variants/xA95IJygY8L7pe4xCZaCZeJRiUSOvLwpmRlgh67a.webp', 'products/variants/9vI1vmIGe6r75QWsIJu6NJsJFnli28aAMNxJ5IGe.webp', 16, '2026-10-30 23:35:26', '2026-10-30 23:35:26'),
	(142, 13, 'Chấm bi', 'L', 'products/variants/xA95IJygY8L7pe4xCZaCZeJRiUSOvLwpmRlgh67a.webp', 'products/variants/9vI1vmIGe6r75QWsIJu6NJsJFnli28aAMNxJ5IGe.webp', 16, '2026-10-30 23:35:26', '2026-10-30 23:35:26'),
	(143, 12, 'Hồng trắng họa tiết', 'S', 'products/variants/eYLnCKrNtIkMt4iUzYtBUEvXyQKI4LGh2VpEUVCR.jpg', 'products/variants/EEJXPcCkOMWskAbXm5pMEefA3SFnYQWDMGKEat0W.webp', 12, '2026-10-30 23:36:15', '2026-10-30 23:36:15'),
	(144, 12, 'Hồng trắng họa tiết', 'M', 'products/variants/eYLnCKrNtIkMt4iUzYtBUEvXyQKI4LGh2VpEUVCR.jpg', 'products/variants/EEJXPcCkOMWskAbXm5pMEefA3SFnYQWDMGKEat0W.webp', 12, '2026-10-30 23:36:15', '2026-10-30 23:36:15'),
	(145, 12, 'Hồng trắng họa tiết', 'L', 'products/variants/eYLnCKrNtIkMt4iUzYtBUEvXyQKI4LGh2VpEUVCR.jpg', 'products/variants/EEJXPcCkOMWskAbXm5pMEefA3SFnYQWDMGKEat0W.webp', 12, '2026-10-30 23:36:15', '2026-10-30 23:36:15'),
	(146, 11, 'Xanh lá họa tiết', 'S', 'products/variants/QoKrdwIBBSOXhFRc07PxMRGjxfbSWMcNoqf2xOaZ.webp', 'products/variants/FGcRTVv17XdCnpKA2GGaUABYgNHTRI8RQ7SH0hOv.jpg', 5, '2026-10-30 23:37:20', '2026-10-30 23:37:20'),
	(147, 11, 'Xanh lá họa tiết', 'M', 'products/variants/QoKrdwIBBSOXhFRc07PxMRGjxfbSWMcNoqf2xOaZ.webp', 'products/variants/FGcRTVv17XdCnpKA2GGaUABYgNHTRI8RQ7SH0hOv.jpg', 5, '2026-10-30 23:37:20', '2026-10-30 23:37:20'),
	(148, 11, 'Xanh lá họa tiết', 'L', 'products/variants/QoKrdwIBBSOXhFRc07PxMRGjxfbSWMcNoqf2xOaZ.webp', 'products/variants/FGcRTVv17XdCnpKA2GGaUABYgNHTRI8RQ7SH0hOv.jpg', 5, '2026-10-30 23:37:20', '2026-10-30 23:37:20'),
	(155, 10, 'Tim hồng ngọt', 'S', 'products/variants/MHBn5Slvwp0z21JstwBGxrryA0n2XbU8X9BhHn2l.webp', 'products/variants/TVuy1vLhagbLDFxK52GfIWw09oiWoHs4vUvtgeA5.webp', 19, '2026-10-30 23:40:04', '2026-10-30 23:40:04'),
	(156, 10, 'Tim hồng ngọt', 'M', 'products/variants/MHBn5Slvwp0z21JstwBGxrryA0n2XbU8X9BhHn2l.webp', 'products/variants/TVuy1vLhagbLDFxK52GfIWw09oiWoHs4vUvtgeA5.webp', 19, '2026-10-30 23:40:04', '2026-10-30 23:40:04'),
	(157, 10, 'Tim hồng ngọt', 'L', 'products/variants/MHBn5Slvwp0z21JstwBGxrryA0n2XbU8X9BhHn2l.webp', 'products/variants/TVuy1vLhagbLDFxK52GfIWw09oiWoHs4vUvtgeA5.webp', 19, '2026-10-30 23:40:04', '2026-10-30 23:40:04'),
	(158, 10, 'Tim xanh em bé', 'S', 'products/variants/J9fvqONZAWZgxRj9lCJZqJdLdbZwSu1aso5K6GvR.webp', 'products/variants/xIxhp6e3XAtSU9rmwuevOZaeKML19DYOO2h4fWYp.webp', 19, '2026-10-30 23:40:04', '2026-10-30 23:40:04'),
	(159, 10, 'Tim xanh em bé', 'M', 'products/variants/J9fvqONZAWZgxRj9lCJZqJdLdbZwSu1aso5K6GvR.webp', 'products/variants/xIxhp6e3XAtSU9rmwuevOZaeKML19DYOO2h4fWYp.webp', 19, '2026-10-30 23:40:04', '2026-10-30 23:40:04'),
	(160, 10, 'Tim xanh em bé', 'L', 'products/variants/J9fvqONZAWZgxRj9lCJZqJdLdbZwSu1aso5K6GvR.webp', 'products/variants/xIxhp6e3XAtSU9rmwuevOZaeKML19DYOO2h4fWYp.webp', 19, '2026-10-30 23:40:04', '2026-10-30 23:40:04'),
	(161, 9, 'Đỏ trầm sọc kẻ', 'S', 'products/variants/aqU1mVdXTBDm7sIr7MgthY86Jj8w1ZpUygU7lKVA.webp', 'products/variants/85XB90ejKmK6HPyuNMVsArcLWjnHqCNakrE9mdre.webp', 21, '2026-10-30 23:43:29', '2026-10-30 23:43:29'),
	(162, 9, 'Đỏ trầm sọc kẻ', 'M', 'products/variants/aqU1mVdXTBDm7sIr7MgthY86Jj8w1ZpUygU7lKVA.webp', 'products/variants/85XB90ejKmK6HPyuNMVsArcLWjnHqCNakrE9mdre.webp', 21, '2026-10-30 23:43:29', '2026-10-30 23:43:29'),
	(163, 9, 'Đỏ trầm sọc kẻ', 'L', 'products/variants/aqU1mVdXTBDm7sIr7MgthY86Jj8w1ZpUygU7lKVA.webp', 'products/variants/85XB90ejKmK6HPyuNMVsArcLWjnHqCNakrE9mdre.webp', 21, '2026-10-30 23:43:29', '2026-10-30 23:43:29'),
	(164, 1, 'Kẻ nâu ấm', 'S', 'products/variants/lSPGONMBa440Wy1TDt4oVesxxgFcWvF0tbz6przD.jpg', 'products/variants/kkYIiQUAcT7D9Vco2chkz5E8UwWTkISIaBg83xPs.jpg', 5, '2026-10-30 23:45:09', '2026-10-30 23:45:09'),
	(165, 1, 'Kẻ nâu ấm', 'M', 'products/variants/lSPGONMBa440Wy1TDt4oVesxxgFcWvF0tbz6przD.jpg', 'products/variants/kkYIiQUAcT7D9Vco2chkz5E8UwWTkISIaBg83xPs.jpg', 5, '2026-10-30 23:45:09', '2026-10-30 23:45:09'),
	(166, 1, 'Kẻ nâu ấm', 'L', 'products/variants/lSPGONMBa440Wy1TDt4oVesxxgFcWvF0tbz6przD.jpg', 'products/variants/kkYIiQUAcT7D9Vco2chkz5E8UwWTkISIaBg83xPs.jpg', 5, '2026-10-30 23:45:09', '2026-10-30 23:45:09'),
	(167, 1, 'Kẻ xanh lạnh', 'S', 'products/variants/v9XP5uYM62eMznkxxoTlgNCtOglkkm3XFEtan0ae.jpg', 'products/variants/QEB8ftDoJAhEJjbmN2fR0G585EmwBuYdRgFnAi72.webp', 5, '2026-10-30 23:45:09', '2026-10-30 23:45:09'),
	(168, 1, 'Kẻ xanh lạnh', 'M', 'products/variants/v9XP5uYM62eMznkxxoTlgNCtOglkkm3XFEtan0ae.jpg', 'products/variants/QEB8ftDoJAhEJjbmN2fR0G585EmwBuYdRgFnAi72.webp', 5, '2026-10-30 23:45:09', '2026-10-30 23:45:09'),
	(169, 1, 'Kẻ xanh lạnh', 'L', 'products/variants/v9XP5uYM62eMznkxxoTlgNCtOglkkm3XFEtan0ae.jpg', 'products/variants/QEB8ftDoJAhEJjbmN2fR0G585EmwBuYdRgFnAi72.webp', 5, '2026-10-30 23:45:09', '2026-10-30 23:45:09'),
	(170, 2, 'Vàng kẻ', 'S', 'products/variants/poTExdEu9H6gn6ifrEhgmEY9tADGQLkOFPB4rj2Z.webp', 'products/variants/3hGVPJhMJzAHRf631gzwmr7qDxRFDttRJagP6dtb.webp', 16, '2026-10-30 23:45:52', '2026-11-02 06:12:17'),
	(171, 2, 'Vàng kẻ', 'M', 'products/variants/poTExdEu9H6gn6ifrEhgmEY9tADGQLkOFPB4rj2Z.webp', 'products/variants/3hGVPJhMJzAHRf631gzwmr7qDxRFDttRJagP6dtb.webp', 16, '2026-10-30 23:45:52', '2026-11-02 06:12:17'),
	(172, 2, 'Vàng kẻ', 'L', 'products/variants/poTExdEu9H6gn6ifrEhgmEY9tADGQLkOFPB4rj2Z.webp', 'products/variants/3hGVPJhMJzAHRf631gzwmr7qDxRFDttRJagP6dtb.webp', 16, '2026-10-30 23:45:52', '2026-11-02 06:12:17'),
	(173, 3, 'Trắng kẻ', 'S', 'products/variants/y7NGwd8QremHRGgXV65KHZ6JCNjQ4wWyqtmsQUfK.jpg', 'products/variants/GmOJVDdjrA0LbYfREQjKECCNEmrL53THuuk2PqKw.jpg', 10, '2026-10-30 23:46:40', '2026-11-01 00:30:10'),
	(174, 3, 'Trắng kẻ', 'M', 'products/variants/y7NGwd8QremHRGgXV65KHZ6JCNjQ4wWyqtmsQUfK.jpg', 'products/variants/GmOJVDdjrA0LbYfREQjKECCNEmrL53THuuk2PqKw.jpg', 10, '2026-10-30 23:46:40', '2026-11-01 00:30:10'),
	(175, 3, 'Trắng kẻ', 'L', 'products/variants/y7NGwd8QremHRGgXV65KHZ6JCNjQ4wWyqtmsQUfK.jpg', 'products/variants/GmOJVDdjrA0LbYfREQjKECCNEmrL53THuuk2PqKw.jpg', 10, '2026-10-30 23:46:40', '2026-11-01 00:30:10'),
	(176, 3, 'Xám kẻ', 'S', 'products/variants/ZPdf77ZeXVlW488w8Yr70kkXvGJ8WWXX0ynwZXmY.webp', 'products/variants/mqVK3i2qOThkujaYFSqD0bcpERPAJNMnz8L4ni2L.webp', 10, '2026-10-30 23:46:40', '2026-11-01 00:30:10'),
	(177, 3, 'Xám kẻ', 'M', 'products/variants/ZPdf77ZeXVlW488w8Yr70kkXvGJ8WWXX0ynwZXmY.webp', 'products/variants/mqVK3i2qOThkujaYFSqD0bcpERPAJNMnz8L4ni2L.webp', 10, '2026-10-30 23:46:40', '2026-11-01 00:30:10'),
	(178, 3, 'Xám kẻ', 'L', 'products/variants/ZPdf77ZeXVlW488w8Yr70kkXvGJ8WWXX0ynwZXmY.webp', 'products/variants/mqVK3i2qOThkujaYFSqD0bcpERPAJNMnz8L4ni2L.webp', 10, '2026-10-30 23:46:40', '2026-11-01 00:30:10'),
	(179, 4, 'Đỏ', 'S', 'products/variants/Gbr667YY0D8IEeA2Pwxk9kAZ9PasfYipqa1UggQ1.jpg', 'products/variants/vXUer2sqaaU0HnHZU7hg92aLNohjGZN4z4srvOrF.jpg', 18, '2026-10-30 23:48:22', '2026-10-30 23:48:22'),
	(180, 4, 'Đỏ', 'M', 'products/variants/Gbr667YY0D8IEeA2Pwxk9kAZ9PasfYipqa1UggQ1.jpg', 'products/variants/vXUer2sqaaU0HnHZU7hg92aLNohjGZN4z4srvOrF.jpg', 18, '2026-10-30 23:48:22', '2026-10-30 23:48:22'),
	(181, 4, 'Đỏ', 'L', 'products/variants/Gbr667YY0D8IEeA2Pwxk9kAZ9PasfYipqa1UggQ1.jpg', 'products/variants/vXUer2sqaaU0HnHZU7hg92aLNohjGZN4z4srvOrF.jpg', 18, '2026-10-30 23:48:22', '2026-10-30 23:48:22'),
	(182, 4, 'Trắng', 'S', 'products/variants/rFU6fQYkrVpOeGVnjYI9so7dPXm9POpJBgaLzN1Z.webp', 'products/variants/VkViKBYvAkIkVfgwGKV56Fosx6flVu2VE3m5nKig.jpg', 18, '2026-10-30 23:48:22', '2026-10-30 23:48:22'),
	(183, 4, 'Trắng', 'M', 'products/variants/rFU6fQYkrVpOeGVnjYI9so7dPXm9POpJBgaLzN1Z.webp', 'products/variants/VkViKBYvAkIkVfgwGKV56Fosx6flVu2VE3m5nKig.jpg', 18, '2026-10-30 23:48:22', '2026-10-30 23:48:22'),
	(184, 4, 'Trắng', 'L', 'products/variants/rFU6fQYkrVpOeGVnjYI9so7dPXm9POpJBgaLzN1Z.webp', 'products/variants/VkViKBYvAkIkVfgwGKV56Fosx6flVu2VE3m5nKig.jpg', 18, '2026-10-30 23:48:22', '2026-10-30 23:48:22'),
	(185, 5, 'Hồng nhạt', 'S', 'products/variants/1BSniZ9osPAY4URvDZ4aSfMLHq2ig7EWq7jVimny.webp', 'products/variants/EWga6hYNavtvEU8qTwvKzjU0cKnrEfOMD51YNzEt.webp', 30, '2026-10-30 23:50:53', '2026-10-30 23:50:53'),
	(186, 5, 'Hồng nhạt', 'M', 'products/variants/1BSniZ9osPAY4URvDZ4aSfMLHq2ig7EWq7jVimny.webp', 'products/variants/EWga6hYNavtvEU8qTwvKzjU0cKnrEfOMD51YNzEt.webp', 30, '2026-10-30 23:50:53', '2026-10-30 23:50:53'),
	(187, 5, 'Hồng nhạt', 'L', 'products/variants/1BSniZ9osPAY4URvDZ4aSfMLHq2ig7EWq7jVimny.webp', 'products/variants/EWga6hYNavtvEU8qTwvKzjU0cKnrEfOMD51YNzEt.webp', 30, '2026-10-30 23:50:53', '2026-10-30 23:50:53'),
	(188, 5, 'Đỏ dâu', 'S', 'products/variants/n9RCRbLfmRA3RK80heJjUoPbrq0q5TP2HEyrmAUx.webp', 'products/variants/VJOXC3I14tNZAFBEc2eMK6Qxuz0t7rNAcTBQPwsM.webp', 30, '2026-10-30 23:50:53', '2026-10-30 23:50:53'),
	(189, 5, 'Đỏ dâu', 'M', 'products/variants/n9RCRbLfmRA3RK80heJjUoPbrq0q5TP2HEyrmAUx.webp', 'products/variants/VJOXC3I14tNZAFBEc2eMK6Qxuz0t7rNAcTBQPwsM.webp', 30, '2026-10-30 23:50:53', '2026-10-30 23:50:53'),
	(190, 5, 'Đỏ dâu', 'L', 'products/variants/n9RCRbLfmRA3RK80heJjUoPbrq0q5TP2HEyrmAUx.webp', 'products/variants/VJOXC3I14tNZAFBEc2eMK6Qxuz0t7rNAcTBQPwsM.webp', 30, '2026-10-30 23:50:53', '2026-10-30 23:50:53'),
	(191, 46, 'Tím khoai môn', 'ONE', 'products/variants/hbcvb7XIHVQWkoganIZcAuk28Z4NPCPBnTQrzEab.jpg', NULL, 11, '2026-10-31 00:37:12', '2026-10-31 02:24:09'),
	(192, 46, 'Tím  dịu', 'ONE', 'products/variants/CpGSH2iXN1qIIPURfo8i0thS2SNmnVxMuOSIMKk0.webp', NULL, 11, '2026-10-31 00:37:12', '2026-10-31 02:24:09'),
	(193, 47, 'Xanh biển', 'ONE', 'products/variants/iYgMNj2Q1KbKlEmOvSaRfBacB2s82spGRtiKOM2e.webp', NULL, 12, '2026-10-31 00:40:57', '2026-10-31 00:40:57'),
	(194, 48, 'Tím đậm', 'ONE', 'products/variants/N8k2jYMa5auE6MfyE1fFOCiRJUuIOa4VGamvxmi3.webp', NULL, 16, '2026-10-31 00:42:10', '2026-10-31 00:42:10'),
	(195, 49, 'Trắng đơn giản', 'ONE', 'products/variants/4NSjePCmGay9Xr3CrMz2EXRzFoRctxP0fGIoAE7V.jpg', NULL, 12, '2026-10-31 00:45:51', '2026-10-31 10:32:25'),
	(196, 49, 'Trắng họa tiết đỏ', 'ONE', 'products/variants/LNApBm2pLRz73Q53woQGcMIyHjsjsaUatWa0YdZm.webp', NULL, 12, '2026-10-31 00:45:51', '2026-10-31 10:32:25'),
	(199, 50, 'Xanh mạ nhẹ nhàng', 'ONE', 'products/variants/YD3VARnwYkLzzNLFF68Ahn9T8WAzF5jKRp003fjt.webp', NULL, 15, '2026-10-31 00:47:49', '2026-10-31 11:06:53'),
	(200, 51, 'Trắng hồng sao', 'ONE', 'products/variants/sO4OMGZ7dDxAYzCRfbA1nNmzt11PjTjb1gCYdtib.webp', NULL, 4, '2026-10-31 00:59:07', '2026-10-31 10:30:20'),
	(201, 51, 'Trắng bi', 'ONE', 'products/variants/iTzX43SDLL7m8dSsbQYkiMsAUoulZYUL3SIwRf9b.webp', NULL, 4, '2026-10-31 00:59:07', '2026-10-31 10:30:20'),
	(202, 51, 'Xám bi', 'ONE', 'products/variants/dRqfduzxiy8vOWbFHCtCm91xBBgMIMwbkQkGCnpi.webp', NULL, 4, '2026-10-31 00:59:07', '2026-10-31 10:30:20'),
	(203, 51, 'Xanh bi', 'ONE', 'products/variants/8pIppVp6IRcqPuGPfBkvjqlA1r7EUPvsuDaQMeLP.webp', NULL, 4, '2026-10-31 00:59:07', '2026-10-31 10:30:20'),
	(204, 51, 'Đen bi', 'ONE', 'products/variants/diLbe7DvhWmz3tSgFqzIte8mQUBM03DD9LLcXk9J.webp', NULL, 4, '2026-10-31 00:59:07', '2026-10-31 10:30:20'),
	(205, 52, 'Ếch 1', 'ONE', 'products/variants/IcMW6DJknSZl6jIe8cGj56dnTtJKm4JFzChphPpA.webp', NULL, 19, '2026-10-31 01:13:15', '2026-10-31 10:29:42'),
	(206, 52, 'Ếch 2', 'ONE', 'products/variants/SVwNYRT17udLBcqA6BfMbqyEO8s2C301EGspJBLP.webp', NULL, 19, '2026-10-31 01:13:15', '2026-10-31 10:29:42'),
	(207, 52, 'Ếch 3', 'ONE', 'products/variants/kyyDR3iHOPNnrfpvPWadzdEYbvYU9BV6wQhF1axz.webp', NULL, 19, '2026-10-31 01:13:15', '2026-10-31 10:29:42'),
	(212, 54, 'Hồng Nhạt', 'ONE', 'products/variants/jmn0DuylsodAuuybIsVJm29ObqjlgwI94nji3Cou.webp', 'products/variants/wa3q3YoM0FqkdzDfrkGr9vcps1VQKFqZj2QIihjg.webp', 9, '2026-10-31 01:34:15', '2026-10-31 02:23:42'),
	(213, 54, 'Vàng Gà', 'ONE', 'products/variants/q80DqyFeBLJ89JTZRl5DYDPoDdJOg4aTFB9ArLJv.webp', 'products/variants/JInYC0peKZW4tEkt1s6UYfyIwQM5gpZ1ymXmSeFZ.webp', 9, '2026-10-31 01:34:15', '2026-10-31 02:23:42'),
	(214, 54, 'Xanh Lá', 'ONE', 'products/variants/9Njknh0dorjmSwUeWXRX1v5J0sEbnlf7JXEiL00H.webp', 'products/variants/4N4pFSNmBaSi6zH7HHWSUlCKFcaL3abUD4yahOBk.webp', 9, '2026-10-31 01:34:15', '2026-10-31 02:23:42');

-- Dumping structure for table fashion_store.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fashion_store.sessions: ~0 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('m4cHAp5LVgJNodQxnS638qfoVBRpQex577mrZACi', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36 Edg/156.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiR05EY1BkbU91OExHWkR0U2l4djM4d1VHeldXUmk0aElZMEJEZXlUUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wcm9kdWN0cy8yMy9lZGl0IjtzOjU6InJvdXRlIjtzOjE5OiJhZG1pbi5wcm9kdWN0cy5lZGl0Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiNmMxZTU5NzI2YmZjZWM1ODRjZjM4MjIzZjU2ODYxNmFkMzJiYjhjMDc3NmU3YTcxYmY4M2IyMGYwZTY2M2RmMSI7fQ==', 1793518251),
	('yTQUnYt0oAzXTSblA8czdOtsHCbXlOsgV5wnh8YT', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36 Edg/156.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiS0IzYWlMQ3hZcEFpUmNsMUZNQlFSM3pqQ1JpNE1acHdaQVU0WGZJZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6ImVlM2M3YTlkM2VlMzIyNDg2NDhhNDM2ZmRiNGJkODU0NTI2NDcwMzJhMDY4MGY4YjAzYWM3MGI2YTZmNTFmYmMiO30=', 1793512973);

-- Dumping structure for table fashion_store.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street_address` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_province_id` int unsigned DEFAULT NULL,
  `shipping_district_id` int unsigned DEFAULT NULL,
  `shipping_ward_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cart` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fashion_store.users: ~0 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `phone`, `shipping_address`, `street_address`, `shipping_province_id`, `shipping_district_id`, `shipping_ward_code`, `cart`) VALUES
	(1, 'Lê Văn Nâu', 'admin@fashion.test', NULL, '$2y$12$l0w34kzZ.VVSjbbCAQ743.cm10K11sDYfYJoZxryGDuTZoo/.i.QG', 'admin', 'uUHL0uTmRxpvFgQ5b7YfWvj4cpoSsplowBe7vufSOGhSno1LXoHvAIxtiGW2', '2026-10-24 00:16:21', '2026-11-02 06:12:36', '0939001799', '211 Khánh Nghĩa Tân Khánh Đông, Xã Tân Khánh Đông, Thành phố Sa Đéc, Đồng Tháp', '211 Khánh Nghĩa Tân Khánh Đông', 216, 1668, '500207', '[]'),
	(2, 'Fashion User', 'user@fashion.test', NULL, '$2y$12$9PF6ffu.hFpcvVj915Q2uONKpqvQx8/C8Khdyw1KPWCMBCi9gtLii', 'user', NULL, '2026-10-24 00:16:21', '2026-10-25 01:48:03', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(3, 'Bảo Ngọc', 'clbaongoc2508@gmail.com', NULL, '$2y$12$WduNA.YhO3uC3arlC5upv.RUFBCIpeCtMUDmv20//Y4I019jMCSEG', 'user', 'yzPHD5Akg3gAoVyDjRZ3uP7WSuCrKij4NBMput86NEmUaq4POHNkwkJg2fIJ', '2026-10-25 04:21:37', '2026-11-02 06:12:17', NULL, NULL, NULL, NULL, NULL, NULL, '{"v_53_s_S": 1}'),
	(4, 'Lê Thị Kim Xuân', 'ltkxuan17@gmail.com', NULL, '$2y$12$b1eBSxN6pPec6oVjOh7xyeJp/Ukuaq5m5g5heHGlyr1Q8zc6McGX.', 'user', 'xFmeL9HbZLrs6mMkJW3HuLqsM9TNyI1ml2GIV74KEg1MrbzPSE4r4bkFLtTj', '2026-10-28 10:40:37', '2026-10-31 23:01:39', '0939001799', '211 Khánh Nghĩa Tân Khánh Đông, Xã Tân Khánh Đông, Thành phố Sa Đéc, Đồng Tháp', '211 Khánh Nghĩa Tân Khánh Đông', 216, 1668, '500207', NULL);

-- Dumping structure for table fashion_store.wishlists
CREATE TABLE IF NOT EXISTS `wishlists` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wishlists_user_id_product_id_unique` (`user_id`,`product_id`),
  KEY `wishlists_product_id_foreign` (`product_id`),
  CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table fashion_store.wishlists: ~18 rows (approximately)
INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
	(3, 1, 18, '2026-10-30 19:41:15', '2026-10-30 19:41:15'),
	(4, 1, 19, '2026-10-30 19:41:19', '2026-10-30 19:41:19'),
	(5, 1, 48, '2026-10-30 21:31:52', '2026-10-30 21:31:52'),
	(7, 1, 45, '2026-10-30 21:32:05', '2026-10-30 21:32:05'),
	(11, 1, 31, '2026-10-30 21:51:50', '2026-10-30 21:51:50'),
	(13, 1, 40, '2026-10-30 21:57:42', '2026-10-30 21:57:42'),
	(14, 1, 38, '2026-10-30 22:12:56', '2026-10-30 22:12:56'),
	(15, 1, 44, '2026-10-30 22:27:40', '2026-10-30 22:27:40'),
	(16, 1, 10, '2026-10-30 23:41:21', '2026-10-30 23:41:21'),
	(17, 1, 37, '2026-10-31 00:31:08', '2026-10-31 00:31:08'),
	(18, 1, 34, '2026-10-31 00:31:57', '2026-10-31 00:31:57'),
	(20, 1, 17, '2026-10-31 02:45:52', '2026-10-31 02:45:52'),
	(21, 1, 49, '2026-10-31 02:52:18', '2026-10-31 02:52:18'),
	(22, 4, 37, '2026-10-31 11:04:18', '2026-10-31 11:04:18'),
	(24, 4, 28, '2026-10-31 23:07:19', '2026-10-31 23:07:19'),
	(25, 4, 14, '2026-10-31 23:07:25', '2026-10-31 23:07:25'),
	(26, 4, 41, '2026-10-31 23:07:41', '2026-10-31 23:07:41');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
