<?php
require_once __DIR__ . "/../config/ket_noi_csdl.php";
require_once __DIR__ . "/../config/ham_chung.php";

if (session_status() === PHP_SESSION_NONE) session_start();
header("Content-Type: application/json; charset=utf-8");

function out($ok, $data = []) {
  echo json_encode(array_merge(["ok" => $ok], $data), JSON_UNESCAPED_UNICODE);
  exit;
}

if (empty($_SESSION["user"])) {
  out(false, ["msg" => "Chưa đăng nhập"]);
}

$action = $_GET["action"] ?? ($_POST["action"] ?? "list");

try {

  if ($action === "list") {
    $q = trim($_GET["q"] ?? "");

    $sql = "
      SELECT 
        kh.id,
        kh.ho_ten,
        kh.so_dien_thoai,
        kh.email,
        kh.dia_chi,
        kh.hang_khach,
        kh.ngay_tao,

        COALESCE(khtt.diem, 0) AS diem,
        COALESCE(khtt.hang_thanh_vien, 'Đồng') AS hang_thanh_vien

      FROM khach_hang kh
      LEFT JOIN khach_hang_than_thiet khtt 
        ON khtt.khach_hang_id = kh.id
    ";

    if ($q !== "") {
      $sql .= "
        WHERE kh.ho_ten LIKE ?
           OR kh.so_dien_thoai LIKE ?
           OR kh.email LIKE ?
      ";
    }

    $sql .= " ORDER BY kh.id DESC";

    if ($q !== "") {
      $like = "%" . $q . "%";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sss", $like, $like, $like);
      $stmt->execute();
      $rs = $stmt->get_result();
    } else {
      $rs = $conn->query($sql);
    }

    if (!$rs) {
      out(false, ["msg" => "SQL lỗi: " . $conn->error]);
    }

    $items = [];
    while ($row = $rs->fetch_assoc()) {
      $items[] = $row;
    }

    out(true, ["items" => $items]);
  }

  if ($action === "save") {
    $id = intval($_POST["id"] ?? 0);
    $ho_ten = trim($_POST["ho_ten"] ?? "");
    $so_dien_thoai = trim($_POST["so_dien_thoai"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $dia_chi = trim($_POST["dia_chi"] ?? "");
    $hang_khach = trim($_POST["hang_khach"] ?? "thuong");

    if ($ho_ten === "" || $so_dien_thoai === "") {
      out(false, ["msg" => "Vui lòng nhập họ tên và số điện thoại"]);
    }

    $stmt = $conn->prepare("
      SELECT id 
      FROM khach_hang 
      WHERE so_dien_thoai = ? AND id <> ?
      LIMIT 1
    ");
    $stmt->bind_param("si", $so_dien_thoai, $id);
    $stmt->execute();
    $old = $stmt->get_result()->fetch_assoc();

    if ($old) {
      out(false, ["msg" => "Số điện thoại đã tồn tại"]);
    }

    if ($id > 0) {
      $stmt = $conn->prepare("
        UPDATE khach_hang
        SET ho_ten = ?, so_dien_thoai = ?, email = ?, dia_chi = ?, hang_khach = ?
        WHERE id = ?
      ");
      $stmt->bind_param("sssssi", $ho_ten, $so_dien_thoai, $email, $dia_chi, $hang_khach, $id);

      if (!$stmt->execute()) {
        out(false, ["msg" => "Không sửa được khách hàng: " . $stmt->error]);
      }

      out(true, ["msg" => "Đã cập nhật khách hàng"]);
    } else {
      $stmt = $conn->prepare("
        INSERT INTO khach_hang(ho_ten, so_dien_thoai, email, dia_chi, hang_khach)
        VALUES (?, ?, ?, ?, ?)
      ");
      $stmt->bind_param("sssss", $ho_ten, $so_dien_thoai, $email, $dia_chi, $hang_khach);

      if (!$stmt->execute()) {
        out(false, ["msg" => "Không thêm được khách hàng: " . $stmt->error]);
      }

      out(true, ["msg" => "Đã thêm khách hàng"]);
    }
  }

  if ($action === "delete") {
    $id = intval($_POST["id"] ?? 0);

    if ($id <= 0) {
      out(false, ["msg" => "Thiếu ID khách hàng"]);
    }

    $stmt = $conn->prepare("DELETE FROM khach_hang WHERE id = ?");
    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
      out(false, ["msg" => "Không xóa được. Khách hàng có thể đã có đơn hàng hoặc lịch hẹn."]);
    }

    out(true, ["msg" => "Đã xóa khách hàng"]);
  }

  if ($action === "lich_su_mua") {
    $id = intval($_GET["id"] ?? 0);

    $stmt = $conn->prepare("
      SELECT id, ma_don, ngay_tao, trang_thai, tong_tien
      FROM don_hang
      WHERE id_khach_hang = ?
      ORDER BY id DESC
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $rs = $stmt->get_result();
    $items = [];

    while ($row = $rs->fetch_assoc()) {
      $items[] = $row;
    }

    out(true, ["items" => $items]);
  }

  if ($action === "lich_su_dich_vu") {
    $id = intval($_GET["id"] ?? 0);

    $stmt = $conn->prepare("
      SELECT lh.id, dv.ten_dich_vu, lh.thoi_gian_hen, lh.trang_thai
      FROM lich_hen lh
      LEFT JOIN dich_vu dv ON dv.id = lh.dich_vu_id
      WHERE lh.khach_hang_id = ?
      ORDER BY lh.id DESC
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $rs = $stmt->get_result();
    $items = [];

    while ($row = $rs->fetch_assoc()) {
      $items[] = $row;
    }

    out(true, ["items" => $items]);
  }

  out(false, ["msg" => "Action không hỗ trợ"]);

} catch (Throwable $e) {
  out(false, ["msg" => "Lỗi: " . $e->getMessage()]);
}