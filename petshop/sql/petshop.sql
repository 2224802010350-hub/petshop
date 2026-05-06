-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 06, 2026 lúc 08:33 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `petshop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_don_hang`
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
-- Đang đổ dữ liệu cho bảng `chi_tiet_don_hang`
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
(14, 7, 23, 1, 9000000, 0),
(15, 8, 20, 1, 15000000, 0),
(16, 8, 9, 1, 15000000, 0),
(17, 9, 42, 1, 8000000, 8000000),
(18, 9, 72, 1, 44000, 44000),
(19, 10, 71, 1, 15000, 0),
(20, 10, 54, 1, 15000000, 0),
(21, 11, 41, 1, 6000000, 0),
(22, 11, 25, 1, 15000, 0),
(23, 12, 86, 1, 13200, 0),
(24, 12, 95, 1, 50000, 0),
(25, 13, 9, 1, 15000000, 0),
(26, 14, 85, 1, 32000, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_phieu_nhap`
--

CREATE TABLE `chi_tiet_phieu_nhap` (
  `id` int(11) NOT NULL,
  `phieu_nhap_id` int(11) NOT NULL,
  `san_pham_id` int(11) NOT NULL,
  `so_luong` int(11) NOT NULL DEFAULT 1,
  `gia_nhap` decimal(12,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chi_tiet_phieu_nhap`
--

INSERT INTO `chi_tiet_phieu_nhap` (`id`, `phieu_nhap_id`, `san_pham_id`, `so_luong`, `gia_nhap`) VALUES
(1, 1, 24, 20, 0.00),
(2, 2, 24, 35, 55000.00),
(3, 3, 24, 9, 132000.00),
(4, 4, 10, 3, 16000000.00),
(5, 5, 11, 99, 17000000.00),
(6, 6, 83, 6, 132000.00),
(7, 6, 66, 9, 132000.00),
(8, 7, 93, 2, 9000000.00),
(9, 8, 94, 5, 450000.00),
(10, 9, 95, 5, 50000.00),
(11, 10, 91, 1, 60000.00),
(12, 11, 95, 5, 50000.00),
(13, 12, 55, 3, 6000000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danh_muc`
--

CREATE TABLE `danh_muc` (
  `id` int(11) NOT NULL,
  `id_cha` int(11) DEFAULT NULL,
  `ten_danh_muc` varchar(120) NOT NULL,
  `loai` varchar(50) DEFAULT NULL,
  `trang_thai` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danh_muc`
--

INSERT INTO `danh_muc` (`id`, `id_cha`, `ten_danh_muc`, `loai`, `trang_thai`) VALUES
(1, NULL, 'Shop chó', '', 1),
(4, NULL, 'Chó cảnh', NULL, 0),
(5, NULL, 'Mèo cảnh', NULL, 0),
(8, NULL, 'Shop mèo', '', 1),
(9, 1, 'Thức ăn cho chó', '', 1),
(10, 1, 'Phụ kiện cho chó', '', 1),
(11, 1, 'Đồ chơi cho chó', '', 1),
(12, 8, 'Thức ăn cho mèo', '', 1),
(13, 8, 'Đồ chơi cho mèo', '', 1),
(14, 8, 'Phụ kiện cho mèo', '', 1),
(15, 23, 'Chó corgi mông to', '', 1),
(16, 23, 'Chó Bichon cục bông đáng yêu', '', 1),
(17, 23, 'Chó Shiba Inu', '', 1),
(18, 23, 'Chó Phốc Sóc', '', 1),
(19, 24, 'Mèo Maine Coon', '', 1),
(20, 24, 'Mèo Anh lông ngắn', '', 1),
(21, 24, 'Mèo Anh lông dài', '', 1),
(22, 24, 'Mèo xiêm', '', 1),
(23, NULL, 'Chó Cảnh Bán', '', 1),
(24, NULL, 'Mèo cảnh bán', '', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dat_dich_vu_spa`
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
-- Đang đổ dữ liệu cho bảng `dat_dich_vu_spa`
--

INSERT INTO `dat_dich_vu_spa` (`id`, `ma_tra_cuu`, `ho_ten`, `so_dien_thoai`, `ten_thu_cung`, `can_nang`, `dich_vu_chinh`, `dich_vu_them`, `ngay_dat`, `gio_dat`, `ghi_chu`, `trang_thai`, `ngay_tao`) VALUES
(2, 'SPA1777719405', 'Thuong', '0987654321', 'Miu', '3 - 5kg', 'Vệ sinh', 'Spa 9 bước thơm tho', '2026-05-07', '22:57:00', 'ko', 'Đã xác nhận', '2026-05-02 10:56:45'),
(3, 'DV1777741008', 'thanh', '0909090909', 'bông', '5 - 10kg', 'Spa Full', 'Spa 9 bước thơm tho', '2026-05-08', '20:28:00', '[Loại dịch vụ: Spa thú cưng] ko', 'Đã xác nhận', '2026-05-02 16:56:48'),
(4, 'DV1777741547', 'Thuong', '0987654321', 'lu', '< 5kg', 'Hồ bơi thú cưng - Gói 5 lần', 'Spa Full', '2026-05-05', '00:08:00', '[Loại dịch vụ: Hồ bơi - Sân chơi] ko', 'Đã hoàn thành', '2026-05-02 17:05:47'),
(5, 'DV1777743587', 'cong', '1212121212', 'piu', '7 - 12kg', 'Khách sạn thú cưng - Qua đêm', 'Spa Full', '2026-05-14', '00:41:00', '[Loại dịch vụ: Khách sạn thú cưng] ko', 'Đã hoàn thành', '2026-05-02 17:39:47'),
(6, 'DV1777969618', 'Nguyen Thi Thanh', '1234567890', 'chó', '< 3kg', 'Spa Full', 'Grooming tạo kiểu, Trông giữ trong ngày (Daycare)', '2026-05-06', '03:25:00', '[Loại dịch vụ: Spa thú cưng]', 'Đã xác nhận', '2026-05-05 08:26:58');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dich_vu`
--

CREATE TABLE `dich_vu` (
  `id` int(11) NOT NULL,
  `ten_dich_vu` varchar(200) NOT NULL,
  `gia` int(11) NOT NULL DEFAULT 0,
  `thoi_luong_phut` int(11) NOT NULL DEFAULT 30,
  `trang_thai` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dich_vu`
--

INSERT INTO `dich_vu` (`id`, `ten_dich_vu`, `gia`, `thoi_luong_phut`, `trang_thai`) VALUES
(1, 'Tắm thú cưng', 120000, 45, 1),
(2, 'Cắt tỉa lông', 150000, 60, 1),
(3, 'Spa cơ bản', 200000, 60, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dich_vu_ho_boi`
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
-- Đang đổ dữ liệu cho bảng `dich_vu_ho_boi`
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
-- Cấu trúc bảng cho bảng `dich_vu_khachsan`
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
-- Đang đổ dữ liệu cho bảng `dich_vu_khachsan`
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
-- Cấu trúc bảng cho bảng `dich_vu_spa`
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
-- Đang đổ dữ liệu cho bảng `dich_vu_spa`
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
-- Cấu trúc bảng cho bảng `don_hang`
--

CREATE TABLE `don_hang` (
  `id` int(11) NOT NULL,
  `ma_don` varchar(20) DEFAULT NULL,
  `id_khach_hang` int(11) DEFAULT NULL,
  `id_nhan_vien` int(11) DEFAULT NULL,
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
-- Đang đổ dữ liệu cho bảng `don_hang`
--

INSERT INTO `don_hang` (`id`, `ma_don`, `id_khach_hang`, `id_nhan_vien`, `ngay_tao`, `ngay_cap_nhat`, `trang_thai_giao_hang`, `phuong_thuc_tt`, `trang_thai`, `thoi_diem_thanh_toan`, `tam_tinh`, `giam_gia`, `tong_tien`, `ghi_chu`, `ten_nhan`, `sdt_nhan`, `email_nhan`, `dia_chi_nhan`, `da_cong_diem_than_thiet`, `email_khach`) VALUES
(1, 'DH999999', NULL, 1, '2026-03-02 00:05:27', '2026-03-02 00:05:27', 'DA_XAC_NHAN', 'COD', 'DA_THANH_TOAN', '2026-04-30 16:33:43', 18000000, 0, 18000000, 'Test đơn', 'Test', '0900000000', 'test@gmail.com', 'Bình Dương', 0, NULL),
(2, 'DH2026043011231713', 4, 1, '2026-04-30 16:23:17', NULL, 'DA_XAC_NHAN', 'COD', 'DA_THANH_TOAN', '2026-04-30 16:33:33', 60000000, 0, 60000000, NULL, NULL, NULL, NULL, NULL, 0, ''),
(3, 'DH2026043018583839', 4, 1, '2026-04-30 23:58:38', NULL, 'DA_XAC_NHAN', 'ONLINE', 'DA_THANH_TOAN', '2026-04-30 23:58:47', 9132000, 0, 9132000, NULL, NULL, NULL, NULL, NULL, 1, ''),
(4, 'DH2026043019054165', 1, 1, '2026-05-01 00:05:41', NULL, 'DA_XAC_NHAN', 'COD', 'DA_THANH_TOAN', '2026-05-01 00:05:47', 39000000, 0, 39000000, NULL, NULL, NULL, NULL, NULL, 1, ''),
(5, 'DH2026043019102058', 4, 1, '2026-05-01 00:10:20', NULL, 'DA_XAC_NHAN', 'COD', 'DA_THANH_TOAN', '2026-05-01 00:11:20', 35000000, 0, 35000000, NULL, NULL, NULL, NULL, NULL, 1, ''),
(6, 'DH2026043019114616', 1, 1, '2026-05-01 00:11:46', NULL, 'DA_XAC_NHAN', 'COD', 'DA_THANH_TOAN', '2026-05-01 00:11:49', 15000000, 0, 15000000, NULL, NULL, NULL, NULL, NULL, 1, ''),
(7, 'DH2026043019365152', 3, 1, '2026-05-01 00:36:51', NULL, 'DA_XAC_NHAN', 'COD', 'DA_THANH_TOAN', '2026-05-01 00:37:13', 9132000, 0, 9132000, NULL, NULL, NULL, NULL, NULL, 1, ''),
(8, 'DH2026050403310791', 1, 1, '2026-05-04 08:31:07', NULL, 'DA_XAC_NHAN', 'ONLINE', 'DA_THANH_TOAN', '2026-05-04 08:31:18', 30000000, 0, 30000000, NULL, NULL, NULL, NULL, NULL, 1, ''),
(9, NULL, 6, 1, '2026-05-06 00:58:46', NULL, 'DA_XAC_NHAN', 'COD', 'DA_THANH_TOAN', NULL, 8044000, 0, 8044000, NULL, NULL, NULL, NULL, NULL, 0, '2224802010350@student.tdmu.edu.vn'),
(10, NULL, NULL, NULL, '2026-05-06 08:09:21', NULL, 'DA_XAC_NHAN', 'COD', 'DA_THANH_TOAN', NULL, 15015000, 0, 15015000, NULL, NULL, NULL, NULL, NULL, 0, '2224802010350@student.tdmu.edu.vn'),
(11, NULL, NULL, NULL, '2026-05-06 08:10:22', NULL, 'DA_XAC_NHAN', 'COD', 'DA_THANH_TOAN', NULL, 6015000, 0, 6015000, NULL, NULL, NULL, NULL, NULL, 0, '2224802010350@student.tdmu.edu.vn'),
(12, NULL, NULL, NULL, '2026-05-06 08:28:25', NULL, 'DA_XAC_NHAN', 'COD', 'DA_THANH_TOAN', NULL, 63200, 0, 63200, NULL, NULL, NULL, NULL, NULL, 0, '2224802010350@student.tdmu.edu.vn'),
(13, NULL, 6, 1, '2026-05-06 09:07:43', NULL, 'DA_XAC_NHAN', 'COD', 'DA_THANH_TOAN', NULL, 15000000, 0, 15000000, NULL, NULL, NULL, NULL, NULL, 0, '2224802010350@student.tdmu.edu.vn'),
(14, NULL, 6, 1, '2026-05-06 10:24:18', NULL, 'DA_XAC_NHAN', 'COD', 'DA_THANH_TOAN', NULL, 32000, 0, 32000, NULL, NULL, NULL, NULL, NULL, 0, '2224802010350@student.tdmu.edu.vn');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khach_hang`
--

CREATE TABLE `khach_hang` (
  `id` int(11) NOT NULL,
  `id_nguoi_dung` int(11) DEFAULT NULL,
  `ho_ten` varchar(120) NOT NULL,
  `so_dien_thoai` varchar(20) NOT NULL,
  `email` varchar(120) DEFAULT NULL,
  `dia_chi` varchar(255) DEFAULT NULL,
  `hang_khach` enum('thuong','vip') NOT NULL DEFAULT 'thuong',
  `diem` int(11) NOT NULL DEFAULT 0,
  `ngay_tao` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `khach_hang`
--

INSERT INTO `khach_hang` (`id`, `id_nguoi_dung`, `ho_ten`, `so_dien_thoai`, `email`, `dia_chi`, `hang_khach`, `diem`, `ngay_tao`) VALUES
(1, NULL, 'Nguyễn Văn A', '0900000001', 'a@gmail.com', 'Hà Nội', 'thuong', 0, '2026-01-29 15:51:39'),
(2, NULL, 'Trần Thị B', '0900000002', 'b@gmail.com', 'TP.HCM', 'vip', 10, '2026-01-29 15:51:39'),
(3, NULL, 'Lê Văn C', '0900000003', NULL, 'Đà Nẵng', 'thuong', 0, '2026-01-29 15:51:39'),
(4, NULL, 'Thanh', '1234567890', '2224802010350@student.tdmu.edu.vn', 'Phường Phú Lợi', 'vip', 107, '2026-04-30 13:48:14'),
(5, NULL, 'Thương', '1234567899', 'thuong@gmail.com', 'VN', 'thuong', 0, '2026-05-01 00:51:23'),
(6, NULL, 'Nguyen Thi Thanh', '0987654321', '2224802010350@student.tdmu.edu.vn', 'Phường Phú Lợi', 'thuong', 0, '2026-05-06 00:12:31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khach_hang_than_thiet`
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
-- Đang đổ dữ liệu cho bảng `khach_hang_than_thiet`
--

INSERT INTO `khach_hang_than_thiet` (`id`, `khach_hang_id`, `diem`, `hang_thanh_vien`, `ghi_chu`, `ngay_tao`, `ngay_cap_nhat`) VALUES
(1, 4, 5015, 'Bạc', '', '2026-04-30 07:01:22', '2026-05-06 01:10:22'),
(2, 1, 8400, 'Bạc', 'Tự động cộng điểm từ đơn hàng', '2026-04-30 17:05:47', '2026-05-04 01:31:18'),
(5, 3, 913, 'Đồng', '', '2026-04-30 17:23:44', '2026-04-30 17:37:13'),
(6, 6, 3814, 'Bạc', NULL, '2026-05-05 17:58:46', '2026-05-06 03:24:18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lich_hen`
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
-- Cấu trúc bảng cho bảng `nguoi_dung`
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
-- Đang đổ dữ liệu cho bảng `nguoi_dung`
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
(9, 'Thương', 'Thuong', '$2y$10$/mL6FvmSaUQc.LjOHoj6teBJd3rm1tm1SUcMVpyBNHdb4RKNgNyDG', 'khach', 1, '2026-05-01 01:49:49'),
(10, 'Nguyen Thi Thanh', 'T1', '$2y$10$ZAfIAW69CSbE/yLNZ9l/UOxS52TGTBG/eWF.gkrkEdMRsodhRPI9K', 'khach', 1, '2026-05-04 08:18:08'),
(11, 'Nguyễn Minh Công', 'MinhCong', '$2y$10$Xrse48XkUSWPgSAnAr7IjuNvFPzhHkdw0u22HIRtpiF7w9K.Ny21K', 'khach', 1, '2026-05-06 00:12:31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nha_cung_cap`
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
-- Đang đổ dữ liệu cho bảng `nha_cung_cap`
--

INSERT INTO `nha_cung_cap` (`id`, `ten_nha_cung_cap`, `nguoi_lien_he`, `so_dien_thoai`, `email`, `dia_chi`, `ghi_chu`, `trang_thai`, `ngay_tao`) VALUES
(1, 'Royal Canin', 'Thanh', '0987654321', '2224802010350@student.tdmu.edu.vn', 'Phường Phú Lợi', 'Giao hàng hỏa tốc, freeship cho thành viên', 1, '2026-04-15 03:18:44'),
(2, 'Pet Things®', 'Nguyễn Minh Quân', '0906 989 777', '2224802010350@student.tdmu.edu.vn', '381 Ngô Gia Tự, P.2, Q.10, TP. HCM', 'Thức ăn hạt (Taste of the Wild, Nutrience), pate, cát vệ sinh, đồ chơi	Hoạt động từ 2013, nhiều thương hiệu nhập khẩu, giao hàng tận nơi', 1, '2026-04-15 03:28:54'),
(3, 'Paddy Pet Shop', 'Trần Thảo My', '1234567890', 'support@paddypetshop.vn', '25 Nguyễn Thị Minh Khai, Q.1, TP. HCM', 'Giao hàng hỏa tốc, freeship cho thành viên	Royal Canin, Kit Cat, Whiskas, LaPaw, Nutrience, phụ kiện	Nhiều khuyến mãi, đa dạng thương hiệu, có cả đồ chơi và phụ kiện', 1, '2026-05-05 13:22:34'),
(4, 'VC Pet Shop', 'Võ Chí Công', '0922 89 89 39', 'contact@vcpetshop.vn', '102 Lê Văn Sỹ, P.14, Q.3, TP. HCM', 'Chuyên thức ăn cao cấp nhập khẩu (Dog Smile, Define, Lapaw, Wanpy), nhiều phụ kiện huấn luyện chó.', 1, '2026-05-05 13:24:35');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieu_nhap`
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
-- Đang đổ dữ liệu cho bảng `phieu_nhap`
--

INSERT INTO `phieu_nhap` (`id`, `ma_phieu`, `nha_cung_cap_id`, `ngay_nhap`, `tong_tien`, `ghi_chu`, `trang_thai`, `admin_id`, `ngay_tao`) VALUES
(1, 'PN20260415001', 1, '2026-04-15 11:28:15', 0.00, '', 'cancelled', 1, '2026-04-15 04:28:15'),
(2, 'PN20260415002', 1, '2026-04-15 11:28:51', 1925000.00, '', 'confirmed', 1, '2026-04-15 04:28:51'),
(3, 'PN20260422001', 1, '2026-04-22 10:32:18', 1188000.00, '', 'confirmed', 1, '2026-04-22 03:32:18'),
(4, 'PN20260422002', 2, '2026-04-22 10:36:00', 48000000.00, '', 'confirmed', 1, '2026-04-22 03:36:00'),
(5, 'PN20260422003', 1, '2026-04-22 10:40:09', 1683000000.00, '', 'confirmed', 1, '2026-04-22 03:40:09'),
(6, 'PN20260505001', 3, '2026-05-05 20:25:30', 1980000.00, '', 'confirmed', 1, '2026-05-05 13:25:30'),
(7, 'PN20260505002', 2, '2026-05-05 20:51:01', 18000000.00, '', 'confirmed', 1, '2026-05-05 13:51:01'),
(8, 'PN20260505003', 3, '2026-05-05 22:16:06', 2250000.00, '', 'confirmed', 1, '2026-05-05 15:16:06'),
(9, 'PN20260505004', 3, '2026-05-05 22:22:49', 250000.00, '', 'confirmed', 1, '2026-05-05 15:22:49'),
(10, 'PN20260505005', 3, '2026-05-05 22:39:50', 60000.00, '', 'confirmed', 1, '2026-05-05 15:39:50'),
(11, 'PN20260505006', 3, '2026-05-05 23:19:20', 250000.00, '', 'confirmed', 1, '2026-05-05 16:19:20'),
(12, 'PN20260506001', 2, '2026-05-06 08:22:29', 18000000.00, '', 'confirmed', 1, '2026-05-06 01:22:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `san_pham`
--

CREATE TABLE `san_pham` (
  `id` int(11) NOT NULL,
  `id_danh_muc` int(11) NOT NULL,
  `id_nha_cung_cap` int(11) DEFAULT NULL,
  `ma_sku` varchar(50) NOT NULL,
  `ten_san_pham` varchar(200) NOT NULL,
  `gia_ban` int(11) NOT NULL DEFAULT 0,
  `gia_nhap` int(11) NOT NULL DEFAULT 0,
  `ton_kho` int(11) NOT NULL DEFAULT 0,
  `trang_thai` tinyint(4) NOT NULL DEFAULT 1,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `mo_ta` text DEFAULT NULL,
  `ngay_tao` datetime NOT NULL DEFAULT current_timestamp(),
  `so_luong_ton` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `san_pham`
--

INSERT INTO `san_pham` (`id`, `id_danh_muc`, `id_nha_cung_cap`, `ma_sku`, `ten_san_pham`, `gia_ban`, `gia_nhap`, `ton_kho`, `trang_thai`, `hinh_anh`, `mo_ta`, `ngay_tao`, `so_luong_ton`) VALUES
(8, 17, NULL, 'DOG_SHIBA_01', 'Bé Rin – Shiba Inu', 9000000, 0, 10, 1, '1772390668_6faf3c32.jpg', 'Bé Rin – Shiba Inu thường được nhắc đến là hình ảnh đại diện cho giống chó Shiba nổi tiếng từ Nhật Bản, nổi bật với vẻ ngoài giống cáo, đôi tai tam giác dựng đứng, đuôi xoăn và \"nụ cười\" thân thiện. Shiba là giống chó nhỏ gọn, thông minh, độc lập và trung thành, rất được yêu thích nhờ tính sạch sẽ và vóc dáng gọn gàng.', '2026-02-24 15:10:38', 0),
(9, 22, NULL, 'CAT_XIEM_01', 'Mèo Xiêm', 15000000, 0, 18, 1, '1772386775_4070b1b8.jpg', 'Mèo Xiêm là biểu tượng của vẻ đẹp quý tộc với thân hình mảnh mai, săn chắc và đôi mắt màu xanh dương thẳm đầy mê hoặc. Điểm nhận diện đặc trưng nhất của chúng chính là bộ lông ngắn mượt mà với các vùng màu đậm (points) nhấn nhá ở khuôn mặt, tai, bốn chân và đuôi trên nền lông sáng màu. Không chỉ sở hữu ngoại hình sang trọng, mèo Xiêm còn nổi tiếng bởi tính cách thông minh, tình cảm và cực kỳ \"lắm lời\". Chúng thích quấn quýt bên chủ nhân, luôn sẵn sàng \"trò chuyện\" bằng tiếng kêu vang và rất thích tham gia vào các hoạt động gia đình. Đây là người bạn đồng hành lý tưởng cho những ai tìm kiếm một thú cưng năng động, trung thành và có cá tính riêng biệt.', '2026-03-01 09:39:35', 0),
(10, 22, NULL, 'CAT_XIEM_02', 'Mèo Xiêm', 16000000, 0, 12, 1, '1772388999_72c796d5.jpg', 'Mèo Xiêm: \"Bản giao hưởng\" của vẻ đẹp và sự thông minh\r\nNếu bạn đang tìm kiếm một người bạn bốn chân không chỉ đẹp mà còn có \"tâm hồn\" sâu sắc, mèo Xiêm chính là câu trả lời hoàn hảo. Được mệnh danh là \"vị thần may mắn\" từ vùng đất Thái Lan cổ xưa, mèo Xiêm gây ấn tượng mạnh ngay từ cái nhìn đầu tiên với đôi mắt xanh thẳm như ngọc bích và bộ lông mang hiệu ứng \"nhiệt độ\" độc đáo — nơi các điểm cực như tai, mặt và chân khoác lên mình những mảng màu sẫm quý phái.\r\n\r\nTrái ngược với vẻ ngoài có phần \"sang chảnh\" và lạnh lùng, mèo Xiêm thực chất là những \"đứa trẻ\" giàu tình cảm. Chúng không chỉ đơn thuần là thú cưng mà còn là một người bạn tâm giao đích thực, luôn bám đuôi và sẵn sàng \"thảo luận\" với bạn về mọi thứ trên đời bằng tông giọng đặc trưng không lẫn vào đâu được. Sự thông minh vượt trội cho phép chúng thấu hiểu cảm xúc của chủ nhân và học hỏi các trò chơi vô cùng nhanh nhạy. Sở hữu một chú mèo Xiêm trong nhà, bạn sẽ không bao giờ cảm thấy cô đơn, bởi mỗi ngày đều sẽ tràn ngập những khoảnh khắc tương tác đầy thú vị và ấm áp.', '2026-03-01 10:16:39', 3),
(11, 18, NULL, 'DOG_POM_01', 'Chó Phốc Sóc', 17000000, 0, 19, 1, '1772390249_5eccf364.jpg', 'Chó Phốc Sóc (Pomeranian) tựa như những \"viên kẹo bông\" di động, luôn mang đến niềm vui và sự ấm áp cho mọi không gian mà chúng xuất hiện. Với thân hình nhỏ nhắn ẩn sau lớp lông kép dày mượt, xù bông rực rỡ, mỗi bước đi của chúng đều toát lên vẻ lanh lợi và kiêu kỳ. Đôi mắt đen láy như hai hạt nhãn cùng chiếc mõm nhỏ xinh luôn tạo nên biểu cảm tươi tắn, hớn hở như đang mỉm cười với chủ nhân. Không chỉ sở hữu ngoại hình \"vạn người mê\", Phốc Sóc còn là người bạn cực kỳ tình cảm, thích được cưng nựng và luôn biết cách làm nũng để trở thành tâm điểm của sự chú ý. Có một chú Phốc Sóc bên cạnh, cuộc sống của bạn sẽ luôn tràn ngập tiếng cười và những cái vẫy đuôi đầy hạnh phúc.', '2026-03-01 10:37:29', 99),
(18, 19, NULL, 'CAT_MAINE_01', 'Mèo maine coon', 15000000, 0, 20, 1, '1772525863_5b178752.jpg', 'Maine Coon sở hữu một ngoại hình ấn tượng với kích thước vượt trội, được mệnh danh là một trong những giống mèo nhà lớn nhất thế giới. Điểm thu hút nhất chính là bộ lông dày, dài và không thấm nước, giúp chúng thích nghi hoàn hảo với khí hậu lạnh giá. Đặc biệt, đôi tai lớn với chùm lông nhọn ở đỉnh (kiểu tai mèo rừng) cùng chiếc đuôi dài, xòe rộng như đuôi sóc tạo nên một vẻ đẹp vừa hoang dã, vừa oai vệ như những vị chúa tể nhỏ trong căn nhà.', '2026-03-03 00:17:43', 0),
(19, 19, NULL, 'CAT_MAINE_02', 'Mèo maine coon', 9000000, 0, 29, 1, '1772525900_976367da.jpg', 'Trái ngược hoàn toàn với vẻ ngoài có phần \"hầm hố\", Maine Coon lại nổi tiếng bởi tính cách cực kỳ hiền lành và điềm tĩnh. Chúng thường được gọi là \"chó trong thân xác mèo\" vì sự trung thành, thích đi theo chủ nhân và thậm chí là có khả năng học các trò chơi như nhặt bóng. Không giống như nhiều giống mèo khác thường tỏ ra xa cách, Maine Coon rất tình cảm, thích được giao tiếp bằng những tiếng kêu \"gur-gur\" đặc trưng và đặc biệt là chúng khá yêu thích nước – một nét tính cách rất thú vị và khác biệt.', '2026-03-03 00:18:20', 0),
(20, 20, NULL, 'CAT_ALN_01', 'Mèo lông ngắn', 15000000, 0, 20, 1, '1772610213_ef477ad1.jpg', 'Mèo lông ngắn, tiêu biểu như giống mèo Anh lông ngắn (British Shorthair) hay mèo Ta, sở hữu vẻ ngoài gọn gàng với lớp lông dày, mượt và ôm sát cơ thể. Chính đặc điểm này giúp làm tôn lên những đường nét săn chắc và sự linh hoạt trong từng bước đi của chúng. Về mặt thẩm mỹ, chúng mang lại cảm giác hiện đại, sạch sẽ và cực kỳ \"vừa mắt\" với những ai yêu thích sự tối giản.', '2026-03-03 23:43:33', 0),
(21, 20, NULL, 'CAT_ALN_02', 'Mèo lông ngắn', 15000000, 0, 43, 1, '1772610259_795c5e78.jpg', 'Điểm cộng lớn nhất của hội lông ngắn chính là sự tiện lợi trong việc chăm sóc. Bạn sẽ không phải đối mặt với nỗi lo lông bị rối bù hay vón cục sau một ngày chúng mải mê chạy nhảy. Việc chải chuốt diễn ra rất nhanh chóng, giúp tiết kiệm thời gian đáng kể cho những chủ nhân bận rộn nhưng vẫn muốn thú cưng của mình luôn trong trạng thái chỉn chu nhất.', '2026-03-03 23:44:19', 0),
(22, 21, NULL, 'CAT_ALD_01', 'Mèo lông dài', 15000000, 0, 51, 1, '1772610341_4ff85b74.jpg', 'mèo lông dài như Maine Coon hay mèo Ba Tư lại giống như những \"vị thần\" sang trọng bước ra từ thần thoại với bộ lông bồng bềnh, thướt tha. Lớp lông dài không chỉ tạo nên vẻ ngoài lộng lẫy, uy nghi mà còn mang lại cảm giác cực kỳ êm ái khi chạm vào. Những cái ôm dành cho một chú mèo lông dài thường ấm áp và \"đã\" hơn hẳn, giống như bạn đang vùi mình vào một chiếc gối ôm cao cấp vậy.', '2026-03-03 23:45:41', 0),
(23, 21, NULL, 'CAT_ALD_02', 'Mèo lông dài', 9000000, 0, 18, 1, '1772610493_ce17984e.jpg', 'Vẻ đẹp kiêu sa này đi kèm với sự cầu kỳ trong khâu \"bảo dưỡng\". Để duy trì phong độ, những chú mèo này cần được chải chuốt hàng ngày để tránh tình trạng lông bết dính hoặc rụng đầy nhà. Đây không chỉ là việc vệ sinh, mà còn là khoảng thời gian gắn kết tình cảm đặc biệt giữa bạn và mèo, biến việc chăm sóc thành một trải nghiệm thư giãn và đầy tính kết nối.', '2026-03-03 23:48:13', 0),
(24, 12, NULL, 'TA_06', 'Thức Ăn Hạt Cho Mèo Trưởng Thành Nuôi Trong Nhà Royal Canin Indoor 27', 132000, 0, 8, 1, '1777985799_2395038e.jpg', 'Thức Ăn Cho Mèo Trưởng Thành Royal Canin Indoor 27 Thương hiệu: Royal Canin Phù hợp cho: Mèo...', '2026-04-15 11:11:20', 44),
(25, 13, NULL, 'DA_01', 'cần câu mè0', 15000, 0, 29, 1, '1777867778_33762085.jpg', 'Cần câu mèo (lông vũ, dây ruy băng)', '2026-05-04 11:09:38', 0),
(27, 18, NULL, 'DOG_POM_02', 'Chó Phốc sóc mini màu party', 9000000, 0, 2, 1, '1777977305_8d779924.jpg', 'Tháng tuổi: 2 tháng	Bố: Bò\r\nGiới tính: Đực	Mẹ: Silent\r\nMàu: Party	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng	Đặc điểm: Nhỏ gọn', '2026-05-05 17:35:05', 0),
(28, 18, NULL, 'DOG_POM_03', 'Chó Phốc sóc mini màu vàng cam', 6000000, 0, 1, 1, '1777977764_2f7e4910.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Lele\r\nGiới tính: Đực	Mẹ: Mun\r\nMàu: Vàng cam	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Nhỏ gọn', '2026-05-05 17:42:44', 0),
(29, 18, NULL, 'DOG_POM_04', 'Chó Phốc sóc mini màu trắng', 11000000, 0, 1, 1, '1777977848_79fbdb24.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Bắp\r\nGiới tính: Cái	Mẹ: Sâu\r\nMàu: Trắng	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng	Đặc điểm: Nhỏ gọn', '2026-05-05 17:44:08', 0),
(30, 18, NULL, 'DOG_POM_05', 'Chó Pomeranian vip màu vàng mini', 8000000, 0, 3, 1, '1777977921_d817a4e5.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Mi\r\nGiới tính: Đực	Mẹ: Cun\r\nMàu: Vàng	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng	Đặc điểm: Nhỏ gọn', '2026-05-05 17:45:21', 0),
(31, 18, NULL, 'DOG_POM_06', 'Chó Phốc sóc mini màu kem', 12000000, 0, 1, 1, '1777978636_6d2cf5b2.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Kem\r\nGiới tính: Đực	Mẹ: Milk\r\nMàu: Kem	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng', '2026-05-05 17:57:16', 0),
(32, 18, NULL, 'DOG_POM_07', 'Chó Phốc Sóc Vip mini mặt gấu màu trắng', 9000000, 0, 4, 1, '1777978716_679dda7a.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Cò\r\nGiới tính: Đực	Mẹ: Sun\r\nMàu: Trắng	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng', '2026-05-05 17:58:36', 0),
(33, 18, NULL, 'DOG_POM_08', 'Chó Phốc sóc mini màu trắng', 7000000, 0, 1, 1, '1777978769_6b8b3408.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Var\r\nGiới tính: Đực	Mẹ: Min\r\nMàu: Trắng	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng', '2026-05-05 17:59:29', 0),
(34, 18, NULL, 'DOG_POM_09', 'Chó Phốc Sóc màu Blacktan siêu ngầu siêu vip chân to lùn chân đi tất', 15000000, 0, 1, 1, '1777978817_5f642bca.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Mom\r\nGiới tính: Đực	Mẹ: Lucky\r\nMàu: Blacktan	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: mõm ngắn', '2026-05-05 18:00:17', 0),
(35, 18, NULL, 'DOG_POM_10', 'Chó Phốc Sóc màu trắng', 9000000, 0, 1, 1, '1777978863_99b4b53f.jpg', 'Tháng tuổi: 3 tháng tuổi	Bố: Tee\r\nGiới tính: Đực	Mẹ: Cún\r\nMàu: Trắng	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 2 mũi vacxin\r\nNguồn gốc: Thuần chủng', '2026-05-05 18:01:03', 0),
(36, 15, NULL, 'DOG_CORGI_01', 'Chó Corgi pembroke vàng trắng', 8000000, 0, 2, 1, '1777979024_1901e339.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Vàng\r\nGiới tính: Cái	Mẹ: Ngố\r\nMàu: Vàng trắng	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng', '2026-05-05 18:03:44', 0),
(37, 15, NULL, 'DOG_CORGI_02', 'Chó Corgi chân lùn', 6000000, 0, 2, 1, '1777979102_1b2a630e.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Bou\r\nGiới tính: Cái	Mẹ: Key\r\nMàu: Trắng vàng	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 2 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng', '2026-05-05 18:05:02', 0),
(38, 15, NULL, 'DOG_CORGI_03', 'Chó Corgi tricolor có đuôi', 9000000, 0, 1, 1, '1777979230_aa87fc3f.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Bom\r\nGiới tính: Cái	Mẹ: Kem\r\nMàu: Đen trắng vàng	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 2 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Lông dài', '2026-05-05 18:07:10', 0),
(39, 15, NULL, 'DOG_CORGI_04', 'Chó Corgi Fluffy VIP', 15000000, 0, 2, 1, '1777979275_6db7bd4e.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Red\r\nGiới tính: Đực	Mẹ: Coca\r\nMàu: Vàng trắng	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 2 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Lông dày', '2026-05-05 18:07:55', 0),
(40, 15, NULL, 'DOG_CORGI_05', 'Chó Corgi màu Vàng trắng', 6000000, 0, 1, 1, '1777979324_d4b8c9bc.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Bơ\r\nGiới tính: Cái	Mẹ: Mon\r\nMàu: Vàng trắng	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Tai dựng, chân ngắn', '2026-05-05 18:08:44', 0),
(41, 15, NULL, 'DOG_CORGI_06', 'Chó Corgi màu Vàng trắng', 6000000, 0, 0, 1, '1777979415_3d1bf5a0.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Mắm\r\nGiới tính: Cái	Mẹ: Mon\r\nMàu: Vàng trắng	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Tai dựng, chân ngắn', '2026-05-05 18:10:15', 0),
(42, 15, NULL, 'DOG_CORGI_07', 'Chó Corgi fluffy lông dài màu vàng trắng', 8000000, 0, 0, 1, '1777979469_37236946.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Đôla\r\nGiới tính: Đực	Mẹ: Soda\r\nMàu: Vàng trắng	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Lông dài', '2026-05-05 18:11:09', 0),
(43, 15, NULL, 'DOG_CORGI_08', 'Chó Corgi mắt xanh màu vàng trắng', 9000000, 0, 1, 1, '1777979595_17906369.jpg', 'Tháng tuổi:2 tháng tuổi	Bố: cafe\r\nGiới tính: Đực	Mẹ: Bạc xỉu\r\nMàu: Vàng trắng	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Mặt yêu', '2026-05-05 18:13:15', 0),
(44, 17, NULL, 'DOG_SHIBA_02', 'Chó Shiba Inu màu vàng', 6000000, 0, 1, 1, '1777979703_56908bbc.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Bò\r\nGiới tính: Cái	Mẹ: Sóc\r\nMàu: Vàng	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Đuôi cong', '2026-05-05 18:15:03', 0),
(45, 17, NULL, 'DOG_SHIBA_03', 'Chó Shiba Inu màu vàng', 9000000, 0, 1, 1, '1777979745_fc436721.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Min\r\nGiới tính: Đực	Mẹ: Su\r\nMàu: Vàng trắng	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Đuôi cong', '2026-05-05 18:15:45', 0),
(46, 17, NULL, 'DOG_SHIBA_04', 'Chó Shiba Inu màu blacktan', 9000000, 0, 1, 1, '1777979787_acf936d7.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Lạc\r\nGiới tính: Đực	Mẹ: Đen\r\nMàu: Blacktan	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Đuôi cong', '2026-05-05 18:16:27', 0),
(47, 17, NULL, 'DOG_SHIBA_05', 'Chó Shiba Inu màu trắng', 9000000, 0, 1, 1, '1777979867_36d2a286.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Vàng\r\nGiới tính: Cái	Mẹ: Bun\r\nMàu: Trắng	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Hài Hước', '2026-05-05 18:17:47', 0),
(48, 17, NULL, 'DOG_SHIBA_07', 'Chó Shiba Inu trắng', 8000000, 0, 1, 1, '1777979979_9ae43b68.jpg', 'Tháng tuổi:2 tháng tuổi	Bố: Blade\r\nGiới tính: Đực	Mẹ: Woni\r\nMàu: Trắng	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Lông ngắn', '2026-05-05 18:19:39', 0),
(49, 17, NULL, 'DOG_SHIBA_06', 'Chó Shiba Inu vàng', 8000000, 0, 1, 1, '1777980025_3a36435b.jpg', 'Tháng tuổi:2 tháng tuổi	Bố:Dingtea\r\nGiới tính: Cái	Mẹ: Gongcha\r\nMàu: Vàng	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Có giấy VKA', '2026-05-05 18:20:25', 0),
(50, 16, NULL, 'DOG_BICHON_01', 'Chó Bichon màu trắng', 4000000, 0, 1, 1, '1777983218_ac8fb5b0.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Gon\r\nGiới tính: Cái	Mẹ: Bơ\r\nMàu: Trắng	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Lông xù', '2026-05-05 19:13:38', 0),
(51, 16, NULL, 'DOG_BICHON_02', 'Chó Bichon màu trắng', 6000000, 0, 1, 1, '1777983261_19f75cc0.jpg', 'Tháng tuổi: 8 tháng tuổi	Bố: Bon bon\r\nGiới tính: Đực	Mẹ: Bun\r\nMàu: Trắng	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 3 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Lông xù', '2026-05-05 19:14:21', 0),
(52, 16, NULL, 'DOG_BICHON_03', 'Chó Bichon Frises trưởng thành trắng', 15000000, 0, 1, 1, '1777983309_9633bd2e.jpg', 'Tháng tuổi: 24 tháng tuổi	Bố: Sâu\r\nGiới tính: Đực	Mẹ: Lếch\r\nMàu: Trắng	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 2 lần	Tiêm phòng: 2 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Lông quăn', '2026-05-05 19:15:09', 0),
(53, 16, NULL, 'DOG_BICHON_04', 'Chó Bichon tai gấu trưởng thành màu trắng', 9000000, 0, 1, 1, '1777983380_23aa5d50.jpg', 'Tháng tuổi: 10 tháng tuổi	Bố: Xoăn\r\nGiới tính: Đực	Mẹ: Tintin\r\nMàu: Trắng	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 2 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Lông dài, tai gấu', '2026-05-05 19:16:20', 0),
(54, 16, NULL, 'DOG_BICHON_05', 'Chó Bichon màu trắng', 15000000, 0, 0, 1, '1777983451_756711e0.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Bon\r\nGiới tính: Đực	Mẹ:Bun\r\nMàu: Trắng	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Lông xù', '2026-05-05 19:17:31', 0),
(55, 16, NULL, 'DOG_BICHON_06', 'Chó Bichon', 6000000, 0, 4, 1, '1777983521_358fb0a0.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Gotek\r\nGiới tính: Đực	Mẹ: Mimi\r\nMàu: Trắng	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Chân lùn', '2026-05-05 19:18:41', 0),
(56, 20, NULL, 'CAT_ALN_03', 'Mèo Anh lông ngắn chân lùn màu golden', 8000000, 0, 1, 1, '1777983669_78def82f.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Bún\r\nGiới tính: Đực	Mẹ: Nho\r\nMàu: Golden	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Chân lùn', '2026-05-05 19:21:09', 0),
(57, 20, NULL, 'CAT_ALN_04', 'Mèo Anh lông ngắn chân lùn màu xám xanh', 9000000, 0, 1, 1, '1777983739_572d727e.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Bon\r\nGiới tính: Cái	Mẹ: Mơn\r\nMàu: Xám xanh	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Chân lùn', '2026-05-05 19:22:19', 0),
(58, 20, NULL, 'CAT_ALN_05', 'Mèo Anh lông ngắn Tabby vằn', 9000000, 0, 1, 1, '1777983986_960d7f5c.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Bốp\r\nGiới tính: Đực	Mẹ: Gạo\r\nMàu: Tabby	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Lông ngắn', '2026-05-05 19:26:26', 0),
(59, 21, NULL, 'CAT_ALD_03', 'Mèo Anh lông dài màu silver', 9000000, 0, 1, 1, '1777984156_86d251f0.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Bắp\r\nGiới tính: Cái	Mẹ: Xoăn\r\nMàu: Silver	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Lông dài', '2026-05-05 19:29:16', 0),
(60, 21, NULL, 'CAT_ALD_04', 'Mèo Anh lông dài chân lùn màu silver', 9000000, 0, 1, 1, '1777984201_4ae0c3d2.jpg', 'Tháng tuổi: 4 tháng tuổi	Bố: Park\r\nGiới tính: Đực	Mẹ: Xinh\r\nMàu: Silver	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 2 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Lông mượt', '2026-05-05 19:30:01', 0),
(61, 21, NULL, 'CAT_ALD_05', 'Mèo anh lông dài chân lùn màu blue golden', 15000000, 0, 1, 1, '1777984318_21ec60d5.jpg', 'Tháng tuổi: 3 tháng tuổi	Bố: Cat\r\nGiới tính: Cái	Mẹ: Sen\r\nMàu: Blue golden	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 2 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: hiếu động, khuôn mặt xinh xắn', '2026-05-05 19:31:58', 0),
(62, 19, NULL, 'CAT_MAINE_03', 'Mèo maine coon', 15000000, 0, 1, 1, '1777984399_9a7e197d.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Cam\r\nGiới tính : Đực	Mẹ: Mini\r\nMàu: Vàng cam	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 1 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Lông dài mượt', '2026-05-05 19:33:19', 0),
(63, 19, NULL, 'CAT_MAINE_04', 'Mèo Maine Coon xám', 15000000, 0, 1, 1, '1777984447_b117ebd0.jpg', 'Tháng tuổi: 2 tháng tuổi	Bố: Cam\r\nGiới tính: Đực	Mẹ: Meo\r\nMàu: Xám	Sức khỏe: Nhanh nhẹn, ăn uống tốt\r\nTình trạng: Có Sẵn	Vận chuyển: Miễn phí\r\nTẩy giun: 2 lần	Tiêm phòng: 1 mũi vacxin\r\nNguồn gốc: Thuần chủng, sinh sản tại Trại Pethouse	Đặc điểm: Lông dài', '2026-05-05 19:34:07', 0),
(64, 9, NULL, 'TA_DOG_01', 'Thức ăn cho chó Ganador Adult Salmon & Rice', 150000, 0, 30, 1, '1777984620_5a40e09a.jpg', 'Thức ăn cho chó Ganador Adult Salmon & Rice là thực phẩm dành cho chó trưởng thành với công thức chế biến được nghiên cứu bởi các chuyên gia\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 19:37:00', 0),
(65, 9, NULL, 'TA_DOG_02', 'Hạt Classic Pets Small Breed Dog Beef Flavour – 2kg', 190000, 0, 12, 1, '1777984683_9b7feeba.jpg', 'Thức ăn hạt Classic Pets Small Breed Dog Beef Flavour dành cho cún con với hàm lượng dinh dưỡng cao, mùi vị thơm ngon dễ dàng để các boss hấp thụ.\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 19:38:03', 0),
(66, 9, NULL, 'TA_DOG_03', 'Thức ăn hạt Smart Heart vị thịt bò cho chó con gói 400 gram', 132000, 0, 100, 1, '1777984742_6c3721b7.jpg', 'Hạt thức ăn cho chó con Smart Heart dành cho chó trong độ tuổi từ 2-10 tháng tuổi. Sản phẩm cung cấp đầy đủ dưỡng chất giúp chó có điều kiện tốt nhất trong giai đoạn phát triển.\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 19:39:02', 9),
(67, 9, NULL, 'TA_DOG_04', 'Thức ăn hạt Reflex Plus cho chó vị thịt gà và cá hồi', 132000, 0, 19, 1, '1777984784_0a266b96.jpg', 'Thức ăn hạt Reflex Plus cho chó có hai vị thịt gà và cá hồi hấp dẫn, có hàm lượng Protein cao, đáp ứng đầy đủ cho nhu cầu phát triển của cún cưng.\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 19:39:44', 0),
(68, 9, NULL, 'TA_DOG_05', 'Sữa bột Goat Gold cho chó mèo hộp 200g hàng nhập Thái Lan', 230000, 0, 14, 1, '1777984843_dda0200d.jpg', 'Sữa bột Goat Gold cho chó mèo được làm từ sữa dê giàu dinh dưỡng, hỗ trợ hiệu quả cho sự phát triển của thú cưng, là món đồ uống khoái khẩu của các bé.\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 19:40:43', 0),
(69, 9, NULL, 'TA_DOG_06', 'Pate Pedigree Puppy gói 80g thành phần thịt gà, gan, trứng, rau', 15000, 0, 11, 1, '1777984906_adfd4d32.jpg', 'Pate Pedigree Puppy gói 80g được chế biến từ những thành phần thơm ngon và giàu chất dinh dưỡng, dành cho chó dưới 12 tháng tuổi.\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 19:41:46', 0),
(70, 9, NULL, 'TA_DOG_07', 'Pate Morando dành cho chó lon 400g hàng Ý', 90000, 0, 444, 1, '1777984933_1d9f6f2e.jpg', 'Pate Morando dành cho chó là dòng sản phẩm luôn được người nuôi tin dùng, hỗ trợ bổ sung các dưỡng chất thiết yếu cho sự phát triển của thú cưng.\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 19:42:13', 0),
(71, 9, NULL, 'TA_DOG_08', 'Snack cho chó Bowwow Cheese Roll thịt gà và cá hồi cuộn phô mai', 15000, 0, 0, 1, '1777984980_10a6790d.jpg', 'Snack cho chó Bowwow Cheese Roll với hương vị phô mai béo ngậy là món ăn ưa thích của các bé cún, được làm từ thịt gà và cá hồi tươi.\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 19:43:00', 0),
(72, 9, NULL, 'TA_DOG_09', 'Bánh thưởng chó mèo Luscious hỗ trợ quá trình huấn luyện 220g', 44000, 0, 98, 1, '1777985030_ff6f88cd.jpg', 'Bánh thưởng cho chó mèo Luscious là món quà tuyệt vời mỗi khi các bé cún hoàn thành tốt một hiệu lệnh. Sử dụng bánh thưởng hợp lý sẽ giúp quá trình huấn luyện chó mèo nhanh chóng hơn rất nhiều.\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 19:43:50', 0),
(73, 10, NULL, 'PK_DOG_01', 'Áo con vịt thời trang cho chó mèo', 15000, 0, 99, 1, '1777985097_3bf76587.jpg', 'Sản phẩm có vẻ ngoài nổi bật với hình con vịt đáng yêu. được làm từ vải polyester có khả năng thông thoáng nhất định, dễ vệ sinh, làm sạch. Chiếc áo có nhiều kích cỡ để lựa chọn phù hợp cho vừa với thú cưng nhà bạn.\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 19:44:57', 0),
(74, 10, NULL, 'PK_DOG_02', 'Yếm cho chó mèo kèm dây dắt', 21000, 0, 90, 1, '1777985147_588ff7e7.webp', 'Với thiết kế hợp xu hướng thời trang cùng màu sắc bắt mắt, làm từ chất liệu vải cao cấp mang tới sư thoải mái thì đây là sản phẩm không thể thiếu trong tủ đồ thú cưng của bạn. Thú cưng sẽ cực kì nổi bật, thu hút khi mặc lên chiếc yếm xinh xắn này. Ngoài ra còn được tặng kèm dây dắt khi mà dẫn thú cưng đi chơi\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 19:45:47', 0),
(75, 10, NULL, 'PK_DOG_03', 'Rọ mõm nhựa cho chó', 54000, 0, 80, 1, '1777985233_7189679f.jpg', 'Rọ mõm nhựa cho chó 1-3kg – 20000\r\n\r\nRọ mõm nhựa cho chó 4-6kg – 26000\r\n\r\nRọ mõm nhựa cho chó 6-10kg  35000\r\n\r\nRọ mõm nhựa cho chó >10kg – 38000\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 19:47:13', 0),
(76, 10, NULL, 'PK_DOG_04', 'Nhà gỗ ngoài trời cho chó mèo', 9000000, 0, 2, 1, '1777985316_3fb28fa8.jpg', 'Nhà gỗ cho chó mèo đang rất được yêu thích bởi độ thẩm mỹ cao cũng như tính bền chắc của nó. Được sử dụng và rất phổ biến hiện nay bởi phong cách sang trọng hiện đại phù hợp ngay với cả những căn hộ chung cư cũng như khả năng dễ lắp ráp, tháo dời, di chuyển.\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 19:48:36', 0),
(77, 10, NULL, 'PK_DOG_05', 'Set túi lưới 3 size', 132000, 0, 222, 1, '1777985388_06dddc6e.jpg', 'Set túi lưới 3 size được thiết kế chắc chắn, bắt mắt có nhiều màu sắc cho người nuôi lựa chọn, có thiết kế bán kín với vải lưới giúp lưu thông không khí\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 19:49:48', 0),
(78, 10, NULL, 'PK_DOG_06', 'Tã lót vệ sinh', 12000, 0, 333, 1, '1777985443_065a82a2.jpg', 'Tã lót vệ sinh dùng để lót khay vệ sinh, đáy chuồng chó mèo đảm bảo được vệ sinh nơi ở cho thú cưng. Sản phẩm có kích thước rộng rãi, khoá mùi tốt.\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.\r\nTã lót vệ sinh số lượng\r\n1\r\n Đặt Mua', '2026-05-05 19:50:43', 0),
(79, 11, NULL, 'DC_DOG_01', 'Con tôm cao su dẻo', 15000, 0, 80, 1, '1777985572_90656175.jpg', 'Đồ chơi mô hình con tôm cao su đáng yêu, ngộ nghĩnh được làm từ nhựa cao cấp chịu được tác động liên tục khi thú cưng chơi đùa.\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 19:52:52', 0),
(80, 11, NULL, 'DC_DOG_02', 'Cá dây bố', 15000, 0, 232, 1, '1777985606_cad608ef.jpg', 'Cá dây bố được bện bằng dây dù chắc chắn, có độ bền cơ học cao ngoài ra với kiểu dáng chú cá nhiều màu sắc đem lại sự thích thú, không nhàm chán khi chơi\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 19:53:26', 0),
(81, 11, NULL, 'DC_DOG_03', 'Bóng thừng tay cầm size lớn', 32000, 0, 11, 1, '1777985648_e8d474a7.jpg', 'Bóng thừng tay cầm size lớn là món đồ chơi thú vị giúp giảm stress, giúp thú cưng thư giãn hạn chế việc đồ đạc bị hư khi các bé trong giai đoạn ngứa răng.\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 19:54:08', 0),
(82, 11, NULL, 'DC_DOG_04', 'Dây thừng gặm cho cún giải tỏa stress', 20000, 0, 24, 1, '1777985695_d48af9ad.jpg', 'Dây thừng gặm cho cún thích hợp cho các boss đang vào thời kì mọc răng, ngứa răng. Sản phẩm giúp cún giảm stress, hạn chế cắn phá đồ đạc gây hỏng hóc.\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 19:54:55', 0),
(83, 12, NULL, 'TA_CAT_01', 'Hạt Cat Line thức ăn cho mèo', 132000, 0, 33, 1, '1777985763_f409bdfd.jpg', 'Thức ăn hạt Cat Line cho mèo nhập khẩu từ Hàn Quốc phù hợp cho mọi lứa tuổi, đem đến những bữa ăn đầy đủ dinh dưỡng và ngon miệng đến cho các boss nhỏ.\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 19:56:03', 6),
(84, 12, NULL, 'TA_CAT_02', 'Sữa Petsure Premium cho chó mèo hộp 110g', 232000, 0, 90, 1, '1777985863_521999dd.png', 'Sữa bột Petsure Premium cho chó mèo được sản xuất bởi thương hiệu Dr. Kyan danh tiếng, là dòng sữa bổ sung dinh dưỡng tuyệt vời cho các bé thú cưng.\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 19:57:43', 0),
(85, 12, NULL, 'TA_CAT_03', 'Bánh Luscious cho mèo gói 80g hình con cá ngộ nghĩnh', 32000, 0, 21, 1, '1777985913_bf7b67b2.jpg', 'Bánh Luscious cho mèo với mùi vị thơm ngon, là món đồ ăn vặt ưa thích của các bé. Được tạo hình con cá cute, có độ cứng vừa phải giúp các bé dễ tiêu hóa.\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 19:58:33', 0),
(86, 12, NULL, 'TA_CAT_04', 'Súp thưởng Wanpy có nắp vặn cho mèo – Gói 80g', 13200, 0, 32, 1, '1777985969_a5d6f623.jpg', 'Súp thưởng Wanpy có nắp vặn với thiết kế thông minh dễ dàng bảo quản, hương vị thơm ngon, là món ăn khoái khẩu của các boss.\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 19:59:29', 0),
(87, 14, NULL, 'PK_CAT_01', 'Găng chải lông chó mèo', 70000, 0, 80, 1, '1777986078_8667effd.jpg', 'Găng chải lông hỗ trợ đắc lực cho người nuôi trong vấn đề vệ sinh lông rụng, làm mượt lông cho thú cưng hàng ngày, chất liệu vải thô thoáng khí chống mùi\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 20:01:18', 0),
(88, 14, NULL, 'PK_CAT_02', 'Vòng cổ đan tay nhiều chuông cho chó mèo', 15000, 0, 99, 1, '1777986150_d54d99b4.jpg', 'Vòng cổ đan tay nhiều chuông cho chó mèo được thiết kế dành riêng cho các boss nhỏ được bện bằng dây dù chắc chắn, không sợ bị phai màu theo thời gian.\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 20:02:30', 0),
(89, 14, NULL, 'PK_CAT_03', 'Váy dạ hội cao cấp', 99000, 0, 12, 1, '1777986205_f8018922.jpg', 'Sự sang trọng, tinh tế và lịch sự chính là điểm nhấn của chiếc váy này. Khi mặc lên người, thú cưng của bạn trông sẽ thật lộng lẫy, nổi bật giữa những chốn đông người trong các sự kiện, cuộc đi chơi, hội nghị.\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 20:03:25', 0),
(90, 14, NULL, 'PK_CAT_04', 'Xịt tắm khô Fay Groom for Cat 350ml', 77000, 0, 9, 1, '1777986272_46e917c3.jpg', 'Bạn ngại mỗi lần tắm cho mèo cưng, thấy ám ảnh về việc mèo cào cấu kêu gào khi tắm? Với Xịt tắm khô Fay Groom for Cat, điều này sẽ được loại bỏ hoàn toàn.\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 20:04:32', 0),
(91, 14, NULL, 'PK_CAT_05', 'Hạt khử mùi phân mèo', 60000, 0, 100, 1, '1777986316_aae05f8b.jpg', 'Hạt khử mùi phân mèo với thành phần than hoạt tính có khả năng khoá mùi hôi phân trong cát vệ sinh thú cưng hiệu quả, không gây bụi, thời gian sử dụng dài\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 20:05:16', 0),
(92, 14, NULL, 'PK_CAT_06', 'Cát đậu nành Tofu Cature – Sản phẩm cao cấp khử mùi cực kỳ hiệu quả 7 lít', 232000, 0, 77, 1, '1777986395_79693d08.jpg', 'Cát đậu nành Tofu Cature có xuất xứ từ Mỹ, được làm từ chất liệu tự nhiên (bã đậu nành) không gây bụi, đảm bảo an toàn cho người và thú nuôi.\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 20:06:35', 0),
(93, 14, NULL, 'PK_CAT_07', 'Nhà Mèo Đẹp Hiện Đại', 9000000, 0, 2, 1, '1777986435_8ddddd48.jpg', 'Nhà Mèo Đẹp Hiện Đại, sản phẩm này được thiết kế thông minh với ba tầng riêng biệt, tạo ra không gian rộng rãi cho mèo leo trèo, chơi đùa và nghỉ ngơi. Mỗi tầng đều được trang bị các kệ phẳng và góc nghỉ ngơi thoải mái, giúp mèo tìm thấy những vị trí lý tưởng để thư giãn sau những giờ phút vui chơi mệt mỏi.\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 20:07:15', 2),
(94, 13, NULL, 'DC_CAT_01', 'Trụ cào móng cho mèo kèm đồ chơi', 450000, 0, 2, 1, '1777986495_1ecdc669.jpg', 'Sản phẩm làm từ loại thừng sisal có độ chắc chắn và bền cao cho bé mèo thoải mái cào móng để bỏ lớp móng cũ sau đó giảm đi độ sắc của bộ mới. Được gắn thêm đồ chơi thú vị để giải tỏa cho các bạn mèo tinh nghịch. Vì nhỏ gọn nên bạn có thể đặt ở bất cứ đâu\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 20:08:15', 5),
(95, 13, NULL, 'DC_CAT_02', 'Bàn cào tròn 36x10cm', 50000, 0, 19, 1, '1777986544_e4a39cbb.jpg', 'Bàn cao tròn 36x10cm là phụ kiện đồ chơi để cho mèo cưng cào móng, giảm stress giúp tinh thần các boss nhỏ luôn thoải mái, dễ chịu.\r\n\r\nLưu ý: Giá sản phẩm có thể thay đổi theo từng thời điểm. Kết Bạn Zalo hoặc Gọi Hotline để xem thêm hình ảnh/video chi tiết.', '2026-05-05 20:09:04', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `san_pham_anh`
--

CREATE TABLE `san_pham_anh` (
  `id` int(11) NOT NULL,
  `id_san_pham` int(11) NOT NULL,
  `duong_dan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thanh_toan`
--

CREATE TABLE `thanh_toan` (
  `id` int(11) NOT NULL,
  `id_don_hang` int(11) NOT NULL,
  `phuong_thuc` enum('TIEN_MAT','CHUYEN_KHOAN') NOT NULL DEFAULT 'TIEN_MAT',
  `so_tien` int(11) NOT NULL,
  `thoi_gian` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_don_sp` (`id_don_hang`,`id_san_pham`),
  ADD KEY `idx_ctdh_id_don_hang` (`id_don_hang`),
  ADD KEY `idx_ctdh_id_san_pham` (`id_san_pham`);

--
-- Chỉ mục cho bảng `chi_tiet_phieu_nhap`
--
ALTER TABLE `chi_tiet_phieu_nhap`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ctpn_phieu_nhap` (`phieu_nhap_id`),
  ADD KEY `fk_ctpn_san_pham` (`san_pham_id`);

--
-- Chỉ mục cho bảng `danh_muc`
--
ALTER TABLE `danh_muc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_danh_muc_cha` (`id_cha`);

--
-- Chỉ mục cho bảng `dat_dich_vu_spa`
--
ALTER TABLE `dat_dich_vu_spa`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `dich_vu`
--
ALTER TABLE `dich_vu`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `dich_vu_ho_boi`
--
ALTER TABLE `dich_vu_ho_boi`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `dich_vu_khachsan`
--
ALTER TABLE `dich_vu_khachsan`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `dich_vu_spa`
--
ALTER TABLE `dich_vu_spa`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nhan_vien` (`id_nhan_vien`),
  ADD KEY `idx_dh_ngay` (`ngay_tao`),
  ADD KEY `idx_dh_kh` (`id_khach_hang`),
  ADD KEY `idx_dh_tt` (`trang_thai`),
  ADD KEY `idx_dh_ship` (`trang_thai_giao_hang`);

--
-- Chỉ mục cho bảng `khach_hang`
--
ALTER TABLE `khach_hang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `so_dien_thoai` (`so_dien_thoai`);

--
-- Chỉ mục cho bảng `khach_hang_than_thiet`
--
ALTER TABLE `khach_hang_than_thiet`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_khach_hang_than_thiet` (`khach_hang_id`);

--
-- Chỉ mục cho bảng `lich_hen`
--
ALTER TABLE `lich_hen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_khach_hang` (`id_khach_hang`),
  ADD KEY `id_dich_vu` (`id_dich_vu`),
  ADD KEY `id_nhan_vien` (`id_nhan_vien`);

--
-- Chỉ mục cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ten_dang_nhap` (`ten_dang_nhap`);

--
-- Chỉ mục cho bảng `nha_cung_cap`
--
ALTER TABLE `nha_cung_cap`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `phieu_nhap`
--
ALTER TABLE `phieu_nhap`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma_phieu` (`ma_phieu`),
  ADD KEY `fk_phieu_nhap_nha_cung_cap` (`nha_cung_cap_id`);

--
-- Chỉ mục cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma_sku` (`ma_sku`),
  ADD KEY `idx_sp_id_danh_muc` (`id_danh_muc`),
  ADD KEY `fk_san_pham_nha_cung_cap` (`id_nha_cung_cap`);

--
-- Chỉ mục cho bảng `san_pham_anh`
--
ALTER TABLE `san_pham_anh`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_san_pham` (`id_san_pham`);

--
-- Chỉ mục cho bảng `thanh_toan`
--
ALTER TABLE `thanh_toan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_don_hang` (`id_don_hang`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `chi_tiet_phieu_nhap`
--
ALTER TABLE `chi_tiet_phieu_nhap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `danh_muc`
--
ALTER TABLE `danh_muc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `dat_dich_vu_spa`
--
ALTER TABLE `dat_dich_vu_spa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `dich_vu`
--
ALTER TABLE `dich_vu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `dich_vu_ho_boi`
--
ALTER TABLE `dich_vu_ho_boi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `dich_vu_khachsan`
--
ALTER TABLE `dich_vu_khachsan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `dich_vu_spa`
--
ALTER TABLE `dich_vu_spa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `khach_hang`
--
ALTER TABLE `khach_hang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `khach_hang_than_thiet`
--
ALTER TABLE `khach_hang_than_thiet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `lich_hen`
--
ALTER TABLE `lich_hen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `nha_cung_cap`
--
ALTER TABLE `nha_cung_cap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `phieu_nhap`
--
ALTER TABLE `phieu_nhap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT cho bảng `san_pham_anh`
--
ALTER TABLE `san_pham_anh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `thanh_toan`
--
ALTER TABLE `thanh_toan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  ADD CONSTRAINT `chi_tiet_don_hang_ibfk_1` FOREIGN KEY (`id_don_hang`) REFERENCES `don_hang` (`id`),
  ADD CONSTRAINT `chi_tiet_don_hang_ibfk_2` FOREIGN KEY (`id_san_pham`) REFERENCES `san_pham` (`id`),
  ADD CONSTRAINT `fk_ctdh__don_hang__id_don_hang` FOREIGN KEY (`id_don_hang`) REFERENCES `don_hang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ctdh__san_pham__id_san_pham` FOREIGN KEY (`id_san_pham`) REFERENCES `san_pham` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ctdh_dh` FOREIGN KEY (`id_don_hang`) REFERENCES `don_hang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ctdh_sp` FOREIGN KEY (`id_san_pham`) REFERENCES `san_pham` (`id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `chi_tiet_phieu_nhap`
--
ALTER TABLE `chi_tiet_phieu_nhap`
  ADD CONSTRAINT `fk_ctpn_phieu_nhap` FOREIGN KEY (`phieu_nhap_id`) REFERENCES `phieu_nhap` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ctpn_san_pham` FOREIGN KEY (`san_pham_id`) REFERENCES `san_pham` (`id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `danh_muc`
--
ALTER TABLE `danh_muc`
  ADD CONSTRAINT `fk_danh_muc_cha` FOREIGN KEY (`id_cha`) REFERENCES `danh_muc` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  ADD CONSTRAINT `don_hang_ibfk_1` FOREIGN KEY (`id_khach_hang`) REFERENCES `khach_hang` (`id`),
  ADD CONSTRAINT `don_hang_ibfk_2` FOREIGN KEY (`id_nhan_vien`) REFERENCES `nguoi_dung` (`id`);

--
-- Các ràng buộc cho bảng `khach_hang_than_thiet`
--
ALTER TABLE `khach_hang_than_thiet`
  ADD CONSTRAINT `khach_hang_than_thiet_ibfk_1` FOREIGN KEY (`khach_hang_id`) REFERENCES `khach_hang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `lich_hen`
--
ALTER TABLE `lich_hen`
  ADD CONSTRAINT `lich_hen_ibfk_1` FOREIGN KEY (`id_khach_hang`) REFERENCES `khach_hang` (`id`),
  ADD CONSTRAINT `lich_hen_ibfk_2` FOREIGN KEY (`id_dich_vu`) REFERENCES `dich_vu` (`id`),
  ADD CONSTRAINT `lich_hen_ibfk_3` FOREIGN KEY (`id_nhan_vien`) REFERENCES `nguoi_dung` (`id`);

--
-- Các ràng buộc cho bảng `phieu_nhap`
--
ALTER TABLE `phieu_nhap`
  ADD CONSTRAINT `fk_phieu_nhap_nha_cung_cap` FOREIGN KEY (`nha_cung_cap_id`) REFERENCES `nha_cung_cap` (`id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  ADD CONSTRAINT `fk_san_pham__danh_muc__id_danh_muc` FOREIGN KEY (`id_danh_muc`) REFERENCES `danh_muc` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_san_pham_nha_cung_cap` FOREIGN KEY (`id_nha_cung_cap`) REFERENCES `nha_cung_cap` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_sp_dm` FOREIGN KEY (`id_danh_muc`) REFERENCES `danh_muc` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `san_pham_ibfk_1` FOREIGN KEY (`id_danh_muc`) REFERENCES `danh_muc` (`id`);

--
-- Các ràng buộc cho bảng `san_pham_anh`
--
ALTER TABLE `san_pham_anh`
  ADD CONSTRAINT `san_pham_anh_ibfk_1` FOREIGN KEY (`id_san_pham`) REFERENCES `san_pham` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `thanh_toan`
--
ALTER TABLE `thanh_toan`
  ADD CONSTRAINT `thanh_toan_ibfk_1` FOREIGN KEY (`id_don_hang`) REFERENCES `don_hang` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
