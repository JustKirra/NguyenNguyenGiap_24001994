SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `product_api` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `product_api`;

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `products` (`id`, `name`, `price`, `stock`) VALUES
(1, 'Bút bi', 5000, 20),
(2, 'Vở ô ly', 12000, 15),
(3, 'Thước kẻ', 8000, 0),
(4, 'Bút chì 2B', 4000, 30),
(5, 'Tẩy', 3000, 25),
(6, 'Bút dạ quang', 9000, 12),
(7, 'Compa', 15000, 8),
(8, 'Sổ tay bìa cứng', 35000, 10),
(9, 'Bìa hồ sơ', 6000, 40),
(10, 'Kẹp giấy (hộp)', 7000, 18),
(11, 'Băng keo trong', 10000, 22),
(12, 'Hồ dán', 8000, 14);

COMMIT;