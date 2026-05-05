<?php
// PETSHOP/api/api_dang_xuat.php
if (session_status() === PHP_SESSION_NONE) session_start();
session_destroy();

header("Content-Type: application/json; charset=utf-8");
echo json_encode([
  "ok" => true,
  "redirect" => "/petshop/petshop/trang_khach/trang_chu.php"
]);
