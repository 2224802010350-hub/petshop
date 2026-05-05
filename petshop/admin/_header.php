<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$user = $_SESSION['user'] ?? null;
$role = $user['vai_tro'] ?? '';
$name = $user['ho_ten'] ?? ($user['ten_dang_nhap'] ?? 'User');
$cur = basename($_SERVER['PHP_SELF']);
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin - PetShop</title>
  <link rel="stylesheet" href="/petshop/petshop/assets/css/admin.css">
</head>
<body>
<div class="layout">
  <aside class="sidebar">
    <div class="brand">
      <div class="dot"></div>
      <div>
        <div>PETSHOP ADMIN</div>
        <div class="muted" style="color:#94a3b8">Quản lý hệ thống</div>
      </div>
    </div>

    <?php
// helper active
$cur = basename($_SERVER["PHP_SELF"]);
function isActive($file){
  global $cur;
  return $cur === $file ? "active" : "";
}
?>
<nav class="side">
  <div class="brand">
    <div class="logo"></div>
    <div>
      <div class="t1">PETSHOP ADMIN</div>
      <div class="t2">Quản lý hệ thống</div>
    </div>
  </div>

  <div class="menu">
    <a class="item <?=isActive('dashboard.php')?>" href="/petshop/petshop/admin/dashboard.php">
      <span class="ico">🏠</span><span>Dashboard</span>
    </a>

    <div class="hr"></div>
    <div class="groupTitle">Sản phẩm</div>

    <a class="item <?=isActive('san_pham.php')?>" href="/petshop/petshop/admin/san_pham.php">
      <span class="ico">📦</span><span>Sản phẩm</span>
    </a>

    <a class="item <?=isActive('danh_muc.php')?>" href="/petshop/petshop/admin/danh_muc.php">
      <span class="ico">🗂️</span><span>Danh mục</span>
    </a>

    <div class="hr"></div>
    <div class="groupTitle">Khách & bán hàng</div>

    <a class="item <?=isActive('khach_hang.php')?>" href="/petshop/petshop/admin/khach_hang.php">
      <span class="ico">👤</span><span>Khách hàng</span>
    </a>

    <a class="item <?=isActive('don_hang.php')?>" href="/petshop/petshop/admin/don_hang.php">
      <span class="ico">🧾</span><span>Bán hàng / Đơn hàng</span>
    </a>

    <div class="hr"></div>
    <div class="groupTitle">Dịch vụ</div>

    <a class="item <?=isActive('dich_vu.php')?>" href="/petshop/petshop/admin/dich_vu.php">
      <span class="ico">🛁</span><span>Dịch vụ</span>
    </a>

    <a class="item <?=isActive('lich_hen.php')?>" href="/petshop/petshop/admin/lich_hen.php">
      <span class="ico">📅</span><span>Lịch hẹn dịch vụ</span>
    </a>

    <div class="hr"></div>
    <div class="groupTitle">Kho</div>

    <a class="item <?=isActive('nha_cung_cap.php')?>" href="/petshop/petshop/admin/nha_cung_cap.php">
      <span class="ico">🚚</span><span>Nhà cung cấp</span>
    </a>

    <a class="item <?=isActive('phieu_nhap.php')?>" href="/petshop/petshop/admin/phieu_nhap.php">
      <span class="ico">🧾</span><span>Phiếu nhập kho</span>
    </a>

    <a class="item <?=isActive('ton_kho.php')?>" href="/petshop/petshop/admin/ton_kho.php">
      <span class="ico">📊</span><span>Tồn kho</span>
    </a>

    <div class="hr"></div>
    <div class="groupTitle">Khác</div>

    <a class="item <?=isActive('khach_hang_than_thiet.php')?>" href="/petshop/petshop/admin/khach_hang_than_thiet.php">
  <span class="ico">⭐</span><span>Khách hàng thân thiết</span>
</a>

    <a class="item <?=isActive('bao_cao.php')?>" href="/petshop/petshop/admin/bao_cao.php">
  <span class="ico">📈</span><span>Báo cáo thống kê</span>
</a>

    <div class="hr"></div>

    <a class="item" href="/petshop/petshop/admin/dang_xuat.php">
      <span class="ico">🚪</span><span>Đăng xuất</span>
    </a>
  
  </div>
</nav>
  </aside>

  <main class="main">
    <div class="topbar">
      <div class="topbar__row">
        <div>
          <b>Xin chào, <?= htmlspecialchars($name) ?></b>
          <div class="muted">Vai trò: <b><?= htmlspecialchars($role) ?></b></div>
        </div>
        <div class="userPill">
          <b><?= htmlspecialchars($name) ?></b>
          <span><?= htmlspecialchars($role) ?></span>
        </div>
      </div>
    </div>

    <div class="container">
