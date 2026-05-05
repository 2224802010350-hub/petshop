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
    $rs = $conn->query("
      SELECT 
        dm.id,
        dm.id_cha,
        dm.ten_danh_muc,
        dm.loai,
        dm.trang_thai,
        cha.ten_danh_muc AS ten_cha
      FROM danh_muc dm
      LEFT JOIN danh_muc cha ON cha.id = dm.id_cha
      ORDER BY 
        CASE WHEN dm.id_cha IS NULL THEN dm.id ELSE dm.id_cha END ASC,
        dm.id_cha IS NOT NULL ASC,
        dm.id ASC
    ");

    if (!$rs) out(false, ["msg"=>"SQL lỗi: ".$conn->error]);

    $items = [];
    while($row = $rs->fetch_assoc()) $items[] = $row;

    out(true, ["items"=>$items]);
  }

  if ($action === "parents") {
    $rs = $conn->query("
      SELECT id, ten_danh_muc
      FROM danh_muc
      WHERE id_cha IS NULL
      ORDER BY id ASC
    ");

    if (!$rs) out(false, ["msg"=>"SQL lỗi: ".$conn->error]);

    $items = [];
    while($row = $rs->fetch_assoc()) $items[] = $row;

    out(true, ["items"=>$items]);
  }

  if ($action === "save") {
    $id = intval($_POST["id"] ?? 0);
    $id_cha_raw = $_POST["id_cha"] ?? "";
    $id_cha = ($id_cha_raw === "" || $id_cha_raw === "0") ? null : intval($id_cha_raw);

    $ten = trim($_POST["ten_danh_muc"] ?? "");
    $loai = trim($_POST["loai"] ?? "");
    $tt = isset($_POST["trang_thai"]) ? intval($_POST["trang_thai"]) : 1;

    if ($ten === "") out(false, ["msg"=>"Tên danh mục không được rỗng"]);

    if ($id > 0 && $id_cha !== null && $id === $id_cha) {
      out(false, ["msg"=>"Danh mục cha không được trùng chính nó"]);
    }

    if ($id > 0) {
      $stmt = $conn->prepare("
        UPDATE danh_muc
        SET id_cha=?, ten_danh_muc=?, loai=?, trang_thai=?
        WHERE id=?
      ");
      $stmt->bind_param("issii", $id_cha, $ten, $loai, $tt, $id);

      if (!$stmt->execute()) out(false, ["msg"=>"Cập nhật thất bại: ".$stmt->error]);

      out(true, ["msg"=>"Đã cập nhật danh mục"]);
    } else {
      $stmt = $conn->prepare("
        INSERT INTO danh_muc(id_cha, ten_danh_muc, loai, trang_thai)
        VALUES(?,?,?,?)
      ");
      $stmt->bind_param("issi", $id_cha, $ten, $loai, $tt);

      if (!$stmt->execute()) out(false, ["msg"=>"Thêm mới thất bại: ".$stmt->error]);

      out(true, ["msg"=>"Đã thêm danh mục"]);
    }
  }

  if ($action === "delete") {
    $id = intval($_POST["id"] ?? 0);
    if ($id <= 0) out(false, ["msg"=>"Thiếu id"]);

    $stmt = $conn->prepare("DELETE FROM danh_muc WHERE id=?");
    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
      out(false, ["msg"=>"Không xóa được. Có thể danh mục đang có sản phẩm hoặc danh mục con."]);
    }

    out(true, ["msg"=>"Đã xóa danh mục"]);
  }

  out(false, ["msg"=>"Action không hỗ trợ"]);

} catch (Throwable $e) {
  out(false, ["msg"=>"Lỗi: ".$e->getMessage()]);
}