<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/ket_noi_csdl.php';

if (
    !isset($_SESSION['user']) ||
    !is_array($_SESSION['user']) ||
    !isset($_SESSION['user']['id']) ||
    !isset($_SESSION['user']['vai_tro']) ||
    $_SESSION['user']['vai_tro'] !== 'admin'
) {
    echo json_encode([
        'success' => false,
        'message' => 'Bạn chưa đăng nhập.'
    ]);
    exit;
}

$action = $_REQUEST['action'] ?? '';

try {
    if ($action === 'list') {
        $keyword = trim($_GET['keyword'] ?? '');

        $sql = "SELECT * FROM nha_cung_cap";
        if ($keyword !== '') {
            $sql .= " WHERE ten_nha_cung_cap LIKE ? 
                      OR nguoi_lien_he LIKE ? 
                      OR so_dien_thoai LIKE ? 
                      OR email LIKE ?";
        }
        $sql .= " ORDER BY id DESC";

        $stmt = $conn->prepare($sql);

        if ($keyword !== '') {
            $like = '%' . $keyword . '%';
            $stmt->bind_param('ssss', $like, $like, $like, $like);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        echo json_encode([
            'success' => true,
            'data' => $data
        ]);
        exit;
    }

    if ($action === 'detail') {
        $id = (int)($_GET['id'] ?? 0);

        $stmt = $conn->prepare("SELECT * FROM nha_cung_cap WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (!$row) {
            echo json_encode([
                'success' => false,
                'message' => 'Không tìm thấy nhà cung cấp.'
            ]);
            exit;
        }

        echo json_encode([
            'success' => true,
            'data' => $row
        ]);
        exit;
    }

    if ($action === 'create') {
        $ten_nha_cung_cap = trim($_POST['ten_nha_cung_cap'] ?? '');
        $nguoi_lien_he = trim($_POST['nguoi_lien_he'] ?? '');
        $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $dia_chi = trim($_POST['dia_chi'] ?? '');
        $ghi_chu = trim($_POST['ghi_chu'] ?? '');
        $trang_thai = isset($_POST['trang_thai']) ? (int)$_POST['trang_thai'] : 1;

        if ($ten_nha_cung_cap === '') {
            throw new Exception('Tên nhà cung cấp không được để trống.');
        }

        $stmt = $conn->prepare("
            INSERT INTO nha_cung_cap (
                ten_nha_cung_cap, nguoi_lien_he, so_dien_thoai, email, dia_chi, ghi_chu, trang_thai
            ) VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            'ssssssi',
            $ten_nha_cung_cap,
            $nguoi_lien_he,
            $so_dien_thoai,
            $email,
$dia_chi,
            $ghi_chu,
            $trang_thai
        );

        $stmt->execute();

        echo json_encode([
            'success' => true,
            'message' => 'Thêm nhà cung cấp thành công.'
        ]);
        exit;
    }

    if ($action === 'update') {
        $id = (int)($_POST['id'] ?? 0);
        $ten_nha_cung_cap = trim($_POST['ten_nha_cung_cap'] ?? '');
        $nguoi_lien_he = trim($_POST['nguoi_lien_he'] ?? '');
        $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $dia_chi = trim($_POST['dia_chi'] ?? '');
        $ghi_chu = trim($_POST['ghi_chu'] ?? '');
        $trang_thai = isset($_POST['trang_thai']) ? (int)$_POST['trang_thai'] : 1;

        if ($id <= 0) {
            throw new Exception('ID không hợp lệ.');
        }

        if ($ten_nha_cung_cap === '') {
            throw new Exception('Tên nhà cung cấp không được để trống.');
        }

        $stmt = $conn->prepare("
            UPDATE nha_cung_cap
            SET ten_nha_cung_cap = ?,
                nguoi_lien_he = ?,
                so_dien_thoai = ?,
                email = ?,
                dia_chi = ?,
                ghi_chu = ?,
                trang_thai = ?
            WHERE id = ?
        ");

        $stmt->bind_param(
            'ssssssii',
            $ten_nha_cung_cap,
            $nguoi_lien_he,
            $so_dien_thoai,
            $email,
            $dia_chi,
            $ghi_chu,
            $trang_thai,
            $id
        );

        $stmt->execute();

        echo json_encode([
            'success' => true,
            'message' => 'Cập nhật nhà cung cấp thành công.'
        ]);
        exit;
    }

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);

        if ($id <= 0) {
            throw new Exception('ID không hợp lệ.');
        }

        $stmt = $conn->prepare("DELETE FROM nha_cung_cap WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();

        echo json_encode([
            'success' => true,
            'message' => 'Xóa nhà cung cấp thành công.'
        ]);
        exit;
    }

    if ($action === 'toggle_status') {
        $id = (int)($_POST['id'] ?? 0);

        if ($id <= 0) {
            throw new Exception('ID không hợp lệ.');
        }

        $stmt = $conn->prepare("
            UPDATE nha_cung_cap
            SET trang_thai = IF(trang_thai = 1, 0, 1)
            WHERE id = ?
        ");
        $stmt->bind_param('i', $id);
        $stmt->execute();

        echo json_encode([
            'success' => true,
            'message' => 'Cập nhật trạng thái thành công.'
        ]);
        exit;
    }

    echo json_encode([
        'success' => false,
        'message' => 'Action không hợp lệ.'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}