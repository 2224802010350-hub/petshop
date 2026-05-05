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

$action = $_GET["action"] ?? ($_POST["action"] ?? "admin_list");

if ($action === "admin_list" || $action === "list") {
  $rs = $conn->query("
  SELECT 
    sp.*,
    dm.ten_danh_muc,
    cha.ten_danh_muc AS ten_danh_muc_cha,
    ncc.id AS id_ncc
  FROM san_pham sp
  LEFT JOIN danh_muc dm ON dm.id = sp.id_danh_muc
  LEFT JOIN danh_muc cha ON cha.id = dm.id_cha
  LEFT JOIN nha_cung_cap ncc ON ncc.id = sp.id_nha_cung_cap
  ORDER BY sp.id DESC
");

  if (!$rs) out(false, ["msg" => "SQL lỗi: " . $conn->error]);

  $items = [];
  while ($row = $rs->fetch_assoc()) {
    $items[] = $row;
  }

  out(true, ["items" => $items]);
}

if ($action === "save") {
  $id = intval($_POST["id"] ?? 0);
  $id_danh_muc = intval($_POST["id_danh_muc"] ?? 0);

  $ncc_raw = $_POST["id_nha_cung_cap"] ?? "";
  $id_nha_cung_cap = ($ncc_raw === "" || intval($ncc_raw) <= 0) ? null : intval($ncc_raw);

  $ma_sku = trim($_POST["ma_sku"] ?? "");
  $ten_san_pham = trim($_POST["ten_san_pham"] ?? "");
  $mo_ta = trim($_POST["mo_ta"] ?? "");

  $gia_ban = intval(preg_replace('/[^\d]/', '', $_POST["gia_ban"] ?? "0"));
  $gia_nhap = intval(preg_replace('/[^\d]/', '', $_POST["gia_nhap"] ?? "0"));

  $ton_kho = intval($_POST["ton_kho"] ?? 0);
  $trang_thai = intval($_POST["trang_thai"] ?? 1);

  if ($id_danh_muc <= 0) out(false, ["msg" => "Vui lòng chọn danh mục"]);
  if ($ma_sku === "") out(false, ["msg" => "Vui lòng nhập SKU"]);
  if ($ten_san_pham === "") out(false, ["msg" => "Vui lòng nhập tên sản phẩm"]);
  if ($gia_ban <= 0) out(false, ["msg" => "Vui lòng nhập giá bán"]);

  if ($id > 0) {
    $stmt = $conn->prepare("SELECT id FROM san_pham WHERE ma_sku=? AND id<>? LIMIT 1");
    $stmt->bind_param("si", $ma_sku, $id);
  } else {
    $stmt = $conn->prepare("SELECT id FROM san_pham WHERE ma_sku=? LIMIT 1");
    $stmt->bind_param("s", $ma_sku);
  }

  $stmt->execute();
  
  if ($stmt->get_result()->fetch_assoc()) {
    out(false, ["msg" => "SKU đã tồn tại"]);
  }

  $fileName = null;

  if (!empty($_FILES["hinh_anh"]["name"])) {
    $uploadDir = __DIR__ . "/../../assets/uploads/products/";

    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }

    $file = $_FILES["hinh_anh"];

    if ($file["error"] !== UPLOAD_ERR_OK) {
      out(false, ["msg" => "Lỗi upload ảnh"]);
    }

    if ($file["size"] > 2 * 1024 * 1024) {
      out(false, ["msg" => "Ảnh không được quá 2MB"]);
    }

    $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $allow = ["jpg", "jpeg", "png", "webp"];

    if (!in_array($ext, $allow)) {
      out(false, ["msg" => "Chỉ cho phép JPG, PNG, WEBP"]);
    }

    $fileName = time() . "_" . bin2hex(random_bytes(4)) . "." . $ext;

    if (!move_uploaded_file($file["tmp_name"], $uploadDir . $fileName)) {
      out(false, ["msg" => "Không lưu được ảnh"]);
    }
  }

  if ($id > 0) {
    if ($fileName !== null) {
      $stmt = $conn->prepare("
        UPDATE san_pham SET
          id_danh_muc=?,
          id_nha_cung_cap=?,
          ma_sku=?,
          ten_san_pham=?,
          gia_ban=?,
          gia_nhap=?,
          ton_kho=?,
          trang_thai=?,
          hinh_anh=?,
          mo_ta=?
        WHERE id=?
      ");

      $stmt->bind_param(
        "iissiiiissi",
        $id_danh_muc,
        $id_nha_cung_cap,
        $ma_sku,
        $ten_san_pham,
        $gia_ban,
        $gia_nhap,
        $ton_kho,
        $trang_thai,
        $fileName,
        $mo_ta,
        $id
      );
    } else {
      $stmt = $conn->prepare("
        UPDATE san_pham SET
          id_danh_muc=?,
          id_nha_cung_cap=?,
          ma_sku=?,
          ten_san_pham=?,
          gia_ban=?,
          gia_nhap=?,
          ton_kho=?,
          trang_thai=?,
          mo_ta=?
        WHERE id=?
      ");

      $stmt->bind_param(
        "iissiiiisi",
        $id_danh_muc,
        $id_nha_cung_cap,
        $ma_sku,
        $ten_san_pham,
        $gia_ban,
        $gia_nhap,
        $ton_kho,
        $trang_thai,
        $mo_ta,
        $id
      );
    }

    if (!$stmt->execute()) {
      out(false, ["msg" => "Cập nhật thất bại: " . $stmt->error]);
    }

    out(true, ["msg" => "Đã cập nhật sản phẩm"]);
  }

  $stmt = $conn->prepare("
    INSERT INTO san_pham(
      id_danh_muc,
      id_nha_cung_cap,
      ma_sku,
      ten_san_pham,
      gia_ban,
      gia_nhap,
      ton_kho,
      trang_thai,
      hinh_anh,
      mo_ta,
      ngay_tao
    )
    VALUES(?,?,?,?,?,?,?,?,?,?,NOW())
  ");

  $stmt->bind_param(
    "iissiiiiss",
    $id_danh_muc,
    $id_nha_cung_cap,
    $ma_sku,
    $ten_san_pham,
    $gia_ban,
    $gia_nhap,
    $ton_kho,
    $trang_thai,
    $fileName,
    $mo_ta
  );

  if (!$stmt->execute()) {
    out(false, ["msg" => "Thêm sản phẩm thất bại: " . $stmt->error]);
  }

  out(true, ["msg" => "Đã thêm sản phẩm"]);
}

if ($action === "delete") {
  $id = intval($_POST["id"] ?? 0);

  if ($id <= 0) out(false, ["msg" => "Thiếu ID sản phẩm"]);

  $stmt = $conn->prepare("DELETE FROM san_pham WHERE id=?");
  $stmt->bind_param("i", $id);

  if (!$stmt->execute()) {
    out(false, ["msg" => "Không xóa được sản phẩm. Có thể sản phẩm đã có trong đơn hàng."]);
  }

  out(true, ["msg" => "Đã xóa sản phẩm"]);
}

out(false, ["msg" => "Action not found"]);