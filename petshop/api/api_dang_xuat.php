<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| Xóa thông tin đăng nhập
|--------------------------------------------------------------------------
| Project của bạn có thể đang dùng $_SESSION['khach']
| hoặc $_SESSION['user'], nên xóa cả 2 cho chắc.
*/
unset($_SESSION['khach']);
unset($_SESSION['user']);
unset($_SESSION['khach_hang_id']);
unset($_SESSION['ten_dang_nhap']);
unset($_SESSION['ho_ten']);

/*
|--------------------------------------------------------------------------
| Nếu muốn xóa toàn bộ session thì mở dòng bên dưới
|--------------------------------------------------------------------------
*/
// session_destroy();

/*
|--------------------------------------------------------------------------
| Chuyển trang sau khi đăng xuất
|--------------------------------------------------------------------------
*/
$src = $_GET['src'] ?? 'khach';

if ($src === 'admin') {
    header("Location: /petshop/petshop/admin/login.php");
    exit;
}

header("Location: /petshop/petshop/trang_khach/trang_chu.php");
exit;
?>