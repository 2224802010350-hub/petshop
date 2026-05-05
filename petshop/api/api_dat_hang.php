
<?php
// petshop/api/api_dat_hang.php
header('Content-Type: text/plain; charset=utf-8');
require_once __DIR__ . "/../../config/ham_chung.php";
session_start();
require_once __DIR__ . "/../config/ket_noi_csdl.php"; // phải tạo ra $conn (mysqli)

if (!isset($conn)) die("Thiếu biến kết nối DB ($conn).");

// ====== Lấy dữ liệu gửi lên (POST) ======
$ten_nhan   = trim($_POST['ten_nhan'] ?? '');
$sdt_nhan   = trim($_POST['sdt_nhan'] ?? '');
$email_nhan = trim($_POST['email_nhan'] ?? '');
$dia_chi_nhan = trim($_POST['dia_chi_nhan'] ?? '');
$ghi_chu    = trim($_POST['ghi_chu'] ?? '');

$phuong_thuc_tt = trim($_POST['phuong_thuc_tt'] ?? 'COD'); // COD | ONLINE...
$trang_thai_giao_hang = trim($_POST['trang_thai_giao_hang'] ?? 'DA_XAC_NHAN'); // DA_XAC_NHAN|CHO_GIAO|GIAO_TC

// ====== Lấy giỏ hàng từ session (bạn đang dùng session cart thì ok) ======
// Format gợi ý: $_SESSION['cart'][id_sp] = so_luong;
$cart = $_SESSION['cart'] ?? [];

if ($ten_nhan === '' || $sdt_nhan === '' || $dia_chi_nhan === '') {
  http_response_code(400);
  die("Thiếu thông tin: ten_nhan / sdt_nhan / dia_chi_nhan");
}
if (!is_array($cart) || count($cart) === 0) {
  http_response_code(400);
  die("Giỏ hàng rỗng.");
}

// ====== Tính tiền từ DB ======
$ids = array_keys($cart);
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$types = str_repeat('i', count($ids));

$sqlSp = "SELECT id, gia_ban, ton_kho, trang_thai FROM san_pham WHERE id IN ($placeholders)";
$stmt = $conn->prepare($sqlSp);
$stmt->bind_param(
  "iiiissssssssss",
  $id_khach_hang,
  $tam_tinh, $giam_gia, $tong_tien, $ghi_chu,
  $ma_don, $trang_thai_giao_hang, $phuong_thuc_tt,
  $ten_nhan, $sdt_nhan, $email_nhan, $dia_chi_nhan
);
$stmt->execute();
$res = $stmt->get_result();

$spMap = [];
while ($row = $res->fetch_assoc()) $spMap[(int)$row['id']] = $row;
$stmt->close();

$tam_tinh = 0;
foreach ($cart as $id_sp => $sl) {
  $id_sp = (int)$id_sp;
  $sl = (int)$sl;

  if (!isset($spMap[$id_sp])) {
    http_response_code(400);
    die("Sản phẩm ID=$id_sp không tồn tại.");
  }
  if ((int)$spMap[$id_sp]['trang_thai'] !== 1) {
    http_response_code(400);
    die("Sản phẩm ID=$id_sp đang không bán (trang_thai != 1).");
  }
  if ($sl <= 0) {
    http_response_code(400);
    die("Số lượng không hợp lệ cho ID=$id_sp.");
  }
  if ((int)$spMap[$id_sp]['ton_kho'] < $sl) {
    http_response_code(400);
    die("Không đủ tồn kho cho ID=$id_sp.");
  }

  $tam_tinh += ((int)$spMap[$id_sp]['gia_ban']) * $sl;
}

$giam_gia = 0;
$tong_tien = $tam_tinh - $giam_gia;

$ma_don = 'DH' . date('YmdHis') . rand(10,99); // ví dụ DH2026030201305512

// ====== Ghi DB trong transaction ======
$conn->begin_transaction();

try {
  // 1) Tạo đơn hàng
  $sqlDh = "INSERT INTO don_hang
    (id_khach_hang, id_nhan_vien, trang_thai, tam_tinh, giam_gia, tong_tien, ghi_chu,
     ma_don, trang_thai_giao_hang, phuong_thuc_tt, ten_nhan, sdt_nhan, email_nhan, dia_chi_nhan)
      $id_khach_hang = intval($_SESSION['khach_hang']['id'] ?? 0);
  if ($id_khach_hang <= 0) {
    $id_khach_hang = null;
  }
      VALUES
(?, 1, 'CHUA_THANH_TOAN', ?, ?, ?, ?,
     ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sqlDh);
  $stmt->bind_param(
    "iiissssssssss",
    $tam_tinh, $giam_gia, $tong_tien, $ghi_chu,
    $ma_don, $trang_thai_giao_hang, $phuong_thuc_tt,
    $ten_nhan, $sdt_nhan, $email_nhan, $dia_chi_nhan
  );
  $stmt->execute();
  $id_don_hang = $stmt->insert_id;
  $stmt->close();

  // 2) Tạo chi tiết đơn + trừ tồn kho
  $sqlCtdh = "INSERT INTO chi_tiet_don_hang (id_don_hang, id_san_pham, so_luong, don_gia, thanh_tien)
              VALUES (?, ?, ?, ?, ?)";
  $stmtC = $conn->prepare($sqlCtdh);

  $sqlTru = "UPDATE san_pham SET ton_kho = ton_kho - ? WHERE id = ? AND ton_kho >= ?";
  $stmtT = $conn->prepare($sqlTru);

  foreach ($cart as $id_sp => $sl) {
    $id_sp = (int)$id_sp;
    $sl = (int)$sl;
    $don_gia = (int)$spMap[$id_sp]['gia_ban'];
    $thanh_tien = $don_gia * $sl;

    $stmtC->bind_param("iiiii", $id_don_hang, $id_sp, $sl, $don_gia, $thanh_tien);
    $stmtC->execute();

    $stmtT->bind_param("iii", $sl, $id_sp, $sl);
    $stmtT->execute();
    if ($stmtT->affected_rows !== 1) {
      throw new Exception("Trừ tồn kho thất bại cho sản phẩm ID=$id_sp");
    }
  }

  $stmtC->close();
  $stmtT->close();

  $conn->commit();

  // Clear cart
  unset($_SESSION['cart']);

  echo "OK|id_don_hang=$id_don_hang|ma_don=$ma_don";

} catch (Throwable $e) {
  $conn->rollback();
  http_response_code(500);
  echo "Lỗi đặt hàng: " . $e->getMessage();
}
