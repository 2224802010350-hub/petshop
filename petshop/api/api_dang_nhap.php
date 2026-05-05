<?php
require_once __DIR__ . "/../config/ket_noi_csdl.php";

if (session_status() === PHP_SESSION_NONE) session_start();

function back_with_error($backUrl, $msg) {
    $q = http_build_query(["err" => $msg]);
    header("Location: {$backUrl}?{$q}");
    exit;
}

$src = $_POST["src"] ?? "khach";

$backUrl = ($src === "admin")
    ? "/petshop/petshop/admin/dang_nhap.php"
    : "/petshop/petshop/trang_khach/dang_nhap.php";

$ten = trim($_POST["ten_dang_nhap"] ?? "");
$mk  = trim($_POST["mat_khau"] ?? "");

if ($ten === "" || $mk === "") {
    back_with_error($backUrl, "Vui lòng nhập tài khoản và mật khẩu");
}

if (!isset($conn) || !($conn instanceof mysqli)) {
    back_with_error($backUrl, "Không kết nối được cơ sở dữ liệu");
}

$stmt = $conn->prepare("
    SELECT 
        id,
        ho_ten,
        ten_dang_nhap,
        mat_khau_hash,
        vai_tro,
        trang_thai
    FROM nguoi_dung
    WHERE ten_dang_nhap = ?
    LIMIT 1
");

if (!$stmt) {
    back_with_error($backUrl, "Lỗi SQL: " . $conn->error);
}

$stmt->bind_param("s", $ten);
$stmt->execute();
$rs = $stmt->get_result();

if ($rs->num_rows !== 1) {
    back_with_error($backUrl, "Sai tài khoản hoặc mật khẩu");
}

$user = $rs->fetch_assoc();

if (isset($user["trang_thai"]) && (int)$user["trang_thai"] !== 1) {
    back_with_error($backUrl, "Tài khoản đang bị khóa");
}

if (!password_verify($mk, $user["mat_khau_hash"])) {
    back_with_error($backUrl, "Sai tài khoản hoặc mật khẩu");
}

$role = $user["vai_tro"] ?? "";

/*
  Nếu đăng nhập từ trang admin:
  Chỉ cho admin hoặc nhân viên vào admin.
*/
if ($src === "admin") {
    $adminRoles = ["admin", "nhan_vien"];

    if (!in_array($role, $adminRoles, true)) {
        back_with_error($backUrl, "Tài khoản này không có quyền vào trang quản trị");
    }

    $_SESSION["user"] = [
        "id" => (int)$user["id"],
        "ho_ten" => $user["ho_ten"],
        "ten_dang_nhap" => $user["ten_dang_nhap"],
        "vai_tro" => $user["vai_tro"],
    ];

    header("Location: /petshop/petshop/admin/dashboard.php");
    exit;
}

/*
  Nếu đăng nhập từ trang khách:
  Chỉ cho khách vào trang khách.
*/
if ($src === "khach") {
    if ($role !== "khach") {
        back_with_error($backUrl, "Tài khoản này không phải tài khoản khách hàng");
    }

    $_SESSION["khach"] = [
        "id" => (int)$user["id"],
        "ho_ten" => $user["ho_ten"],
        "ten_dang_nhap" => $user["ten_dang_nhap"],
        "vai_tro" => $user["vai_tro"],
    ];

    header("Location: /petshop/petshop/trang_khach/trang_chu.php");
    exit;
}

back_with_error($backUrl, "Nguồn đăng nhập không hợp lệ");