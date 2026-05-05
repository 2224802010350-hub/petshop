<?php
require_once __DIR__ . "/../config/ket_noi_csdl.php";

$loai = $_GET['loai'] ?? 'CHO';
$stmt = $pdo->prepare("
  SELECT sp.id, sp.ten_san_pham, sp.gia_ban, sp.hinh_anh
  FROM san_pham sp
  JOIN danh_muc dm ON dm.id = sp.id_danh_muc
  WHERE sp.trang_thai=1 AND dm.loai=?
  ORDER BY sp.id DESC
");
$stmt->execute([$loai]);
header("Content-Type: application/json; charset=utf-8");
echo json_encode($stmt->fetchAll(), JSON_UNESCAPED_UNICODE);
