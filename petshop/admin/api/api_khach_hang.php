<?php
require_once __DIR__ . "/../../config/ket_noi_csdl.php";
if (session_status() === PHP_SESSION_NONE) session_start();
header("Content-Type: application/json; charset=utf-8");

function out($ok, $data = []) {
  echo json_encode(array_merge(["ok"=>$ok], $data), JSON_UNESCAPED_UNICODE);
  exit;
}

if (empty($_SESSION["user"])) out(false, ["msg"=>"Chưa đăng nhập"]);

$action = $_GET["action"] ?? ($_POST["action"] ?? "list");

try {
  if ($action === "list") {
    $q = trim($_GET["q"] ?? "");
    if ($q !== "") {
      $like = "%".$q."%";
      $stmt = $conn->prepare("
        SELECT id, ho_ten, so_dien_thoai, email, dia_chi, hang_khach, diem
        FROM khach_hang
        WHERE ho_ten LIKE ? OR so_dien_thoai LIKE ? OR email LIKE ?
        ORDER BY id DESC
      ");
      $stmt->bind_param("sss", $like, $like, $like);
      $stmt->execute();
      $rs = $stmt->get_result();
    } else {
      $rs = $conn->query("
        SELECT id, ho_ten, so_dien_thoai, email, dia_chi, hang_khach, diem
        FROM khach_hang
        ORDER BY id DESC
      ");
    }
    if (!$rs) out(false, ["msg"=>"SQL lỗi: ".$conn->error]);

    $items = [];
    while($row = $rs->fetch_assoc()) $items[] = $row;
    out(true, ["items"=>$items]);
  }

  if ($action === "get") {
    $id = intval($_GET["id"] ?? 0);
    $stmt = $conn->prepare("
      SELECT id, ho_ten, so_dien_thoai, email, dia_chi, hang_khach, diem
      FROM khach_hang WHERE id=? LIMIT 1
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if (!$row) out(false, ["msg"=>"Không tìm thấy khách hàng"]);
    out(true, ["item"=>$row]);
  }

  if ($action === "save") {
    $id = intval($_POST["id"] ?? 0);
    $ho_ten = trim($_POST["ho_ten"] ?? "");
    $sdt = trim($_POST["so_dien_thoai"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $dia_chi = trim($_POST["dia_chi"] ?? "");
    $hang = trim($_POST["hang_khach"] ?? "thuong");
    $diem = intval($_POST["diem"] ?? 0);

    if ($ho_ten === "") out(false, ["msg"=>"Họ tên không được rỗng"]);
    if ($sdt === "") out(false, ["msg"=>"Số điện thoại không được rỗng"]);
    if (!preg_match("/^[0-9]{8,12}$/", $sdt)) out(false, ["msg"=>"Số điện thoại không hợp lệ (8-12 số)"]);

    // unique sdt
    if ($id > 0) {
      $stmt = $conn->prepare("SELECT id FROM khach_hang WHERE so_dien_thoai=? AND id<>? LIMIT 1");
      $stmt->bind_param("si", $sdt, $id);
    } else {
      $stmt = $conn->prepare("SELECT id FROM khach_hang WHERE so_dien_thoai=? LIMIT 1");
      $stmt->bind_param("s", $sdt);
    }
    $stmt->execute();
    if ($stmt->get_result()->fetch_assoc()) out(false, ["msg"=>"Số điện thoại đã tồn tại"]);

    if ($id > 0) {
      $stmt = $conn->prepare("
        UPDATE khach_hang
        SET ho_ten=?, so_dien_thoai=?, email=?, dia_chi=?, hang_khach=?, diem=?
        WHERE id=?
      ");
      $stmt->bind_param("sssssii", $ho_ten, $sdt, $email, $dia_chi, $hang, $diem, $id);
      if (!$stmt->execute()) out(false, ["msg"=>"Cập nhật thất bại"]);
      out(true, ["msg"=>"Đã cập nhật"]);
    } else {
      $stmt = $conn->prepare("
        INSERT INTO khach_hang(ho_ten, so_dien_thoai, email, dia_chi, hang_khach, diem)
        VALUES(?,?,?,?,?,?)
      ");
      $stmt->bind_param("sssssi", $ho_ten, $sdt, $email, $dia_chi, $hang, $diem);
      if (!$stmt->execute()) out(false, ["msg"=>"Thêm mới thất bại"]);
      out(true, ["msg"=>"Đã thêm mới", "id"=>$conn->insert_id]);
    }
  }

  if ($action === "delete") {
    $id = intval($_POST["id"] ?? 0);
    if ($id <= 0) out(false, ["msg"=>"Thiếu id"]);

    // Nếu có đơn hàng / lịch hẹn thì không xóa cứng → chặn
    $stmt = $conn->prepare("SELECT COUNT(*) c FROM don_hang WHERE id_khach_hang=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $c1 = intval($stmt->get_result()->fetch_assoc()["c"] ?? 0);

    $stmt = $conn->prepare("SELECT COUNT(*) c FROM lich_hen WHERE id_khach_hang=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $c2 = intval($stmt->get_result()->fetch_assoc()["c"] ?? 0);

    if ($c1 > 0 || $c2 > 0) {
      out(false, ["msg"=>"Khách hàng đã phát sinh đơn hàng/lịch hẹn → không thể xóa."]);
    }

    $stmt = $conn->prepare("DELETE FROM khach_hang WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    out(true, ["msg"=>"Đã xóa khách hàng"]);
  }

  // lịch sử mua
  if ($action === "lich_su_mua") {
    $id = intval($_GET["id"] ?? 0);
    $stmt = $conn->prepare("
      SELECT id, ngay_tao, trang_thai, tong_tien
      FROM don_hang
      WHERE id_khach_hang=?
      ORDER BY id DESC
      LIMIT 50
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $rs = $stmt->get_result();
    $items = [];
    while($row = $rs->fetch_assoc()) $items[] = $row;
    out(true, ["items"=>$items]);
  }

  // lịch sử dịch vụ
  if ($action === "lich_su_dich_vu") {
    $id = intval($_GET["id"] ?? 0);
    $stmt = $conn->prepare("
      SELECT lh.id, lh.thoi_gian_hen, lh.trang_thai, dv.ten_dich_vu
      FROM lich_hen lh
      LEFT JOIN dich_vu dv ON dv.id = lh.id_dich_vu
      WHERE lh.id_khach_hang=?
      ORDER BY lh.id DESC
      LIMIT 50
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $rs = $stmt->get_result();
    $items = [];
    while($row = $rs->fetch_assoc()) $items[] = $row;
    out(true, ["items"=>$items]);
  }

  out(false, ["msg"=>"Action không hỗ trợ"]);
} catch (Throwable $e) {
  out(false, ["msg"=>"Lỗi: ".$e->getMessage()]);
}
