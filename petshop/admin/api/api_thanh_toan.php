<?php
require_once __DIR__ . "/../../config/ket_noi_csdl.php";
require_once __DIR__ . "/lib_mail.php";
if (session_status() === PHP_SESSION_NONE) session_start();
header("Content-Type: application/json; charset=utf-8");

function out($ok, $data = []) {
  echo json_encode(array_merge(["ok"=>$ok], $data), JSON_UNESCAPED_UNICODE);
  exit;
}
if (empty($_SESSION["user"])) out(false, ["msg"=>"Chưa đăng nhập"]);

$action = $_POST["action"] ?? ($_GET["action"] ?? "");

try {

  // ✅ 1) Cập nhật phương thức thanh toán (COD/ONLINE)
  if ($action === "set_method") {
    $id_don = intval($_POST["id_don_hang"] ?? 0);
    $method = strtoupper(trim($_POST["phuong_thuc_tt"] ?? "COD")); // COD|ONLINE
    if ($id_don <= 0) out(false, ["msg"=>"Thiếu id_don_hang"]);
    if (!in_array($method, ["COD","ONLINE"], true)) out(false, ["msg"=>"Phương thức không hợp lệ"]);

    // Không cho đổi nếu đã thanh toán
    $stmt = $conn->prepare("SELECT trang_thai_tt FROM don_hang WHERE id=? LIMIT 1");
    $stmt->bind_param("i", $id_don);
    $stmt->execute();
    $don = $stmt->get_result()->fetch_assoc();
    if (!$don) out(false, ["msg"=>"Không tìm thấy đơn"]);
    if (($don["trang_thai_tt"] ?? "") === "DA_THANH_TOAN") {
      out(false, ["msg"=>"Đơn đã thanh toán, không đổi phương thức"]);
    }

    $stmt = $conn->prepare("UPDATE don_hang SET phuong_thuc_tt=?, trang_thai_tt='CHUA_THANH_TOAN' WHERE id=?");
    $stmt->bind_param("si", $method, $id_don);
    $stmt->execute();

    out(true, ["msg"=>"Đã cập nhật phương thức: ".$method, "phuong_thuc_tt"=>$method, "trang_thai_tt"=>"CHUA_THANH_TOAN"]);
  }

  // ✅ 2) Xác nhận thanh toán COD (cập nhật DB = đã thanh toán)
  if ($action === "pay_cod") {
    $id_don = intval($_POST["id_don_hang"] ?? 0);
    if ($id_don<=0) out(false, ["msg"=>"Thiếu id_don_hang"]);

    $stmt = $conn->prepare("SELECT id, tong_tien, COALESCE(email_khach,'') email_khach, trang_thai_tt FROM don_hang WHERE id=?");
    $stmt->bind_param("i", $id_don);
    $stmt->execute();
    $don = $stmt->get_result()->fetch_assoc();
    if (!$don) out(false, ["msg"=>"Không tìm thấy đơn"]);
    if (($don["trang_thai_tt"] ?? "") === "DA_THANH_TOAN") out(false, ["msg"=>"Đơn đã thanh toán"]);

    $conn->begin_transaction();

    $phuong_thuc = "COD";
    $so_tien = floatval($don["tong_tien"]);
    $ma = "COD-".$id_don."-".time();

    $stmt = $conn->prepare("INSERT INTO thanh_toan(id_don_hang, phuong_thuc, so_tien, thoi_gian, ma_giao_dich) VALUES(?,?,?,NOW(),?)");
    $stmt->bind_param("isds", $id_don, $phuong_thuc, $so_tien, $ma);
    $stmt->execute();

    $stmt = $conn->prepare("UPDATE don_hang SET phuong_thuc_tt='COD', trang_thai_tt='DA_THANH_TOAN' WHERE id=?");
    $stmt->bind_param("i", $id_don);
    $stmt->execute();

    $conn->commit();

    if (!empty($don["email_khach"])) {
      $subject = "Xác nhận thanh toán đơn #".$id_don;
      $body = "
        <h3>PetShop - Xác nhận thanh toán</h3>
        <p>Đơn hàng <b>#{$id_don}</b> đã được xác nhận thanh toán.</p>
        <p>Số tiền: <b>".number_format($so_tien,0,',','.')." ₫</b></p>
        <p>Xem hóa đơn: <a href='/petshop/petshop/admin/hoa_don.php?id={$id_don}'>Hóa đơn #{$id_don}</a></p>
      ";
      send_mail($don["email_khach"], $subject, $body);
    }

    out(true, ["msg"=>"Đã xác nhận thanh toán COD", "trang_thai_tt"=>"DA_THANH_TOAN", "phuong_thuc_tt"=>"COD"]);
  }

  // ✅ 3) Tạo link thanh toán ONLINE (mock)
  if ($action === "create_online_payment") {
    $id_don = intval($_POST["id_don_hang"] ?? 0);
    if ($id_don<=0) out(false, ["msg"=>"Thiếu id_don_hang"]);

    // Đảm bảo đơn set ONLINE (nếu chưa)
    $stmt = $conn->prepare("UPDATE don_hang SET phuong_thuc_tt='ONLINE', trang_thai_tt='CHUA_THANH_TOAN' WHERE id=? AND trang_thai_tt<>'DA_THANH_TOAN'");
    $stmt->bind_param("i", $id_don);
    $stmt->execute();

    $pay_url = "/petshop/petshop/payment/mock_gateway.php?id=".$id_don;
    out(true, ["pay_url"=>$pay_url]);
  }

  // ✅ 4) callback mock: online thành công
  if ($action === "online_success") {
    $id_don = intval($_POST["id_don_hang"] ?? 0);
    if ($id_don<=0) out(false, ["msg"=>"Thiếu id_don_hang"]);

    $stmt = $conn->prepare("SELECT id, tong_tien, COALESCE(email_khach,'') email_khach, trang_thai_tt FROM don_hang WHERE id=?");
    $stmt->bind_param("i", $id_don);
    $stmt->execute();
    $don = $stmt->get_result()->fetch_assoc();
    if (!$don) out(false, ["msg"=>"Không tìm thấy đơn"]);
    if (($don["trang_thai_tt"] ?? "") === "DA_THANH_TOAN") out(true, ["msg"=>"Đơn đã thanh toán rồi"]);

    $conn->begin_transaction();

    $phuong_thuc = "ONLINE";
    $so_tien = floatval($don["tong_tien"]);
    $ma = "ONLINE-".$id_don."-".time();

    $stmt = $conn->prepare("INSERT INTO thanh_toan(id_don_hang, phuong_thuc, so_tien, thoi_gian, ma_giao_dich) VALUES(?,?,?,NOW(),?)");
    $stmt->bind_param("isds", $id_don, $phuong_thuc, $so_tien, $ma);
    $stmt->execute();

    $stmt = $conn->prepare("UPDATE don_hang SET phuong_thuc_tt='ONLINE', trang_thai_tt='DA_THANH_TOAN' WHERE id=?");
    $stmt->bind_param("i", $id_don);
    $stmt->execute();

    $conn->commit();

    if (!empty($don["email_khach"])) {
      $subject = "Thanh toán online thành công - đơn #".$id_don;
      $body = "
        <h3>PetShop - Thanh toán online thành công</h3>
        <p>Đơn hàng <b>#{$id_don}</b> đã thanh toán online thành công.</p>
        <p>Mã giao dịch: <b>{$ma}</b></p>
        <p>Số tiền: <b>".number_format($so_tien,0,',','.')." ₫</b></p>
        <p>Xem hóa đơn: <a href='/petshop/petshop/admin/hoa_don.php?id={$id_don}'>Hóa đơn #{$id_don}</a></p>
      ";
      send_mail($don["email_khach"], $subject, $body);
    }

    out(true, ["msg"=>"Online success", "trang_thai_tt"=>"DA_THANH_TOAN", "phuong_thuc_tt"=>"ONLINE"]);
  }

  out(false, ["msg"=>"Action không hỗ trợ"]);
} catch (Throwable $e) {
  out(false, ["msg"=>"Lỗi: ".$e->getMessage()]);
}
