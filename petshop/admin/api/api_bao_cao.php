<?php
if (session_status() === PHP_SESSION_NONE) session_start();
header("Content-Type: application/json; charset=utf-8");

require_once __DIR__ . "/../../config/ket_noi_csdl.php";

function out($ok, $data = []) {
  echo json_encode(array_merge(["ok"=>$ok], $data), JSON_UNESCAPED_UNICODE);
  exit;
}

if (empty($_SESSION["user"])) {
  out(false, ["msg"=>"Chưa đăng nhập"]);
}

$action = $_GET["action"] ?? "report";
$from = $_GET["from"] ?? date("Y-m-01");
$to = $_GET["to"] ?? date("Y-m-d");

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $from)) $from = date("Y-m-01");
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $to)) $to = date("Y-m-d");

$whereDate = "DATE(dh.ngay_tao) BETWEEN ? AND ?";

function fetch_all_stmt($stmt) {
  $stmt->execute();
  $rs = $stmt->get_result();
  $data = [];
  while($row = $rs->fetch_assoc()) $data[] = $row;
  return $data;
}

if ($action === "export") {
  header_remove("Content-Type");
  header("Content-Type: text/csv; charset=utf-8");
  header("Content-Disposition: attachment; filename=bao_cao_petshop_{$from}_{$to}.csv");

  echo "\xEF\xBB\xBF";
  $out = fopen("php://output", "w");

  fputcsv($out, ["BÁO CÁO PETSHOP"]);
  fputcsv($out, ["Từ ngày", $from, "Đến ngày", $to]);
  fputcsv($out, []);

  $stmt = $conn->prepare("
    SELECT dh.id, kh.ho_ten, kh.so_dien_thoai, dh.ngay_tao, dh.tong_tien, dh.trang_thai
    FROM don_hang dh
    LEFT JOIN khach_hang kh ON kh.id = dh.id_khach_hang
    WHERE DATE(dh.ngay_tao) BETWEEN ? AND ?
    ORDER BY dh.id DESC
  ");
  $stmt->bind_param("ss", $from, $to);
  $orders = fetch_all_stmt($stmt);

  fputcsv($out, ["DANH SÁCH ĐƠN HÀNG"]);
  fputcsv($out, ["Mã đơn", "Khách hàng", "SĐT", "Ngày tạo", "Tổng tiền", "Trạng thái"]);

  foreach($orders as $o){
    fputcsv($out, [
      $o["id"],
      $o["ho_ten"],
      $o["so_dien_thoai"],
      $o["ngay_tao"],
      $o["tong_tien"],
      $o["trang_thai"]
    ]);
  }

  fclose($out);
  exit;
}

try {
  $stmt = $conn->prepare("
    SELECT 
      COALESCE(SUM(CASE WHEN dh.trang_thai = 'DA_THANH_TOAN' THEN dh.tong_tien ELSE 0 END),0) AS doanh_thu,
      COUNT(*) AS tong_don,
      SUM(CASE WHEN dh.trang_thai = 'DA_THANH_TOAN' THEN 1 ELSE 0 END) AS don_da_thanh_toan,
      SUM(CASE WHEN dh.trang_thai <> 'DA_THANH_TOAN' THEN 1 ELSE 0 END) AS don_chua_thanh_toan
    FROM don_hang dh
    WHERE $whereDate
  ");
  $stmt->bind_param("ss", $from, $to);
  $stmt->execute();
  $stats = $stmt->get_result()->fetch_assoc();

  $rs = $conn->query("SELECT COUNT(*) AS c FROM khach_hang");
  $stats["tong_khach"] = (int)($rs->fetch_assoc()["c"] ?? 0);

  $rs = $conn->query("SELECT COUNT(*) AS c FROM san_pham WHERE trang_thai = 1");
  $stats["tong_san_pham"] = (int)($rs->fetch_assoc()["c"] ?? 0);

  $rs = $conn->query("SELECT COUNT(*) AS c FROM san_pham WHERE trang_thai = 1 AND ton_kho > 0 AND ton_kho <= 5");
  $stats["sap_het_hang"] = (int)($rs->fetch_assoc()["c"] ?? 0);

  $stmt = $conn->prepare("
    SELECT DATE(dh.ngay_tao) AS ngay, COALESCE(SUM(dh.tong_tien),0) AS doanh_thu
    FROM don_hang dh
    WHERE $whereDate AND dh.trang_thai = 'DA_THANH_TOAN'
    GROUP BY DATE(dh.ngay_tao)
    ORDER BY ngay ASC
  ");
  $stmt->bind_param("ss", $from, $to);
  $doanh_thu_ngay = fetch_all_stmt($stmt);

  $stmt = $conn->prepare("
    SELECT 
      sp.ten_san_pham,
      sp.ma_sku,
      SUM(ct.so_luong) AS so_luong_ban,
      SUM(ct.so_luong * ct.don_gia) AS doanh_thu
    FROM chi_tiet_don_hang ct
    JOIN don_hang dh ON dh.id = ct.id_don_hang
    JOIN san_pham sp ON sp.id = ct.id_san_pham
    WHERE $whereDate AND dh.trang_thai = 'DA_THANH_TOAN'
    GROUP BY sp.id, sp.ten_san_pham, sp.ma_sku
    ORDER BY so_luong_ban DESC
    LIMIT 10
  ");
  $stmt->bind_param("ss", $from, $to);
  $top_san_pham = fetch_all_stmt($stmt);

  $stmt = $conn->prepare("
    SELECT 
      kh.ho_ten,
      kh.so_dien_thoai,
      COUNT(dh.id) AS so_don,
      SUM(dh.tong_tien) AS tong_mua
    FROM don_hang dh
    LEFT JOIN khach_hang kh ON kh.id = dh.id_khach_hang
    WHERE $whereDate AND dh.trang_thai = 'DA_THANH_TOAN'
    GROUP BY kh.id, kh.ho_ten, kh.so_dien_thoai
    ORDER BY tong_mua DESC
    LIMIT 10
  ");
  $stmt->bind_param("ss", $from, $to);
  $top_khach_hang = fetch_all_stmt($stmt);

  out(true, [
    "stats"=>$stats,
    "doanh_thu_ngay"=>$doanh_thu_ngay,
    "top_san_pham"=>$top_san_pham,
    "top_khach_hang"=>$top_khach_hang
  ]);

} catch(Throwable $e) {
  out(false, ["msg"=>$e->getMessage()]);
}