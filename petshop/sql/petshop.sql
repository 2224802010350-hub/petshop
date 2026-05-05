-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2026 at 07:59 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `petshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_don_hang`
--

CREATE TABLE `chi_tiet_don_hang` (
  `id` int(11) NOT NULL,
  `id_don_hang` int(11) NOT NULL,
  `id_san_pham` int(11) NOT NULL,
  `so_luong` int(11) NOT NULL,
  `don_gia` int(11) NOT NULL,
  `thanh_tien` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chi_tiet_don_hang`
--

INSERT INTO `chi_tiet_don_hang` (`id`, `id_don_hang`, `id_san_pham`, `so_luong`, `don_gia`, `thanh_tien`) VALUES
(1, 1, 8, 2, 9000000, 18000000),
(2, 2, 22, 1, 15000000, 0),
(3, 2, 21, 1, 15000000, 0),
(4, 2, 20, 2, 15000000, 0),
(5, 3, 24, 1, 132000, 0),
(6, 3, 23, 1, 9000000, 0),
(7, 4, 23, 1, 9000000, 0),
(8, 4, 22, 2, 15000000, 0),
(9, 5, 23, 1, 9000000, 0),
(10, 5, 19, 1, 9000000, 0),
(11, 5, 11, 1, 17000000, 0),
(12, 6, 22, 1, 15000000, 0),
(13, 7, 24, 1, 132000, 0),
(14, 7, 23, 1, 9000000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_phieu_nhap`
--

CREATE TABLE `chi_tiet_phieu_nhap` (
  `id` int(11) NOT NULL,
  `phieu_nhap_id` int(11) NOT NULL,
  `san_pham_id` int(11) NOT NULL,
  `so_luong` int(11) NOT NULL DEFAULT 1,
  `gia_nhap` decimal(12,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chi_tiet_phieu_nhap`
--

INSERT INTO `chi_tiet_phieu_nhap` (`id`, `phieu_nhap_id`, `san_pham_id`, `so_luong`, `gia_nhap`) VALUES
(1, 1, 24, 20, 0.00),
(2, 2, 24, 35, 55000.00),
(3, 3, 24, 9, 132000.00),
(4, 4, 10, 3, 16000000.00),
(5, 5, 11, 99, 17000000.00);

-- --------------------------------------------------------

--
-- Table structure for table `danh_muc`
--

CREATE TABLE `danh_muc` (
  `id` int(11) NOT NULL,
  `ten_danh_muc` varchar(120) NOT NULL,
  `trang_thai` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `danh_muc`
--

INSERT INTO `danh_muc` (`id`, `ten_danh_muc`, `trang_thai`) VALUES
(1, 'Thức ăn', 1),
(2, 'Phụ kiện', 1),
(3, 'Đồ chơi', 1),
(4, 'Chó cảnh', 1),
(5, 'Mèo cảnh', 1);

-- --------------------------------------------------------

--
-- Table structure for table `dat_dich_vu_spa`
--

CREATE TABLE `dat_dich_vu_spa` (
  `id` int(11) NOT NULL,
  `ma_tra_cuu` varchar(20) DEFAULT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `so_dien_thoai` varchar(20) NOT NULL,
  `ten_thu_cung` varchar(100) NOT NULL,
  `can_nang` varchar(50) NOT NULL,
  `dich_vu_chinh` varchar(100) NOT NULL,
  `dich_vu_them` text DEFAULT NULL,
  `ngay_dat` date NOT NULL,
  `gio_dat` time NOT NULL,
  `ghi_chu` text DEFAULT NULL,
  `trang_thai` varchar(50) DEFAULT 'Chờ xác nhận',
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dat_dich_vu_spa`
--

INSERT INTO `dat_dich_vu_spa` (`id`, `ma_tra_cuu`, `ho_ten`, `so_dien_thoai`, `ten_thu_cung`, `can_nang`, `dich_vu_chinh`, `dich_vu_them`, `ngay_dat`, `gio_dat`, `ghi_chu`, `trang_thai`, `ngay_tao`) VALUES
(2, 'SPA1777719405', 'Thuong', '0987654321', 'Miu', '3 - 5kg', 'Vệ sinh', 'Spa 9 bước thơm tho', '2026-05-07', '22:57:00', 'ko', 'Đã xác nhận', '2026-05-02 10:56:45'),
(3, 'DV1777741008', 'thanh', '0909090909', 'bông', '5 - 10kg', 'Spa Full', 'Spa 9 bước thơm tho', '2026-05-08', '20:28:00', '[Loại dịch vụ: Spa thú cưng] ko', 'Đã xác nhận', '2026-05-02 16:56:48'),
(4, 'DV1777741547', 'Thuong', '0987654321', 'lu', '< 5kg', 'Hồ bơi thú cưng - Gói 5 lần', 'Spa Full', '2026-05-05', '00:08:00', '[Loại dịch vụ: Hồ bơi - Sân chơi] ko', 'Đã hoàn thành', '2026-05-02 17:05:47'),
(5, 'DV1777743587', 'cong', '1212121212', 'piu', '7 - 12kg', 'Khách sạn thú cưng - Qua đêm', 'Spa Full', '2026-05-14', '00:41:00', '[Loại dịch vụ: Khách sạn thú cưng] ko', 'Đã hoàn thành', '2026-05-02 17:39:47');

-- --------------------------------------------------------

--
-- Table structure for table `dich_vu`
--

CREATE TABLE `dich_vu` (
  `id` int(11) NOT NULL,
  `ten_dich_vu` varchar(200) NOT NULL,
  `gia` int(11) NOT NULL DEFAULT 0,
  `thoi_luong_phut` int(11) NOT NULL DEFAULT 30,
  `trang_thai` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dich_vu`
--

INSERT INTO `dich_vu` (`id`, `ten_dich_vu`, `gia`, `thoi_luong_phut`, `trang_thai`) VALUES
(1, 'Tắm thú cưng', 120000, 45, 1),
(2, 'Cắt tỉa lông', 150000, 60, 1),
(3, 'Spa cơ bản', 200000, 60, 1);

-- --------------------------------------------------------

--
-- Table structure for table `dich_vu_ho_boi`
--

CREATE TABLE `dich_vu_ho_boi` (
  `id` int(11) NOT NULL,
  `can_nang` varchar(50) NOT NULL,
  `mot_lan` int(11) NOT NULL,
  `goi_5_lan` int(11) NOT NULL,
  `goi_10_lan` int(11) NOT NULL,
  `uu_dai` int(11) DEFAULT 50000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dich_vu_ho_boi`
--

INSERT INTO `dich_vu_ho_boi` (`id`, `can_nang`, `mot_lan`, `goi_5_lan`, `goi_10_lan`, `uu_dai`) VALUES
(1, '< 5kg', 280000, 1200000, 2000000, 50000),
(2, '5 - 10kg', 330000, 1300000, 2400000, 50000),
(3, '10 - 15kg', 380000, 1500000, 2800000, 50000),
(4, '15 - 20kg', 430000, 1700000, 3200000, 49999),
(5, '20 - 25kg', 540000, 2200000, 4000000, 50000),
(7, '25 - 30kg', 600000, 2700000, 4500000, 50000);

-- --------------------------------------------------------

--
-- Table structure for table `dich_vu_khachsan`
--

CREATE TABLE `dich_vu_khachsan` (
  `id` int(11) NOT NULL,
  `can_nang` varchar(50) NOT NULL,
  `qua_dem` int(11) NOT NULL,
  `trong_ngay` int(11) NOT NULL,
  `nua_ngay` int(11) NOT NULL,
  `mot_den_ba_tieng` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dich_vu_khachsan`
--

INSERT INTO `dich_vu_khachsan` (`id`, `can_nang`, `qua_dem`, `trong_ngay`, `nua_ngay`, `mot_den_ba_tieng`) VALUES
(1, '< 3kg', 280000, 130000, 100000, 60000),
(2, '3 - 7kg', 310000, 170000, 130000, 80000),
(3, '7 - 12kg', 350000, 220000, 180000, 100000),
(4, '12 - 18kg', 420000, 280000, 220000, 130000),
(5, '18 - 25kg', 500000, 330000, 270000, 170000),
(6, '25 - 30kg', 600000, 390000, 330000, 230000);

-- --------------------------------------------------------

--
-- Table structure for table `dich_vu_spa`
--

CREATE TABLE `dich_vu_spa` (
  `id` int(11) NOT NULL,
  `can_nang` varchar(50) NOT NULL,
  `ve_sinh` int(11) NOT NULL,
  `spa_co_ban` int(11) NOT NULL,
  `spa_full` int(11) NOT NULL,
  `grooming` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dich_vu_spa`
--

INSERT INTO `dich_vu_spa` (`id`, `can_nang`, `ve_sinh`, `spa_co_ban`, `spa_full`, `grooming`) VALUES
(1, '< 3kg', 150000, 200000, 300000, 450000),
(2, '3 - 5kg', 170000, 230000, 330000, 560000),
(3, '5 - 10kg', 200000, 270000, 380000, 650000),
(4, '10 - 15kg', 250000, 320000, 450000, 750000),
(5, '15 - 20kg', 300000, 380000, 550000, 850000),
(6, '> 20kg', 350000, 450000, 650000, 950000);

-- --------------------------------------------------------

--
-- Table structure for table `don_hang`
--

CREATE TABLE `don_hang` (
  `id` int(11) NOT NULL,
  `ma_don` varchar(20) DEFAULT NULL,
  `id_khach_hang` int(11) DEFAULT NULL,
  `id_nhan_vien` int(11) NOT NULL,
  `ngay_tao` datetime NOT NULL DEFAULT current_timestamp(),
  `ngay_cap_nhat` datetime DEFAULT NULL,
  `trang_thai_giao_hang` enum('DA_XAC_NHAN','CHO_GIAO_HANG','GIAO_THANH_CONG','HUY') NOT NULL DEFAULT 'DA_XAC_NHAN',
  `phuong_thuc_tt` enum('COD','ONLINE') NOT NULL DEFAULT 'COD',
  `trang_thai` enum('CHUA_THANH_TOAN','DA_THANH_TOAN','HUY') NOT NULL DEFAULT 'CHUA_THANH_TOAN',
  `thoi_diem_thanh_toan` datetime DEFAULT NULL,
  `tam_tinh` int(11) NOT NULL DEFAULT 0,
  `giam_gia` int(11) NOT NULL DEFAULT 0,
  `tong_tien` int(11) NOT NULL DEFAULT 0,
  `ghi_chu` varchar(255) DEFAULT NULL,
  `ten_nhan` varchar(100) DEFAULT NULL,
  `sdt_nhan` varchar(20) DEFAULT NULL,
  `email_nhan` varchar(120) DEFAULT NULL,
  `dia_chi_nhan` varchar(255) DEFAULT NULL,
  `da_cong_diem_than_thiet` tinyint(1) NOT NULL DEFAULT 0,
  `email_khach` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `don_hang`
--

INSERT INTO `don_hang` (`id`, `ma_don`, `id_khach_hang`, `id_nhan_vien`, `ngay_tao`, `ngay_cap_nhat`, `trang_thai_giao_hang`, `phuong_thuc_tt`, `trang_thai`, `thoi_diem_thanh_toan`, `tam_tinh`, `giam_gia`, `tong_tien`, `ghi_chu`, `ten_nhan`, `sdt_nhan`, `email_nhan`, `dia_chi_nhan`, `da_cong_diem_than_thiet`, `email_khach`) VALUES
(1, 'DH999999', NULL, 1, '2026-03-02 00:05:27', '2026-03-02 00:05:27', 'DA_XAC_NHAN', 'COD', 'DA_THANH_TOAN', '2026-04-30 16:33:43', 18000000, 0, 18000000, 'Test đơn', 'Test', '0900000000', 'test@gmail.com', 'Bình Dương', 0, NULL),
(2, 'DH2026043011231713', 4, 1, '2026-04-30 16:23:17', NULL, 'DA_XAC_NHAN', 'COD', 'DA_THANH_TOAN', '2026-04-30 16:33:33', 60000000, 0, 60000000, NULL, NULL, NULL, NULL, NULL, 0, ''),
(3, 'DH2026043018583839', 4, 1, '2026-04-30 23:58:38', NULL, 'DA_XAC_NHAN', 'ONLINE', 'DA_THANH_TOAN', '2026-04-30 23:58:47', 9132000, 0, 9132000, NULL, NULL, NULL, NULL, NULL, 1, ''),
(4, 'DH2026043019054165', 1, 1, '2026-05-01 00:05:41', NULL, 'DA_XAC_NHAN', 'COD', 'DA_THANH_TOAN', '2026-05-01 00:05:47', 39000000, 0, 39000000, NULL, NULL, NULL, NULL, NULL, 1, ''),
(5, 'DH2026043019102058', 4, 1, '2026-05-01 00:10:20', NULL, 'DA_XAC_NHAN', 'COD', 'DA_THANH_TOAN', '2026-05-01 00:11:20', 35000000, 0, 35000000, NULL, NULL, NULL, NULL, NULL, 1, ''),
(6, 'DH2026043019114616', 1, 1, '2026-05-01 00:11:46', NULL, 'DA_XAC_NHAN', 'COD', 'DA_THANH_TOAN', '2026-05-01 00:11:49', 15000000, 0, 15000000, NULL, NULL, NULL, NULL, NULL, 1, ''),
(7, 'DH2026043019365152', 3, 1, '2026-05-01 00:36:51', NULL, 'DA_XAC_NHAN', 'COD', 'DA_THANH_TOAN', '2026-05-01 00:37:13', 9132000, 0, 9132000, NULL, NULL, NULL, NULL, NULL, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `khach_hang`
--

CREATE TABLE `khach_hang` (
  `id` int(11) NOT NULL,
  `ho_ten` varchar(120) NOT NULL,
  `so_dien_thoai` varchar(20) NOT NULL,
  `email` varchar(120) DEFAULT NULL,
  `dia_chi` varchar(255) DEFAULT NULL,
  `hang_khach` enum('thuong','vip') NOT NULL DEFAULT 'thuong',
  `diem` int(11) NOT NULL DEFAULT 0,
  `ngay_tao` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `khach_hang`
--

INSERT INTO `khach_hang` (`id`, `ho_ten`, `so_dien_thoai`, `email`, `dia_chi`, `hang_khach`, `diem`, `ngay_tao`) VALUES
(1, 'Nguyễn Văn A', '0900000001', 'a@gmail.com', 'Hà Nội', 'thuong', 0, '2026-01-29 15:51:39'),
(2, 'Trần Thị B', '0900000002', 'b@gmail.com', 'TP.HCM', 'vip', 10, '2026-01-29 15:51:39'),
(3, 'Lê Văn C', '0900000003', NULL, 'Đà Nẵng', 'thuong', 0, '2026-01-29 15:51:39'),
(4, 'Thanh', '1234567890', '2224802010350@student.tdmu.edu.vn', 'Phường Phú Lợi', 'vip', 107, '2026-04-30 13:48:14'),
(5, 'Thương', '1234567899', 'thuong@gmail.com', 'VN', 'thuong', 0, '2026-05-01 00:51:23');

-- --------------------------------------------------------

--
-- Table structure for table `khach_hang_than_thiet`
--

CREATE TABLE `khach_hang_than_thiet` (
  `id` int(11) NOT NULL,
  `khach_hang_id` int(11) NOT NULL,
  `diem` int(11) NOT NULL DEFAULT 0,
  `hang_thanh_vien` varchar(50) NOT NULL DEFAULT 'Đồng',
  `ghi_chu` text DEFAULT NULL,
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp(),
  `ngay_cap_nhat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `khach_hang_than_thiet`
--

INSERT INTO `khach_hang_than_thiet` (`id`, `khach_hang_id`, `diem`, `hang_thanh_vien`, `ghi_chu`, `ngay_tao`, `ngay_cap_nhat`) VALUES
(1, 4, 4414, 'Bạc', '', '2026-04-30 07:01:22', '2026-04-30 17:11:20'),
(2, 1, 5400, 'Bạc', 'Tự động cộng điểm từ đơn hàng', '2026-04-30 17:05:47', '2026-04-30 17:11:49'),
(5, 3, 913, 'Đồng', '', '2026-04-30 17:23:44', '2026-04-30 17:37:13');

-- --------------------------------------------------------

--
-- Table structure for table `lich_hen`
--

CREATE TABLE `lich_hen` (
  `id` int(11) NOT NULL,
  `id_khach_hang` int(11) NOT NULL,
  `id_dich_vu` int(11) NOT NULL,
  `id_nhan_vien` int(11) NOT NULL,
  `thoi_gian_hen` datetime NOT NULL,
  `trang_thai` enum('DA_DAT','DANG_LAM','HOAN_THANH','HUY') NOT NULL DEFAULT 'DA_DAT',
  `ghi_chu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `id` int(11) NOT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `ten_dang_nhap` varchar(50) NOT NULL,
  `mat_khau_hash` varchar(255) NOT NULL,
  `vai_tro` enum('admin','banhang','dichvu','thukho','khach') NOT NULL DEFAULT 'khach',
  `trang_thai` tinyint(4) NOT NULL DEFAULT 1,
  `ngay_tao` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`id`, `ho_ten`, `ten_dang_nhap`, `mat_khau_hash`, `vai_tro`, `trang_thai`, `ngay_tao`) VALUES
(1, 'Admin', 'admin', '$2y$10$H388JFTRDYK.PPOm8NcS5uANjQCfLNHuU9LGURto.4.jZo76npIA.', 'admin', 1, '2026-01-29 15:51:39'),
(2, 'NV Bán Hàng', 'banhang', '$2y$10$wq8U9Tn6zM3k6xQ8m7lXeu0p6fC0mXwq9m8Yq0mO8x3gZ7j5p3X1S', 'banhang', 1, '2026-01-29 15:51:39'),
(3, 'NV Dịch Vụ', 'dichvu', '$2y$10$wq8U9Tn6zM3k6xQ8m7lXeu0p6fC0mXwq9m8Yq0mO8x3gZ7j5p3X1S', 'dichvu', 1, '2026-01-29 15:51:39'),
(4, 'Thủ Kho', 'thukho', '$2y$10$wq8U9Tn6zM3k6xQ8m7lXeu0p6fC0mXwq9m8Yq0mO8x3gZ7j5p3X1S', 'thukho', 1, '2026-01-29 15:51:39'),
(5, 'Nguyen Thi Thanh', 'Thanh Thanh', '$2y$10$P9dce1wfvdPnwbvGG6RjzeudMpml4o76VXohF38eoEHwbeG9d8mJS', '', 1, '2026-05-01 01:27:10'),
(6, 'Nguyen Thi Thanh', 'Thanh', '$2y$10$4WI5WYkODYK8qCmD/Hnl9O4QA3GL8k6Us2Pft36Fl/dxnMY4ojSbq', '', 1, '2026-05-01 01:27:51'),
(7, 'Khách hàng test', 'khach1', '$2y$10$8CdS4iA8yvhEoo2wPZPHGupfKBf2YbM7jZjCvIu1P0p6K1QsL.ZnK', 'khach', 1, '2026-05-01 01:34:08'),
(8, 'Thanh', 'thanh1', '$2y$10$zX.pkzVQ4FbF..oL/XrT1.XnLfAUVMr3oEvwgVUQb2tk0Enbn5KZO', 'khach', 1, '2026-05-01 01:34:54'),
(9, 'Thương', 'Thuong', '$2y$10$/mL6FvmSaUQc.LjOHoj6teBJd3rm1tm1SUcMVpyBNHdb4RKNgNyDG', 'khach', 1, '2026-05-01 01:49:49');

-- --------------------------------------------------------

--
-- Table structure for table `nha_cung_cap`
--

CREATE TABLE `nha_cung_cap` (
  `id` int(11) NOT NULL,
  `ten_nha_cung_cap` varchar(255) NOT NULL,
  `nguoi_lien_he` varchar(255) DEFAULT NULL,
  `so_dien_thoai` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `dia_chi` varchar(255) DEFAULT NULL,
  `ghi_chu` text DEFAULT NULL,
  `trang_thai` tinyint(1) NOT NULL DEFAULT 1,
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nha_cung_cap`
--

INSERT INTO `nha_cung_cap` (`id`, `ten_nha_cung_cap`, `nguoi_lien_he`, `so_dien_thoai`, `email`, `dia_chi`, `ghi_chu`, `trang_thai`, `ngay_tao`) VALUES
(1, 'Royal Canin', 'Thanh', '0987654321', '2224802010350@student.tdmu.edu.vn', 'Phường Phú Lợi', 'Thức Ăn Hạt Cho Mèo Trưởng Thành Nuôi Trong Nhà', 1, '2026-04-15 03:18:44'),
(2, 'gfh', 'yh', '8664', '2224802010350@student.tdmu.edu.vn', 'yyy', '557', 1, '2026-04-15 03:28:54');

-- --------------------------------------------------------

--
-- Table structure for table `phieu_nhap`
--

CREATE TABLE `phieu_nhap` (
  `id` int(11) NOT NULL,
  `ma_phieu` varchar(50) NOT NULL,
  `nha_cung_cap_id` int(11) NOT NULL,
  `ngay_nhap` datetime NOT NULL DEFAULT current_timestamp(),
  `tong_tien` decimal(12,2) NOT NULL DEFAULT 0.00,
  `ghi_chu` text DEFAULT NULL,
  `trang_thai` varchar(30) NOT NULL DEFAULT 'draft',
  `admin_id` int(11) DEFAULT NULL,
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phieu_nhap`
--

INSERT INTO `phieu_nhap` (`id`, `ma_phieu`, `nha_cung_cap_id`, `ngay_nhap`, `tong_tien`, `ghi_chu`, `trang_thai`, `admin_id`, `ngay_tao`) VALUES
(1, 'PN20260415001', 1, '2026-04-15 11:28:15', 0.00, '', 'cancelled', 1, '2026-04-15 04:28:15'),
(2, 'PN20260415002', 1, '2026-04-15 11:28:51', 1925000.00, '', 'confirmed', 1, '2026-04-15 04:28:51'),
(3, 'PN20260422001', 1, '2026-04-22 10:32:18', 1188000.00, '', 'confirmed', 1, '2026-04-22 03:32:18'),
(4, 'PN20260422002', 2, '2026-04-22 10:36:00', 48000000.00, '', 'confirmed', 1, '2026-04-22 03:36:00'),
(5, 'PN20260422003', 1, '2026-04-22 10:40:09', 1683000000.00, '', 'confirmed', 1, '2026-04-22 03:40:09');

-- --------------------------------------------------------

--
-- Table structure for table `san_pham`
--

CREATE TABLE `san_pham` (
  `id` int(11) NOT NULL,
  `id_danh_muc` int(11) NOT NULL,
  `ma_sku` varchar(50) NOT NULL,
  `ten_san_pham` varchar(200) NOT NULL,
  `gia_ban` int(11) NOT NULL DEFAULT 0,
  `ton_kho` int(11) NOT NULL DEFAULT 0,
  `trang_thai` tinyint(4) NOT NULL DEFAULT 1,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `mo_ta` text DEFAULT NULL,
  `ngay_tao` datetime NOT NULL DEFAULT current_timestamp(),
  `so_luong_ton` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `san_pham`
--

INSERT INTO `san_pham` (`id`, `id_danh_muc`, `ma_sku`, `ten_san_pham`, `gia_ban`, `ton_kho`, `trang_thai`, `hinh_anh`, `mo_ta`, `ngay_tao`, `so_luong_ton`) VALUES
(8, 4, 'DOG_SHIBA_01', 'Bé Rin – Shiba Inu', 9000000, 10, 1, '1772390668_6faf3c32.jpg', 'Bé Rin – Shiba Inu thường được nhắc đến là hình ảnh đại diện cho giống chó Shiba nổi tiếng từ Nhật Bản, nổi bật với vẻ ngoài giống cáo, đôi tai tam giác dựng đứng, đuôi xoăn và \"nụ cười\" thân thiện. Shiba là giống chó nhỏ gọn, thông minh, độc lập và trung thành, rất được yêu thích nhờ tính sạch sẽ và vóc dáng gọn gàng.', '2026-02-24 15:10:38', 0),
(9, 5, 'CAT_XIEM_01', 'Mèo Xiêm', 15000000, 20, 1, '1772386775_4070b1b8.jpg', 'Mèo Xiêm là biểu tượng của vẻ đẹp quý tộc với thân hình mảnh mai, săn chắc và đôi mắt màu xanh dương thẳm đầy mê hoặc. Điểm nhận diện đặc trưng nhất của chúng chính là bộ lông ngắn mượt mà với các vùng màu đậm (points) nhấn nhá ở khuôn mặt, tai, bốn chân và đuôi trên nền lông sáng màu. Không chỉ sở hữu ngoại hình sang trọng, mèo Xiêm còn nổi tiếng bởi tính cách thông minh, tình cảm và cực kỳ \"lắm lời\". Chúng thích quấn quýt bên chủ nhân, luôn sẵn sàng \"trò chuyện\" bằng tiếng kêu vang và rất thích tham gia vào các hoạt động gia đình. Đây là người bạn đồng hành lý tưởng cho những ai tìm kiếm một thú cưng năng động, trung thành và có cá tính riêng biệt.', '2026-03-01 09:39:35', 0),
(10, 5, 'CAT_XIEM_02', 'Mèo Xiêm', 16000000, 12, 1, '1772388999_72c796d5.jpg', 'Mèo Xiêm: \"Bản giao hưởng\" của vẻ đẹp và sự thông minh\r\nNếu bạn đang tìm kiếm một người bạn bốn chân không chỉ đẹp mà còn có \"tâm hồn\" sâu sắc, mèo Xiêm chính là câu trả lời hoàn hảo. Được mệnh danh là \"vị thần may mắn\" từ vùng đất Thái Lan cổ xưa, mèo Xiêm gây ấn tượng mạnh ngay từ cái nhìn đầu tiên với đôi mắt xanh thẳm như ngọc bích và bộ lông mang hiệu ứng \"nhiệt độ\" độc đáo — nơi các điểm cực như tai, mặt và chân khoác lên mình những mảng màu sẫm quý phái.\r\n\r\nTrái ngược với vẻ ngoài có phần \"sang chảnh\" và lạnh lùng, mèo Xiêm thực chất là những \"đứa trẻ\" giàu tình cảm. Chúng không chỉ đơn thuần là thú cưng mà còn là một người bạn tâm giao đích thực, luôn bám đuôi và sẵn sàng \"thảo luận\" với bạn về mọi thứ trên đời bằng tông giọng đặc trưng không lẫn vào đâu được. Sự thông minh vượt trội cho phép chúng thấu hiểu cảm xúc của chủ nhân và học hỏi các trò chơi vô cùng nhanh nhạy. Sở hữu một chú mèo Xiêm trong nhà, bạn sẽ không bao giờ cảm thấy cô đơn, bởi mỗi ngày đều sẽ tràn ngập những khoảnh khắc tương tác đầy thú vị và ấm áp.', '2026-03-01 10:16:39', 3),
(11, 4, 'DOG_POM_01', 'Chó Phốc Sóc', 17000000, 19, 1, '1772390249_5eccf364.jpg', 'Chó Phốc Sóc (Pomeranian) tựa như những \"viên kẹo bông\" di động, luôn mang đến niềm vui và sự ấm áp cho mọi không gian mà chúng xuất hiện. Với thân hình nhỏ nhắn ẩn sau lớp lông kép dày mượt, xù bông rực rỡ, mỗi bước đi của chúng đều toát lên vẻ lanh lợi và kiêu kỳ. Đôi mắt đen láy như hai hạt nhãn cùng chiếc mõm nhỏ xinh luôn tạo nên biểu cảm tươi tắn, hớn hở như đang mỉm cười với chủ nhân. Không chỉ sở hữu ngoại hình \"vạn người mê\", Phốc Sóc còn là người bạn cực kỳ tình cảm, thích được cưng nựng và luôn biết cách làm nũng để trở thành tâm điểm của sự chú ý. Có một chú Phốc Sóc bên cạnh, cuộc sống của bạn sẽ luôn tràn ngập tiếng cười và những cái vẫy đuôi đầy hạnh phúc.', '2026-03-01 10:37:29', 99),
(12, 4, 'DOG_CORGI_01', 'Chó Corgi mông to', 5000000, 20, 1, '1772390823_775d5ed8.jpg', 'Corgi chính là những \"đại sứ thương hiệu\" của sự ngộ nghĩnh với ngoại hình không lẫn vào đâu được: đôi chân ngắn ngủn nâng đỡ thân hình tròn trịa, thuôn dài như một ổ bánh mì đại mạch. Thế nhưng, \"vũ khí\" lợi hại nhất giúp Corgi chiếm trọn trái tim mọi người chính là vòng ba siêu cấp nảy nở, thường được ví von là chiếc mông hình trái tim vô cùng gợi cảm. Mỗi khi chúng lon ton chạy bộ hay lắc lư cái mông tròn trịa theo nhịp bước, bất cứ ai cũng phải bật cười thích thú. Kết hợp cùng gương mặt luôn rạng rỡ, đôi tai to dựng đứng và ánh mắt lanh lợi, Corgi giống như một liều thuốc tinh thần ngọt ngào, xua tan mọi mệt mỏi cho chủ nhân sau một ngày dài.', '2026-03-01 10:47:03', 0),
(13, 4, 'DOG_POM_02', 'Chó Phốc Sóc', 16500000, 30, 1, '1772390889_7d5aa41e.jpg', 'Đừng để vẻ ngoài nhỏ bé và điệu đà của Phốc Sóc đánh lừa, bởi đây là giống chó sở hữu cá tính cực kỳ mạnh mẽ và trí thông minh vượt trội. Thuộc nhóm chó loại nhỏ (toy breed), Phốc Sóc cực kỳ năng động, ham học hỏi và có khả năng quan sát nhạy bén. Chúng được ví như những \"người bảo vệ tí hon\" nhờ tinh thần cảnh giác cao độ và tiếng sủa vang dội mỗi khi phát hiện người lạ, thể hiện sự tự tin không hề thua kém các dòng chó lớn. Dù đôi khi hơi bướng bỉnh và có phần \"chảnh\", nhưng sự trung thành tuyệt đối và khả năng thích nghi tốt với cuộc sống căn hộ đã khiến Phốc Sóc trở thành lựa chọn hàng đầu cho những người yêu cún cưng hiện đại.', '2026-03-01 10:48:09', 0),
(14, 4, 'DOG_CORGI_02', 'Chó Corgi mông to', 9000000, 30, 1, '1772390944_1f1d7c27.jpg', 'Đằng sau vẻ ngoài có phần hài hước với đôi chân ngắn và vòng mông \"đồ sộ\" là một giống chó có lịch sử lâu đời và đầy kiêu hãnh. Từng là người bạn đồng hành thân thiết của Nữ hoàng Anh, Corgi sở hữu phong thái tự tin, thông minh và cực kỳ hiểu chuyện. Dù ngoại hình có phần tròn trịa, chúng thực chất là những chú chó chăn gia súc vô cùng năng động, nhanh nhẹn và có tinh thần cảnh giác cao. Corgi không chỉ gây ấn tượng bởi bộ lông dày mượt và cái mông hình trái tim đặc trưng, mà còn bởi sự trung thành tuyệt đối và tính cách vui vẻ, hòa đồng. Đây là người bạn hoàn hảo cho những gia đình hiện đại, mang lại sự kết hợp thú vị giữa vẻ đẹp quý tộc và nét tinh nghịch, đáng yêu.', '2026-03-01 10:49:04', 0),
(16, 4, 'DOG_BICHON_01', 'chó Bichon cục bông đáng yêu', 1600000, 40, 1, '1772525616_0425b36c.jpg', 'Bichon Frise gây ấn tượng mạnh mẽ ngay từ cái nhìn đầu tiên với bộ lông trắng muốt, dày dặn và xoăn tít tựa như những đám mây bồng bềnh. Đôi mắt đen láy như hai hạt nhãn cùng chiếc mũi nhỏ xinh nổi bật trên khuôn mặt tròn trịa, mang đến một vẻ ngoài vừa thông minh lại vừa tinh nghịch. Với dáng đi nhún nhảy đầy tự tin và chiếc đuôi luôn cong vút trên lưng, chúng giống như những \"quý tộc nhỏ\" đầy kiêu hãnh nhưng cũng không kém phần đáng yêu và gần gũi.', '2026-03-03 00:13:36', 0),
(17, 4, 'DOG_BICHON_02', 'chó Bichon cục bông đáng yêu', 1700000, 20, 1, '1772525660_47827724.jpg', 'Đằng sau vẻ ngoài điệu đà ấy là một tâm hồn vô cùng tình cảm và tràn đầy năng lượng. Bichon được ví như những \"người bạn quốc dân\" vì tính cách hòa đồng, luôn khao khát được yêu thương và thích được ở bên cạnh chủ nhân mọi lúc mọi nơi. Không chỉ thân thiện với trẻ em hay các loài vật khác, chúng còn sở hữu trí thông minh nhạy bén, giúp việc huấn luyện những trò chơi nhỏ trở nên dễ dàng và thú vị. Một chú Bichon trong nhà chắc chắn sẽ là liều thuốc tinh thần, mang lại tiếng cười và sự ấm áp cho gia đình bạn.', '2026-03-03 00:14:20', 0),
(18, 5, 'CAT_MAINE_01', 'Mèo maine coon', 15000000, 20, 1, '1772525863_5b178752.jpg', 'Maine Coon sở hữu một ngoại hình ấn tượng với kích thước vượt trội, được mệnh danh là một trong những giống mèo nhà lớn nhất thế giới. Điểm thu hút nhất chính là bộ lông dày, dài và không thấm nước, giúp chúng thích nghi hoàn hảo với khí hậu lạnh giá. Đặc biệt, đôi tai lớn với chùm lông nhọn ở đỉnh (kiểu tai mèo rừng) cùng chiếc đuôi dài, xòe rộng như đuôi sóc tạo nên một vẻ đẹp vừa hoang dã, vừa oai vệ như những vị chúa tể nhỏ trong căn nhà.', '2026-03-03 00:17:43', 0),
(19, 5, 'CAT_MAINE_02', 'Mèo maine coon', 9000000, 29, 1, '1772525900_976367da.jpg', 'Trái ngược hoàn toàn với vẻ ngoài có phần \"hầm hố\", Maine Coon lại nổi tiếng bởi tính cách cực kỳ hiền lành và điềm tĩnh. Chúng thường được gọi là \"chó trong thân xác mèo\" vì sự trung thành, thích đi theo chủ nhân và thậm chí là có khả năng học các trò chơi như nhặt bóng. Không giống như nhiều giống mèo khác thường tỏ ra xa cách, Maine Coon rất tình cảm, thích được giao tiếp bằng những tiếng kêu \"gur-gur\" đặc trưng và đặc biệt là chúng khá yêu thích nước – một nét tính cách rất thú vị và khác biệt.', '2026-03-03 00:18:20', 0),
(20, 5, 'CAT_ALN_01', 'Mèo lông ngắn', 15000000, 21, 1, '1772610213_ef477ad1.jpg', 'Mèo lông ngắn, tiêu biểu như giống mèo Anh lông ngắn (British Shorthair) hay mèo Ta, sở hữu vẻ ngoài gọn gàng với lớp lông dày, mượt và ôm sát cơ thể. Chính đặc điểm này giúp làm tôn lên những đường nét săn chắc và sự linh hoạt trong từng bước đi của chúng. Về mặt thẩm mỹ, chúng mang lại cảm giác hiện đại, sạch sẽ và cực kỳ \"vừa mắt\" với những ai yêu thích sự tối giản.', '2026-03-03 23:43:33', 0),
(21, 5, 'CAT_ALN_02', 'Mèo lông ngắn', 15000000, 43, 1, '1772610259_795c5e78.jpg', 'Điểm cộng lớn nhất của hội lông ngắn chính là sự tiện lợi trong việc chăm sóc. Bạn sẽ không phải đối mặt với nỗi lo lông bị rối bù hay vón cục sau một ngày chúng mải mê chạy nhảy. Việc chải chuốt diễn ra rất nhanh chóng, giúp tiết kiệm thời gian đáng kể cho những chủ nhân bận rộn nhưng vẫn muốn thú cưng của mình luôn trong trạng thái chỉn chu nhất.', '2026-03-03 23:44:19', 0),
(22, 5, 'CAT_ALD_01', 'Mèo lông dài', 15000000, 51, 1, '1772610341_4ff85b74.jpg', 'mèo lông dài như Maine Coon hay mèo Ba Tư lại giống như những \"vị thần\" sang trọng bước ra từ thần thoại với bộ lông bồng bềnh, thướt tha. Lớp lông dài không chỉ tạo nên vẻ ngoài lộng lẫy, uy nghi mà còn mang lại cảm giác cực kỳ êm ái khi chạm vào. Những cái ôm dành cho một chú mèo lông dài thường ấm áp và \"đã\" hơn hẳn, giống như bạn đang vùi mình vào một chiếc gối ôm cao cấp vậy.', '2026-03-03 23:45:41', 0),
(23, 5, 'CAT_ALD_02', 'Mèo lông dài', 9000000, 18, 1, '1772610493_ce17984e.jpg', 'Vẻ đẹp kiêu sa này đi kèm với sự cầu kỳ trong khâu \"bảo dưỡng\". Để duy trì phong độ, những chú mèo này cần được chải chuốt hàng ngày để tránh tình trạng lông bết dính hoặc rụng đầy nhà. Đây không chỉ là việc vệ sinh, mà còn là khoảng thời gian gắn kết tình cảm đặc biệt giữa bạn và mèo, biến việc chăm sóc thành một trải nghiệm thư giãn và đầy tính kết nối.', '2026-03-03 23:48:13', 0),
(24, 1, 'TA_06', 'Thức Ăn Hạt Cho Mèo Trưởng Thành Nuôi Trong Nhà Royal Canin Indoor 27', 132000, 8, 1, '1776226280_712902e0.webp', 'Thức Ăn Cho Mèo Trưởng Thành Royal Canin Indoor 27 Thương hiệu: Royal Canin Phù hợp cho: Mèo...', '2026-04-15 11:11:20', 44);

-- --------------------------------------------------------

--
-- Table structure for table `thanh_toan`
--

CREATE TABLE `thanh_toan` (
  `id` int(11) NOT NULL,
  `id_don_hang` int(11) NOT NULL,
  `phuong_thuc` enum('TIEN_MAT','CHUYEN_KHOAN') NOT NULL DEFAULT 'TIEN_MAT',
  `so_tien` int(11) NOT NULL,
  `thoi_gian` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_don_sp` (`id_don_hang`,`id_san_pham`),
  ADD KEY `idx_ctdh_id_don_hang` (`id_don_hang`),
  ADD KEY `idx_ctdh_id_san_pham` (`id_san_pham`);

--
-- Indexes for table `chi_tiet_phieu_nhap`
--
ALTER TABLE `chi_tiet_phieu_nhap`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ctpn_phieu_nhap` (`phieu_nhap_id`),
  ADD KEY `fk_ctpn_san_pham` (`san_pham_id`);

--
-- Indexes for table `danh_muc`
--
ALTER TABLE `danh_muc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dat_dich_vu_spa`
--
ALTER TABLE `dat_dich_vu_spa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dich_vu`
--
ALTER TABLE `dich_vu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dich_vu_ho_boi`
--
ALTER TABLE `dich_vu_ho_boi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dich_vu_khachsan`
--
ALTER TABLE `dich_vu_khachsan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dich_vu_spa`
--
ALTER TABLE `dich_vu_spa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `don_hang`
--
ALTER TABLE `don_hang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nhan_vien` (`id_nhan_vien`),
  ADD KEY `idx_dh_ngay` (`ngay_tao`),
  ADD KEY `idx_dh_kh` (`id_khach_hang`),
  ADD KEY `idx_dh_tt` (`trang_thai`),
  ADD KEY `idx_dh_ship` (`trang_thai_giao_hang`);

--
-- Indexes for table `khach_hang`
--
ALTER TABLE `khach_hang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `so_dien_thoai` (`so_dien_thoai`);

--
-- Indexes for table `khach_hang_than_thiet`
--
ALTER TABLE `khach_hang_than_thiet`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_khach_hang_than_thiet` (`khach_hang_id`);

--
-- Indexes for table `lich_hen`
--
ALTER TABLE `lich_hen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_khach_hang` (`id_khach_hang`),
  ADD KEY `id_dich_vu` (`id_dich_vu`),
  ADD KEY `id_nhan_vien` (`id_nhan_vien`);

--
-- Indexes for table `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ten_dang_nhap` (`ten_dang_nhap`);

--
-- Indexes for table `nha_cung_cap`
--
ALTER TABLE `nha_cung_cap`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phieu_nhap`
--
ALTER TABLE `phieu_nhap`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma_phieu` (`ma_phieu`),
  ADD KEY `fk_phieu_nhap_nha_cung_cap` (`nha_cung_cap_id`);

--
-- Indexes for table `san_pham`
--
ALTER TABLE `san_pham`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma_sku` (`ma_sku`),
  ADD KEY `idx_sp_id_danh_muc` (`id_danh_muc`);

--
-- Indexes for table `thanh_toan`
--
ALTER TABLE `thanh_toan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_don_hang` (`id_don_hang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `chi_tiet_phieu_nhap`
--
ALTER TABLE `chi_tiet_phieu_nhap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `danh_muc`
--
ALTER TABLE `danh_muc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `dat_dich_vu_spa`
--
ALTER TABLE `dat_dich_vu_spa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dich_vu`
--
ALTER TABLE `dich_vu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dich_vu_ho_boi`
--
ALTER TABLE `dich_vu_ho_boi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `dich_vu_khachsan`
--
ALTER TABLE `dich_vu_khachsan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `dich_vu_spa`
--
ALTER TABLE `dich_vu_spa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `don_hang`
--
ALTER TABLE `don_hang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `khach_hang`
--
ALTER TABLE `khach_hang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `khach_hang_than_thiet`
--
ALTER TABLE `khach_hang_than_thiet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lich_hen`
--
ALTER TABLE `lich_hen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `nha_cung_cap`
--
ALTER TABLE `nha_cung_cap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `phieu_nhap`
--
ALTER TABLE `phieu_nhap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `san_pham`
--
ALTER TABLE `san_pham`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `thanh_toan`
--
ALTER TABLE `thanh_toan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  ADD CONSTRAINT `chi_tiet_don_hang_ibfk_1` FOREIGN KEY (`id_don_hang`) REFERENCES `don_hang` (`id`),
  ADD CONSTRAINT `chi_tiet_don_hang_ibfk_2` FOREIGN KEY (`id_san_pham`) REFERENCES `san_pham` (`id`),
  ADD CONSTRAINT `fk_ctdh__don_hang__id_don_hang` FOREIGN KEY (`id_don_hang`) REFERENCES `don_hang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ctdh__san_pham__id_san_pham` FOREIGN KEY (`id_san_pham`) REFERENCES `san_pham` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ctdh_dh` FOREIGN KEY (`id_don_hang`) REFERENCES `don_hang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ctdh_sp` FOREIGN KEY (`id_san_pham`) REFERENCES `san_pham` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `chi_tiet_phieu_nhap`
--
ALTER TABLE `chi_tiet_phieu_nhap`
  ADD CONSTRAINT `fk_ctpn_phieu_nhap` FOREIGN KEY (`phieu_nhap_id`) REFERENCES `phieu_nhap` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ctpn_san_pham` FOREIGN KEY (`san_pham_id`) REFERENCES `san_pham` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `don_hang`
--
ALTER TABLE `don_hang`
  ADD CONSTRAINT `don_hang_ibfk_1` FOREIGN KEY (`id_khach_hang`) REFERENCES `khach_hang` (`id`),
  ADD CONSTRAINT `don_hang_ibfk_2` FOREIGN KEY (`id_nhan_vien`) REFERENCES `nguoi_dung` (`id`);

--
-- Constraints for table `khach_hang_than_thiet`
--
ALTER TABLE `khach_hang_than_thiet`
  ADD CONSTRAINT `khach_hang_than_thiet_ibfk_1` FOREIGN KEY (`khach_hang_id`) REFERENCES `khach_hang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lich_hen`
--
ALTER TABLE `lich_hen`
  ADD CONSTRAINT `lich_hen_ibfk_1` FOREIGN KEY (`id_khach_hang`) REFERENCES `khach_hang` (`id`),
  ADD CONSTRAINT `lich_hen_ibfk_2` FOREIGN KEY (`id_dich_vu`) REFERENCES `dich_vu` (`id`),
  ADD CONSTRAINT `lich_hen_ibfk_3` FOREIGN KEY (`id_nhan_vien`) REFERENCES `nguoi_dung` (`id`);

--
-- Constraints for table `phieu_nhap`
--
ALTER TABLE `phieu_nhap`
  ADD CONSTRAINT `fk_phieu_nhap_nha_cung_cap` FOREIGN KEY (`nha_cung_cap_id`) REFERENCES `nha_cung_cap` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `san_pham`
--
ALTER TABLE `san_pham`
  ADD CONSTRAINT `fk_san_pham__danh_muc__id_danh_muc` FOREIGN KEY (`id_danh_muc`) REFERENCES `danh_muc` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sp_dm` FOREIGN KEY (`id_danh_muc`) REFERENCES `danh_muc` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `san_pham_ibfk_1` FOREIGN KEY (`id_danh_muc`) REFERENCES `danh_muc` (`id`);

--
-- Constraints for table `thanh_toan`
--
ALTER TABLE `thanh_toan`
  ADD CONSTRAINT `thanh_toan_ibfk_1` FOREIGN KEY (`id_don_hang`) REFERENCES `don_hang` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
