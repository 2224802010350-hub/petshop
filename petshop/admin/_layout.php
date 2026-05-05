<?php
require_once __DIR__ . "/../config/ham_chung.php";
require_once __DIR__ . "/../config/ket_noi_csdl.php";
require_login();
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/assets/css/site.css">
  <title>Admin - PetShop</title>
</head>
<body>
<header class="topbar">
  <div class="container topbar__inner">
    <div><b>ADMIN</b> | Xin chào: <?php echo htmlspecialchars($_SESSION['user']['ho_ten']); ?> (<?php echo $_SESSION['user']['vai_tro']; ?>)</div>
    <div><a style="color:#fff;text-decoration:none" href="/admin/dang_xuat.php">Đăng xuất</a></div>
  </div>
</header>

<nav class="navbar">
  <div class="container navbar__inner">
    <a class="logo" href="/admin/dashboard.php">PETSHOP ADMIN</a>
    <ul class="menu" style="display:flex">
      <li><a href="/admin/dashboard.php">Dashboard</a></li>
      <li><a href="/admin/danh_muc.php">Danh mục</a></li>
      <li><a href="/admin/san_pham.php">Sản phẩm</a></li>
      <li><a href="/admin/khach_hang.php">Khách hàng</a></li>
      <li><a href="/admin/pos.php">POS</a></li>
      <li><a href="/admin/dich_vu.php">Dịch vụ</a></li>
      <li><a href="/admin/lich_hen.php">Lịch hẹn</a></li>
      <li><a href="/admin/nha_cung_cap.php">NCC</a></li>
      <li><a href="/admin/phieu_nhap.php">Nhập kho</a></li>
      <li><a href="/admin/ton_kho.php">Tồn kho</a></li>
      <li><a href="/admin/bao_cao.php">Báo cáo</a></li>
<li><a href="/admin/khach_hang_than_thiet.php">⭐ Khách hàng thân thiết</a></li>    </ul>
  </div>
</nav>

<main class="container">
