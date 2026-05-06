<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . "/../config/ket_noi_csdl.php";

header("Content-Type: application/json; charset=utf-8");

function out($ok, $data = []) {
  echo json_encode(array_merge(["ok"=>$ok], $data), JSON_UNESCAPED_UNICODE);
  exit;
}

$action = $_POST["action"] ?? $_GET["action"] ?? "list";
$_SESSION["cart"] = $_SESSION["cart"] ?? [];

if ($action === "add") {
  $id = (int)($_POST["id_san_pham"] ?? 0);
  $qty = max(1, (int)($_POST["so_luong"] ?? 1));

  if ($id <= 0) out(false, ["msg"=>"Thiếu sản phẩm"]);

  $stmt = $conn->prepare("SELECT id, ton_kho FROM san_pham WHERE id=? AND trang_thai=1 LIMIT 1");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $sp = $stmt->get_result()->fetch_assoc();

  if (!$sp) out(false, ["msg"=>"Sản phẩm không tồn tại"]);
  if ((int)$sp["ton_kho"] <= 0) out(false, ["msg"=>"Sản phẩm tạm hết hàng"]);

  $_SESSION["cart"][$id] = ($_SESSION["cart"][$id] ?? 0) + $qty;
  out(true, ["msg"=>"Đã thêm vào giỏ hàng"]);
}

if ($action === "update") {
  $id = (int)($_POST["id_san_pham"] ?? 0);
  $qty = (int)($_POST["so_luong"] ?? 1);

  if ($id <= 0) out(false, ["msg"=>"Thiếu sản phẩm"]);

  if ($qty <= 0) unset($_SESSION["cart"][$id]);
  else $_SESSION["cart"][$id] = $qty;

  out(true, ["msg"=>"Đã cập nhật giỏ hàng"]);
}

if ($action === "delete") {
  $id = (int)($_POST["id_san_pham"] ?? 0);
  unset($_SESSION["cart"][$id]);
  out(true, ["msg"=>"Đã xóa sản phẩm"]);
}

if ($action === "clear") {
  $_SESSION["cart"] = [];
  out(true, ["msg"=>"Đã xóa giỏ hàng"]);
}

if ($action === "checkout") {
  $ho_ten = trim($_POST["ho_ten"] ?? "");
  $sdt = trim($_POST["so_dien_thoai"] ?? "");
  $email = trim($_POST["email"] ?? "");
  $dia_chi = trim($_POST["dia_chi"] ?? "");
  $phuong_thuc_tt = trim($_POST["phuong_thuc_tt"] ?? "COD");

  if ($ho_ten === "" || $sdt === "" || $dia_chi === "") {
    out(false, ["msg"=>"Vui lòng nhập họ tên, số điện thoại và địa chỉ"]);
  }

  if (empty($_SESSION["cart"])) {
    out(false, ["msg"=>"Giỏ hàng trống"]);
  }

  $conn->begin_transaction();

  try {
    $stmt = $conn->prepare("SELECT id FROM khach_hang WHERE so_dien_thoai = ? LIMIT 1");
    $stmt->bind_param("s", $sdt);
    $stmt->execute();
    $kh = $stmt->get_result()->fetch_assoc();

    if ($kh) {
      $id_khach = (int)$kh["id"];

      $stmt = $conn->prepare("
        UPDATE khach_hang
        SET ho_ten = ?, email = ?, dia_chi = ?
        WHERE id = ?
      ");
      $stmt->bind_param("sssi", $ho_ten, $email, $dia_chi, $id_khach);
      $stmt->execute();
    } else {
      $stmt = $conn->prepare("
        INSERT INTO khach_hang(ho_ten, so_dien_thoai, email, dia_chi)
        VALUES (?, ?, ?, ?)
      ");
      $stmt->bind_param("ssss", $ho_ten, $sdt, $email, $dia_chi);
      $stmt->execute();
      $id_khach = $conn->insert_id;
    }

    $tam_tinh = 0;
    $cartItems = [];

    foreach ($_SESSION["cart"] as $id_sp => $qty) {
      $id_sp = (int)$id_sp;
      $qty = (int)$qty;

      $stmt = $conn->prepare("
        SELECT id, ten_san_pham, gia_ban, ton_kho
        FROM san_pham
        WHERE id = ? AND trang_thai = 1
        LIMIT 1
        FOR UPDATE
      ");
      $stmt->bind_param("i", $id_sp);
      $stmt->execute();
      $sp = $stmt->get_result()->fetch_assoc();

      if (!$sp) throw new Exception("Sản phẩm không tồn tại");
      if ((int)$sp["ton_kho"] <= 0) throw new Exception($sp["ten_san_pham"] . " đang tạm hết hàng");
      if ((int)$sp["ton_kho"] < $qty) throw new Exception($sp["ten_san_pham"] . " chỉ còn " . $sp["ton_kho"] . " sản phẩm");

      $don_gia = (int)$sp["gia_ban"];
      $tam_tinh += $don_gia * $qty;

      $cartItems[] = [
        "id" => $id_sp,
        "qty" => $qty,
        "don_gia" => $don_gia
      ];
    }

    $giam_gia = 0;
    $tong_tien = $tam_tinh;
    $id_nhan_vien = 1;

    $stmt = $conn->prepare("
      INSERT INTO don_hang(
        id_khach_hang,
        id_nhan_vien,
        ngay_tao,
        tam_tinh,
        giam_gia,
        tong_tien,
        trang_thai_giao_hang,
        phuong_thuc_tt,
        trang_thai,
        email_khach
      )
      VALUES (?, ?, NOW(), ?, ?, ?, 'DA_XAC_NHAN', ?, 'DA_THANH_TOAN', ?)
    ");

    if (!$stmt) {
      throw new Exception("Lỗi SQL tạo đơn hàng: " . $conn->error);
    }

    $stmt->bind_param(
      "iidddss",
      $id_khach,
      $id_nhan_vien,
      $tam_tinh,
      $giam_gia,
      $tong_tien,
      $phuong_thuc_tt,
      $email
    );

    if (!$stmt->execute()) {
      throw new Exception("Không tạo được đơn hàng: " . $stmt->error);
    }

    $id_don = $conn->insert_id;

    foreach ($cartItems as $it) {
      $stmt = $conn->prepare("
        INSERT INTO chi_tiet_don_hang(id_don_hang, id_san_pham, so_luong, don_gia)
        VALUES (?, ?, ?, ?)
      ");

      if (!$stmt) {
        throw new Exception("Lỗi SQL chi tiết đơn hàng: " . $conn->error);
      }

      $stmt->bind_param("iiid", $id_don, $it["id"], $it["qty"], $it["don_gia"]);
      $stmt->execute();

      $stmt = $conn->prepare("
        UPDATE san_pham
        SET ton_kho = ton_kho - ?
        WHERE id = ? AND ton_kho >= ?
      ");
      $stmt->bind_param("iii", $it["qty"], $it["id"], $it["qty"]);
      $stmt->execute();

      if ($stmt->affected_rows <= 0) {
        throw new Exception("Không trừ được tồn kho sản phẩm ID " . $it["id"]);
      }
    }

    $diem_cong = (int)floor($tong_tien / 10000);

    $stmt = $conn->prepare("SELECT id, diem FROM khach_hang_than_thiet WHERE khach_hang_id = ? LIMIT 1");
    $stmt->bind_param("i", $id_khach);
    $stmt->execute();
    $old = $stmt->get_result()->fetch_assoc();

    if ($old) {
      $diem_moi = (int)$old["diem"] + $diem_cong;

      $hang_moi = "Đồng";
      if ($diem_moi >= 100000) $hang_moi = "Kim cương";
      elseif ($diem_moi >= 10000) $hang_moi = "Vàng";
      elseif ($diem_moi >= 1000) $hang_moi = "Bạc";

      $stmt = $conn->prepare("
        UPDATE khach_hang_than_thiet
        SET diem = ?, hang_thanh_vien = ?
        WHERE khach_hang_id = ?
      ");
      $stmt->bind_param("isi", $diem_moi, $hang_moi, $id_khach);
      $stmt->execute();
    } else {
      $hang = "Đồng";
      if ($diem_cong >= 100000) $hang = "Kim cương";
      elseif ($diem_cong >= 10000) $hang = "Vàng";
      elseif ($diem_cong >= 1000) $hang = "Bạc";

      $stmt = $conn->prepare("
        INSERT INTO khach_hang_than_thiet(khach_hang_id, diem, hang_thanh_vien)
        VALUES (?, ?, ?)
      ");
      $stmt->bind_param("iis", $id_khach, $diem_cong, $hang);
      $stmt->execute();
    }

    $_SESSION["cart"] = [];
    $conn->commit();

    out(true, [
      "msg" => "Thanh toán thành công. Đã cộng {$diem_cong} điểm thân thiết.",
      "id_don_hang" => $id_don
    ]);

  } catch (Throwable $e) {
    $conn->rollback();
    out(false, ["msg"=>$e->getMessage()]);
  }
}

out(false, ["msg"=>"Action không hợp lệ"]);