<?php
// config/ham_chung.php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!defined('BASE_URL')) {
    define('BASE_URL', '/petshop/petshop');
}

function money($v) {
    return number_format((int)$v, 0, ",", ".") . " ₫";
}

function require_login() {
    if (empty($_SESSION['user'])) {
        header("Location: " . BASE_URL . "/admin/dang_nhap.php");
        exit;
    }
}

function require_role($roles = []) {
    require_login();

    $role = $_SESSION['user']['vai_tro'] ?? '';

    if (!in_array($role, $roles, true)) {
        http_response_code(403);
        echo "403 - Không có quyền truy cập";
        exit;
    }
}



if (!function_exists('tinh_hang_thanh_vien')) {
    function tinh_hang_thanh_vien($diem) {
        if ($diem >= 100000) return 'Kim cương';
        if ($diem >= 10000) return 'Vàng';
        if ($diem >= 1000) return 'Bạc';
    return 'Đồng';
    }
}

function cong_diem_than_thiet($conn, $khach_hang_id, $tong_tien) {
    $khach_hang_id = (int)$khach_hang_id;
    $tong_tien = (float)$tong_tien;

    if ($khach_hang_id <= 0 || $tong_tien <= 0) {
        return 0;
    }

    $diem_cong = floor($tong_tien / 10000);

    if ($diem_cong <= 0) {
        return 0;
    }

    $stmt = $conn->prepare("
        SELECT diem 
        FROM khach_hang_than_thiet 
        WHERE khach_hang_id = ?
    ");
    $stmt->bind_param("i", $khach_hang_id);
    $stmt->execute();
    $rs = $stmt->get_result();

    if ($rs->num_rows > 0) {
        $row = $rs->fetch_assoc();
        $diem_moi = (int)$row['diem'] + $diem_cong;
        $hang_moi = tinh_hang_thanh_vien($diem_moi);

        $stmtUpdate = $conn->prepare("
            UPDATE khach_hang_than_thiet
            SET diem = ?, hang_thanh_vien = ?
            WHERE khach_hang_id = ?
        ");
        $stmtUpdate->bind_param("isi", $diem_moi, $hang_moi, $khach_hang_id);
        $stmtUpdate->execute();
    } else {
        $hang = tinh_hang_thanh_vien($diem_cong);

        $stmtInsert = $conn->prepare("
            INSERT INTO khach_hang_than_thiet 
            (khach_hang_id, diem, hang_thanh_vien, ghi_chu)
            VALUES (?, ?, ?, 'Tự động cộng điểm từ đơn hàng')
        ");
        $stmtInsert->bind_param("iis", $khach_hang_id, $diem_cong, $hang);
        $stmtInsert->execute();
    }

    return $diem_cong;
}