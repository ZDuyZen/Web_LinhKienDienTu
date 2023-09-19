-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2023 at 04:17 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ql_linhkien`
--

-- --------------------------------------------------------

CREATE TABLE hang_san_xuat (
  hang_sx_id VARCHAR(10) PRIMARY KEY,
  Ten_hang_sx VARCHAR(50)
);


CREATE TABLE danh_muc (
  danh_muc_id VARCHAR(10) PRIMARY KEY,
  danh_muc_name VARCHAR(50)
);

CREATE TABLE san_pham (
  sp_id int PRIMARY KEY,
  sp_name VARCHAR(50),
  mo_ta VARCHAR(50),
  gia DECIMAL(10, 2),
  so_luong_ton INT,
  sp_hinh VARCHAR(50),
  danh_muc_id VARCHAR(10),
  hang_sx_id VARCHAR(10),
  FOREIGN KEY (danh_muc_id) REFERENCES danh_muc(danh_muc_id),
  FOREIGN KEY (hang_sx_id) REFERENCES hang_san_xuat(hang_sx_id)
);


CREATE TABLE `tai_khoan` (
  `id_DN` int NOT NULL,
  `ten_DN` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `matkhau` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `admin` int NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `token` int DEFAULT NULL,
  `datetime_reset` datetime DEFAULT NULL
);

CREATE TABLE `gio_hang` (
  gio_hang_id int NOT NULL,
  gio_hang_name varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  gio_hang_gia int NOT NULL,
  gio_hang_soluong int NOT NULL,
  gio_hang_trang_thai int
);




ALTER TABLE tai_khoan ADD PRIMARY KEY (id_DN);
ALTER TABLE tai_khoan MODIFY id_DN INT AUTO_INCREMENT;


ALTER TABLE san_pham MODIFY sp_id INT AUTO_INCREMENT;



INSERT INTO `tai_khoan` (`id_DN`, `ten_DN`, `matkhau`, `admin`, `email`, `token`, `datetime_reset`) VALUES
(1, 'admin', '$2y$10$CgbhaY/di/JXaLmo93wqqu4Gi046tcHi61OE48QUKS0e1mdztkdkK', 1, 'zenonaws@gmail.com', NULL, NULL);




INSERT INTO danh_muc (danh_muc_id, danh_muc_name) VALUES
('DM1', 'Ổ cứng'), 
('DM2', 'Ram'), 
('DM3', 'Card đô họa'), 
('DM4', 'Bàn phím'), 
('DM5', 'Màn hình'),
('DM6', 'Chuột'),
('DM7', 'Main máy tính'),
('DM8', 'CPU'),
('DM9', 'Case Máy Tính'),
('DM10', 'Tai nghe'),
('DM11', 'Tản Nhiệt'),
('DM12', 'Sạc dự phòng'), 
('DM13', 'Camera'),
('DM14', 'Pin'),
('DM15', 'Loa'),
('DM16', 'Miếng lót chuột'),
('DM17', 'Phụ kiện khác');

INSERT INTO hang_san_xuat (hang_sx_id, Ten_hang_sx) VALUES
('HSX1', 'Samsung'), 
('HSX2', 'Asus'), 
('HSX3', 'Razer'), 
('HSX4', 'Logitech'), 
('HSX5', 'HP'),
('HSX6', 'Zoda'),
('HSX7', 'Havit'),
('HSX8', 'Vulcan'),
('HSX9', 'Intel'),
('HSX10', 'Kingston');


INSERT INTO `san_pham` (`sp_id`, `sp_name`, `mo_ta`, `gia`, `sp_hinh`, `danh_muc_id`, `hang_sx_id`) 
VALUES
(1, 'Pin Zoda 10.000mAh', 'Pin 10.000mAh sạc siêu nhanh', 350000, 'pin_1.jpg', 'DM14', 'HSX6'),
(2, 'Loa Bluetooth Havit SK838BT', 'Loa bluetooth nghe siêu hay', 290000, 'loa_1.jpg', 'DM15', 'HSX7'),
(3, 'Tai nghe Gaming HAVIT H2232D', 'Tai nghe với chất âm cực chất', 290000, 'tainghe_1.jpg', 'DM10', 'HSX7'),
(4, 'Camera iPhone 14/14 Plus Zeelot', 'Camera chụp siêu nét', 315000, 'camera_1.jpg','DM10', 'HSX7'),
(5, 'Miếng lót chuột Doremon x logitech', 'Lót chuột siêu êm', 900000, 'lotchuot_1.jpg', 'DM16', 'HSX4'),
(6, 'Tản Nhiệt VulCan', 'Tản nhiệt siêu mát', 9000000, 'tannhiet_1.jpg', 'DM11', 'HSX8'),
(7, 'Adurno Điều Khiển', 'Điều khiển', 12000000, 'pk_1.jpg', 'DM17', 'HSX1'),
(8, 'Case Máy Tính XZ Máy Tính Siêu Đẹp', 'Case siêu đẹp cho máy tính', 3000000, 'case_1.jpg', 'DM9', 'HSX2'),
(9, 'Chip Intel 3770k 1155', 'Chip cho máy tính', 3000000, 'cpu_1.jpg', 'DM8', 'HSX9'),
(10, 'Ram 8G Samsung DDR5 buss 3200', 'Tăng tốc máy tính', 1500000, 'ram_1.jpg', 'DM2', 'HSX1'),
(11, 'Ram 4G Kingston DDR3 buss 1600', 'Tăng tốc máy tính', 500000, 'ram_2.jpg', 'DM2', 'HSX10'),
(12, 'Ổ cứng SSD 256G Kingston', 'Tăng dung lượng lưu trữ', 500000, 'ocung_1.jpg', 'DM1', 'HSX10'),
(13, 'Ổ cứng HDD 1TB', 'Tăng dung lượng lưu trữ', 600000, 'ocung.jpg', 'DM1', 'HSX10'),
(14, 'Màn Hình Razer 26inch', 'Màn hình siêu to', 5000000, 'manhinh_1.jpg', 'DM5', 'HSX3'),
(15, 'Dây Led 7 màu', 'Trang trí máy tính', 50000, 'pk_2.jpg', 'DM17', 'HSX8'),
(16, 'Nguồn 250w VulCal', 'Nguồn siêu bền', 2500000, 'pk_3.jpg', 'DM17', 'HSX8'),
(17, 'Bàn phím Led Kingston', 'Bàn phím gaming', 750000, 'banphim_1.jpg', 'DM4', 'HSX10'),
(18, 'VGA 750Ti', 'Card màn hình', 8500000, 'card-1.jpg', 'DM3', 'HSX2'),
(19, 'VGA 1050Ti', 'VGA 1050Ti GIGABYTE', 1500000, 'image-4.jpg', 'DM3', 'HSX9'),
(20, 'Chuột Asus Gaming', 'Chuột siêu nhạy', 850000, 'chuot_2.jpg', 'DM6', 'HSX2'),
(21, 'Chuột Văn Phòng Logitech', 'Chuột siêu nhạy', 80000, 'chuot_3.jpg', 'DM6', 'HSX4'),
(22, 'Main Xanh GIGABYTE GA-B75', 'Main', 5800000, 'main_1.jpg', 'DM7', 'HSX3'),
(23, 'Main Đen Gaming Intel', 'Main', 1200000, 'main_2.jpg', 'DM7', 'HSX9');

