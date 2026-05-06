<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . "/../config/ket_noi_csdl.php";

header("Content-Type: application/json; charset=utf-8");

function out($ok, $data = []) {
    echo json_encode(array_merge(["ok" => $ok], $data), JSON_UNESCAPED_UNICODE);
    exit;
}

$action = $_GET["action"] ?? "";

if ($action === "list") {
    $sdt = trim($_GET["so_dien_thoai"] ?? "");

    if ($sdt === "") {
        out(false, ["msg" => "Thiếu số điện thoại"]);
    }

    $stmt = $conn->prepare("
        SELECT 
            dh.id,
            dh.ngay_tao,
            dh.tong_tien,
            dh.trang_thai
        FROM don_hang dh
        JOIN khach_hang kh ON dh.id_khach_hang = kh.id
        WHERE kh.so_dien_thoai = ?
        ORDER BY dh.id DESC
    ");

    if (!$stmt) {
        out(false, ["msg" => "Lỗi SQL list: " . $conn->error]);
    }

    $stmt->bind_param("s", $sdt);
    $stmt->execute();
    $rs = $stmt->get_result();

    $data = [];
    while ($row = $rs->fetch_assoc()) {
        $data[] = $row;
    }

    out(true, ["data" => $data]);
}

if ($action === "detail") {
    $id = (int)($_GET["id"] ?? 0);

    if ($id <= 0) {
        out(false, ["msg" => "Thiếu mã đơn hàng"]);
    }

    $stmt = $conn->prepare("
        SELECT 
            sp.ten_san_pham,
            ct.so_luong,
            ct.don_gia
        FROM chi_tiet_don_hang ct
        JOIN san_pham sp ON sp.id = ct.id_san_pham
        WHERE ct.id_don_hang = ?
    ");

    if (!$stmt) {
        out(false, ["msg" => "Lỗi SQL detail: " . $conn->error]);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $rs = $stmt->get_result();

    $data = [];
    while ($row = $rs->fetch_assoc()) {
        $data[] = $row;
    }

    out(true, ["data" => $data]);
}

out(false, ["msg" => "Action không hợp lệ"]);