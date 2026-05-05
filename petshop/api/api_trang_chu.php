<?php
require_once __DIR__ . "/../config/ket_noi_csdl.php";
header("Content-Type: application/json; charset=utf-8");

$base = "/petshop/petshop/assets/uploads/products/";
$row["image_url"] = ($file && $file !== "0") ? ($base . $file) : null;

$rs = $conn->query("
  SELECT id, ten_san_pham, mo_ta, gia_ban, ton_kho, hinh_anh
  FROM san_pham
  WHERE trang_thai = 1
  ORDER BY id DESC
  LIMIT 12
");

if (!$rs) {
  http_response_code(500);
  echo json_encode(["ok"=>false,"msg"=>"SQL lỗi: ".$conn->error], JSON_UNESCAPED_UNICODE);
  exit;
}

$items = [];
while ($row = $rs->fetch_assoc()) {
  $file = $row["hinh_anh"] ?? "";
  $row["image_url"] = ($file && $file !== "0") ? ($base . $file) : null;
  $items[] = $row;
}

echo json_encode(["ok"=>true,"items"=>$items], JSON_UNESCAPED_UNICODE);
