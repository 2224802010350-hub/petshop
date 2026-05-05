<?php
require_once __DIR__ . "/../config/ket_noi_csdl.php";
$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("
  SELECT sp.*, dm.ten_danh_muc, dm.loai
  FROM san_pham sp
  JOIN danh_muc dm ON dm.id = sp.id_danh_muc
  WHERE sp.id=?
  LIMIT 1
");
$stmt->execute([$id]);
$row = $stmt->fetch() ?: [];
header("Content-Type: application/json; charset=utf-8");
echo json_encode($row, JSON_UNESCAPED_UNICODE);
