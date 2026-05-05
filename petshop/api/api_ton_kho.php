<?php
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/ket_noi_csdl.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    echo json_encode([
        'success' => false,
        'message' => 'Không kết nối được CSDL.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if (
    !isset($_SESSION['user']) ||
    !is_array($_SESSION['user']) ||
    !isset($_SESSION['user']['id']) ||
    !isset($_SESSION['user']['vai_tro']) ||
    $_SESSION['user']['vai_tro'] !== 'admin'
) {
    echo json_encode([
        'success' => false,
        'message' => 'Bạn chưa đăng nhập admin.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$action = $_REQUEST['action'] ?? '';

function json_response($success, $message = '', $data = null)
{
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    if ($action === 'stats') {
        $stats = [
            'tong_san_pham' => 0,
            'tong_ton_kho' => 0,
            'sap_het' => 0,
            'het_hang' => 0
        ];

        $rs1 = $conn->query("SELECT COUNT(*) AS total FROM san_pham WHERE trang_thai = 1");
        if ($rs1) {
            $stats['tong_san_pham'] = (int)$rs1->fetch_assoc()['total'];
        }

        $rs2 = $conn->query("SELECT COALESCE(SUM(ton_kho), 0) AS total FROM san_pham WHERE trang_thai = 1");
        if ($rs2) {
            $stats['tong_ton_kho'] = (int)$rs2->fetch_assoc()['total'];
        }

        $rs3 = $conn->query("SELECT COUNT(*) AS total FROM san_pham WHERE trang_thai = 1 AND ton_kho > 0 AND ton_kho <= 5");
        if ($rs3) {
            $stats['sap_het'] = (int)$rs3->fetch_assoc()['total'];
        }

        $rs4 = $conn->query("SELECT COUNT(*) AS total FROM san_pham WHERE trang_thai = 1 AND ton_kho <= 0");
        if ($rs4) {
            $stats['het_hang'] = (int)$rs4->fetch_assoc()['total'];
        }

        json_response(true, '', $stats);
    }

    if ($action === 'list') {
        $keyword = trim($_GET['keyword'] ?? '');
        $filter = trim($_GET['filter'] ?? '');

        $sql = "
            SELECT 
    id,
    ma_sku,
    ten_san_pham,
    gia_ban,
    hinh_anh,
    ton_kho,
    trang_thai,
    ngay_tao
FROM san_pham
WHERE 1=1
        ";

        $params = [];
        $types = '';

        if ($keyword !== '') {
            $sql .= " AND (ten_san_pham LIKE ? OR ma_sku LIKE ?)";
            $like = '%' . $keyword . '%';
            $params[] = $like;
            $params[] = $like;
            $types .= 'ss';
        }

        if ($filter === 'sap_het') {
    $sql .= " AND ton_kho > 0 AND ton_kho <= 5";
} elseif ($filter === 'het_hang') {
    $sql .= " AND ton_kho <= 0";
} elseif ($filter === 'con_hang') {
    $sql .= " AND ton_kho > 5";
}

$sql .= " ORDER BY ton_kho ASC, id DESC";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            json_response(false, 'Lỗi SQL tồn kho: ' . $conn->error);
        }

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $rs = $stmt->get_result();

        $data = [];
        while ($row = $rs->fetch_assoc()) {
            $data[] = [
                'id' => (int)$row['id'],
                'ma_sku' => $row['ma_sku'],
                'ten_san_pham' => $row['ten_san_pham'],
                'gia_ban' => (int)$row['gia_ban'],
                'hinh_anh' => $row['hinh_anh'],
                'so_luong_ton' => (int)$row['ton_kho'],
                'trang_thai' => (int)$row['trang_thai'],
                'ngay_tao' => $row['ngay_tao']
            ];
        }

        json_response(true, '', $data);
    }

    json_response(false, 'Action không hợp lệ.');
} catch (Throwable $e) {
    json_response(false, $e->getMessage());
}
