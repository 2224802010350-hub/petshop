<?php
include("../config/ket_noi_csdl.php");

$id = intval($_GET['id'] ?? 0);
$action = $_GET['action'] ?? '';

if ($id <= 0) {
    header("Location: lich_hen.php");
    exit();
}

if ($action == "xac_nhan") {
    $trang_thai = "Đã xác nhận";
} elseif ($action == "huy") {
    $trang_thai = "Đã hủy";
} elseif ($action == "hoan_thanh") {
    $trang_thai = "Đã hoàn thành";
} elseif ($action == "xoa") {
    $stmt = $conn->prepare("DELETE FROM dat_dich_vu_spa WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: lich_hen.php");
    exit();
} else {
    header("Location: lich_hen.php");
    exit();
}

$stmt = $conn->prepare("UPDATE dat_dich_vu_spa SET trang_thai = ? WHERE id = ?");
$stmt->bind_param("si", $trang_thai, $id);
$stmt->execute();

header("Location: lich_hen.php");
exit();
?>