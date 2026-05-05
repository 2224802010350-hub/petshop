<?php
if (session_status() === PHP_SESSION_NONE) session_start();

header("Content-Type: application/json; charset=utf-8");

require_once __DIR__ . "/../../config/ket_noi_csdl.php";

function out_json($data) {
  echo json_encode($data, JSON_UNESCAPED_UNICODE);
  exit;
}

if (!isset($conn) || !($conn instanceof mysqli)) {
  out_json(["ok" => false, "msg" => "Không kết nối được CSDL"]);
}

try {
  $data = [
    "ok" => true,
    "counts" => [
      "khach_hang" => 0,
      "san_pham" => 0,
      "don_hang" => 0
    ],
    "revenue" => [
      "total_paid" => 0,
      "today_paid" => 0,
      "month_paid" => 0
    ],
    "recent_orders" => [],
    "low_stock" => []
  ];

  // Tổng khách hàng
  $rs = $conn->query("SELECT COUNT(*) AS total FROM khach_hang");
  if ($rs) $data["counts"]["khach_hang"] = (int)$rs->fetch_assoc()["total"];

  // Tổng sản phẩm
  $rs = $conn->query("SELECT COUNT(*) AS total FROM san_pham");
  if ($rs) $data["counts"]["san_pham"] = (int)$rs->fetch_assoc()["total"];

  // Tổng đơn hàng
  $rs = $conn->query("SELECT COUNT(*) AS total FROM don_hang");
  if ($rs) $data["counts"]["don_hang"] = (int)$rs->fetch_assoc()["total"];

  // Tổng doanh thu đã thanh toán
  $rs = $conn->query("
    SELECT COALESCE(SUM(tong_tien), 0) AS total
    FROM don_hang
    WHERE trang_thai = 'DA_THANH_TOAN'
  ");
  if ($rs) $data["revenue"]["total_paid"] = (float)$rs->fetch_assoc()["total"];

  // Doanh thu hôm nay
  $rs = $conn->query("
    SELECT COALESCE(SUM(tong_tien), 0) AS total
    FROM don_hang
    WHERE trang_thai = 'DA_THANH_TOAN'
      AND DATE(ngay_tao) = CURDATE()
  ");
  if ($rs) $data["revenue"]["today_paid"] = (float)$rs->fetch_assoc()["total"];

  // Doanh thu tháng này
  $rs = $conn->query("
    SELECT COALESCE(SUM(tong_tien), 0) AS total
    FROM don_hang
    WHERE trang_thai = 'DA_THANH_TOAN'
      AND MONTH(ngay_tao) = MONTH(CURDATE())
      AND YEAR(ngay_tao) = YEAR(CURDATE())
  ");
  if ($rs) $data["revenue"]["month_paid"] = (float)$rs->fetch_assoc()["total"];

  // Đơn hàng gần đây
  $rs = $conn->query("
    SELECT 
      dh.id,
      dh.ma_don,
      dh.ngay_tao,
      dh.trang_thai,
      dh.trang_thai_giao_hang,
      dh.tong_tien,
      COALESCE(kh.ho_ten, 'Khách lẻ') AS khach
    FROM don_hang dh
    LEFT JOIN khach_hang kh ON kh.id = dh.id_khach_hang
    ORDER BY dh.id DESC
    LIMIT 6
  ");

  if ($rs) {
    while ($row = $rs->fetch_assoc()) {
      $data["recent_orders"][] = $row;
    }
  }

  // Tồn kho thấp
  $rs = $conn->query("
    SELECT 
      id,
      ma_sku,
      ten_san_pham,
      ton_kho
    FROM san_pham
    WHERE ton_kho <= 5
    ORDER BY ton_kho ASC, id DESC
    LIMIT 8
  ");

  if ($rs) {
    while ($row = $rs->fetch_assoc()) {
      $data["low_stock"][] = $row;
    }
  }

  out_json($data);

} catch (Throwable $e) {
  out_json([
    "ok" => false,
    "msg" => "Lỗi: " . $e->getMessage()
  ]);
}