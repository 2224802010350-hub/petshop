<?php
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/ket_noi_csdl.php';

if (
    !isset($_SESSION['user']) ||
    !is_array($_SESSION['user']) ||
    ($_SESSION['user']['vai_tro'] ?? '') !== 'admin'
) {
    echo json_encode([
        'success' => false,
        'message' => 'Bạn chưa đăng nhập admin.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$action = $_REQUEST['action'] ?? '';

function json_response($success, $message = '', $data = null) {
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

function xep_hang($diem) {
    if ($diem >= 100000) return 'Kim cương';
    if ($diem >= 10000) return 'Vàng';
    if ($diem >= 1000) return 'Bạc';
    return 'Đồng';
}

try {
    if ($action === 'list') {
        $keyword = trim($_GET['keyword'] ?? '');

        $sql = "
            SELECT 
                kh.id AS khach_hang_id,
                kh.ho_ten,
                kh.so_dien_thoai,
                kh.email,
                COALESCE(khtt.diem, 0) AS diem,
                COALESCE(khtt.hang_thanh_vien, 'Đồng') AS hang_thanh_vien,
                COALESCE(khtt.ghi_chu, '') AS ghi_chu,
                khtt.ngay_cap_nhat
            FROM khach_hang kh
            LEFT JOIN khach_hang_than_thiet khtt 
                ON kh.id = khtt.khach_hang_id
            WHERE 1=1
        ";

        $params = [];
        $types = '';

        if ($keyword !== '') {
            $sql .= " AND (kh.ho_ten LIKE ? OR kh.so_dien_thoai LIKE ? OR kh.email LIKE ?)";
            $like = '%' . $keyword . '%';
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
            $types .= 'sss';
        }

        $sql .= " ORDER BY diem DESC, kh.id DESC";

        $stmt = $conn->prepare($sql);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $rs = $stmt->get_result();

        $data = [];
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }

        json_response(true, '', $data);
    }

    if ($action === 'update_point') {
        $khach_hang_id = (int)($_POST['khach_hang_id'] ?? 0);
        $diem = (int)($_POST['diem'] ?? 0);
        $ghi_chu = trim($_POST['ghi_chu'] ?? '');

        if ($khach_hang_id <= 0) {
            json_response(false, 'Khách hàng không hợp lệ.');
        }

        if ($diem < 0) {
            json_response(false, 'Điểm không được nhỏ hơn 0.');
        }

        $hang = xep_hang($diem);

        $stmt = $conn->prepare("
            INSERT INTO khach_hang_than_thiet 
                (khach_hang_id, diem, hang_thanh_vien, ghi_chu)
            VALUES (?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
                diem = VALUES(diem),
                hang_thanh_vien = VALUES(hang_thanh_vien),
                ghi_chu = VALUES(ghi_chu)
        ");

        $stmt->bind_param('iiss', $khach_hang_id, $diem, $hang, $ghi_chu);
        $stmt->execute();

        json_response(true, 'Cập nhật điểm thành công.');
    }

    json_response(false, 'Action không hợp lệ.');
} catch (Throwable $e) {
    json_response(false, $e->getMessage());
}