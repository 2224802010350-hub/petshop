<?php
require_once __DIR__ . "/../../config/ket_noi_csdl.php";

if (session_status() === PHP_SESSION_NONE) session_start();
header("Content-Type: application/json; charset=utf-8");

function out($ok, $data = []) {
  echo json_encode(array_merge(["ok" => $ok], $data), JSON_UNESCAPED_UNICODE);
  exit;
}

if (empty($_SESSION["user"])) {
  out(false, ["msg" => "Chưa đăng nhập"]);
}

try {
  $stats = [];

  // Tổng doanh thu đã thanh toán
  $rs = $conn->query("
    SELECT COALESCE(SUM(tong_tien), 0) AS total
    FROM don_hang
    WHERE trang_thai = 'DA_THANH_TOAN'
  ");
  $stats["doanh_thu"] = (float)$rs->fetch_assoc()["total"];

  // Tổng đơn hàng
  $rs = $conn->query("SELECT COUNT(*) AS total FROM don_hang");
  $stats["tong_don"] = (int)$rs->fetch_assoc()["total"];

  // Đơn đã thanh toán
  $rs = $conn->query("
    SELECT COUNT(*) AS total
    FROM don_hang
    WHERE trang_thai = 'DA_THANH_TOAN'
  ");
  $stats["don_da_thanh_toan"] = (int)$rs->fetch_assoc()["total"];

  // Đơn chưa thanh toán
  $rs = $conn->query("
    SELECT COUNT(*) AS total
    FROM don_hang
    WHERE trang_thai = 'CHUA_THANH_TOAN'
  ");
  $stats["don_chua_thanh_toan"] = (int)$rs->fetch_assoc()["total"];

  // Tổng khách hàng
  $rs = $conn->query("SELECT COUNT(*) AS total FROM khach_hang");
  $stats["tong_khach"] = (int)$rs->fetch_assoc()["total"];

  // Tổng sản phẩm
  $rs = $conn->query("SELECT COUNT(*) AS total FROM san_pham");
  $stats["tong_san_pham"] = (int)$rs->fetch_assoc()["total"];

  // Sản phẩm sắp hết hàng
  $rs = $conn->query("
    SELECT COUNT(*) AS total
    FROM san_pham
    WHERE ton_kho <= 5
  ");
  $stats["sap_het_hang"] = (int)$rs->fetch_assoc()["total"];

  // Doanh thu 7 ngày gần nhất
  $rs = $conn->query("
    SELECT 
      DATE(ngay_tao) AS ngay,
      COALESCE(SUM(tong_tien), 0) AS doanh_thu
    FROM don_hang
    WHERE trang_thai = 'DA_THANH_TOAN'
      AND ngay_tao >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
    GROUP BY DATE(ngay_tao)
    ORDER BY ngay ASC
  ");

  $doanh_thu_ngay = [];
  while ($row = $rs->fetch_assoc()) {
    $doanh_thu_ngay[] = $row;
  }

  // Top sản phẩm bán chạy
  $rs = $conn->query("
    SELECT 
      sp.id,
      sp.ten_san_pham,
      sp.ma_sku,
      SUM(ct.so_luong) AS so_luong_ban,
      SUM(ct.so_luong * ct.don_gia) AS doanh_thu
    FROM chi_tiet_don_hang ct
    INNER JOIN don_hang dh ON dh.id = ct.id_don_hang
    INNER JOIN san_pham sp ON sp.id = ct.id_san_pham
    WHERE dh.trang_thai = 'DA_THANH_TOAN'
    GROUP BY sp.id, sp.ten_san_pham, sp.ma_sku
    ORDER BY so_luong_ban DESC
    LIMIT 5
  ");

  $top_san_pham = [];
  while ($row = $rs->fetch_assoc()) {
    $top_san_pham[] = $row;
  }

  // Top khách hàng mua nhiều
  $rs = $conn->query("
    SELECT 
      kh.id,
      kh.ho_ten,
      kh.so_dien_thoai,
      COUNT(dh.id) AS so_don,
      SUM(dh.tong_tien) AS tong_mua
    FROM don_hang dh
    INNER JOIN khach_hang kh ON kh.id = dh.id_khach_hang
    WHERE dh.trang_thai = 'DA_THANH_TOAN'
    GROUP BY kh.id, kh.ho_ten, kh.so_dien_thoai
    ORDER BY tong_mua DESC
    LIMIT 5
  ");

  $top_khach_hang = [];
  while ($row = $rs->fetch_assoc()) {
    $top_khach_hang[] = $row;
  }

  out(true, [
    "stats" => $stats,
    "doanh_thu_ngay" => $doanh_thu_ngay,
    "top_san_pham" => $top_san_pham,
    "top_khach_hang" => $top_khach_hang
  ]);

} catch (Throwable $e) {
  out(false, ["msg" => "Lỗi: " . $e->getMessage()]);
}