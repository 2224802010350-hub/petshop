<?php
// PETSHOP/api/admin/api_dashboard.php
require_once __DIR__ . "/../../config/ket_noi_csdl.php";
require_once __DIR__ . "/../../config/ham_chung.php";
require_login();

header("Content-Type: application/json; charset=utf-8");

// Hàm đếm nhanh
function countTable($table){
  global $conn;
  $rs = $conn->query("SELECT COUNT(*) c FROM $table");
  if (!$rs) return 0;
  return (int)$rs->fetch_assoc()['c'];
}

$counts = [
  "khach_hang" => countTable("khach_hang"),
  "san_pham"   => countTable("san_pham"),
  "don_hang"   => countTable("don_hang"),
];

// Revenue total paid
$total_paid = 0;
$today_paid = 0;
$month_paid = 0;

// Nếu DB bạn dùng trạng thái khác DA_THANH_TOAN, sửa tại đây cho khớp.
$statusPaid = "DA_THANH_TOAN";

$r1 = $conn->query("SELECT COALESCE(SUM(tong_tien),0) s FROM don_hang WHERE trang_thai='$statusPaid'");
if ($r1) $total_paid = (int)$r1->fetch_assoc()['s'];

$r2 = $conn->query("SELECT COALESCE(SUM(tong_tien),0) s
                    FROM don_hang
                    WHERE trang_thai='$statusPaid' AND DATE(ngay_tao)=CURDATE()");
if ($r2) $today_paid = (int)$r2->fetch_assoc()['s'];

$r3 = $conn->query("SELECT COALESCE(SUM(tong_tien),0) s
                    FROM don_hang
                    WHERE trang_thai='$statusPaid'
                      AND YEAR(ngay_tao)=YEAR(CURDATE())
                      AND MONTH(ngay_tao)=MONTH(CURDATE())");
if ($r3) $month_paid = (int)$r3->fetch_assoc()['s'];

// Recent orders
$recent_orders = [];
$qRecent = $conn->query("
  SELECT dh.id, dh.ngay_tao, dh.trang_thai, dh.tong_tien, kh.ho_ten AS khach
  FROM don_hang dh
  LEFT JOIN khach_hang kh ON kh.id = dh.id_khach_hang
  ORDER BY dh.id DESC
  LIMIT 8
");
if ($qRecent) $recent_orders = $qRecent->fetch_all(MYSQLI_ASSOC);

// Low stock (ngưỡng 5)
$low_stock = [];
$qLow = $conn->query("
  SELECT ma_sku, ten_san_pham, ton_kho
  FROM san_pham
  WHERE ton_kho <= 5
  ORDER BY ton_kho ASC
  LIMIT 8
");
if ($qLow) $low_stock = $qLow->fetch_all(MYSQLI_ASSOC);

echo json_encode([
  "ok" => true,
  "counts" => $counts,
  "revenue" => [
    "total_paid" => $total_paid,
    "today_paid" => $today_paid,
    "month_paid" => $month_paid,
  ],
  "recent_orders" => $recent_orders,
  "low_stock" => $low_stock
]);
