<?php
require_once __DIR__ . "/../config/ket_noi_csdl.php";

if (session_status() === PHP_SESSION_NONE) session_start();

$ten_dang_nhap = trim($_POST["ten_dang_nhap"] ?? "");
$mat_khau = trim($_POST["mat_khau"] ?? "");
$ho_ten = trim($_POST["ho_ten"] ?? "");
$email = trim($_POST["email"] ?? "");
$so_dien_thoai = trim($_POST["so_dien_thoai"] ?? "");

if ($ten_dang_nhap === "" || $mat_khau === "" || $ho_ten === "") {
    header("Location: /petshop/petshop/trang_khach/dang_ky.php?err=Vui lòng nhập đầy đủ thông tin");
    exit;
}

$stmt = $conn->prepare("
    SELECT id 
    FROM nguoi_dung 
    WHERE ten_dang_nhap = ?
    LIMIT 1
");
$stmt->bind_param("s", $ten_dang_nhap);
$stmt->execute();
$old = $stmt->get_result()->fetch_assoc();

if ($old) {
    header("Location: /petshop/petshop/trang_khach/dang_ky.php?err=Tên đăng nhập đã tồn tại");
    exit;
}

$mat_khau_hash = password_hash($mat_khau, PASSWORD_DEFAULT);
$vai_tro = "khach";
$trang_thai = 1;

$stmt = $conn->prepare("
    INSERT INTO nguoi_dung(
        ho_ten,
        ten_dang_nhap,
        mat_khau_hash,
        vai_tro,
        trang_thai
    )
    VALUES (?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "ssssi",
    $ho_ten,
    $ten_dang_nhap,
    $mat_khau_hash,
    $vai_tro,
    $trang_thai
);

if (!$stmt->execute()) {
    header("Location: /petshop/petshop/trang_khach/dang_ky.php?err=Không đăng ký được tài khoản");
    exit;
}

header("Location: /petshop/petshop/trang_khach/dang_nhap.php?err=Đăng ký thành công, vui lòng đăng nhập");
exit;