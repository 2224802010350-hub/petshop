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

function json_response($success, $message = '', $data = null) {
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

function tao_ma_phieu(mysqli $conn): string {
    $prefix = 'PN' . date('Ymd');
    $sql = "SELECT COUNT(*) AS total FROM phieu_nhap WHERE DATE(ngay_nhap) = CURDATE()";
    $rs = $conn->query($sql);
    $row = $rs ? $rs->fetch_assoc() : ['total' => 0];
    $stt = (int)($row['total'] ?? 0) + 1;
    return $prefix . str_pad((string)$stt, 3, '0', STR_PAD_LEFT);
}

try {
    if ($action === 'suppliers') {
        $sql = "
            SELECT id, ten_nha_cung_cap, nguoi_lien_he, so_dien_thoai
            FROM nha_cung_cap
            WHERE trang_thai = 1
            ORDER BY ten_nha_cung_cap ASC
        ";
        $rs = $conn->query($sql);

        if (!$rs) {
            json_response(false, 'Lỗi lấy nhà cung cấp: ' . $conn->error);
        }

        $data = [];
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }

        json_response(true, '', $data);
    }

    if ($action === 'products') {
        $keyword = trim($_GET['keyword'] ?? '');

        $sql = "
            SELECT id, ma_sku, ten_san_pham, gia_ban, so_luong_ton, trang_thai, hinh_anh
            FROM san_pham
            WHERE trang_thai = 1
        ";

        if ($keyword !== '') {
            $sql .= " AND (ten_san_pham LIKE ? OR ma_sku LIKE ?)";
        }

        $sql .= " ORDER BY id DESC LIMIT 50";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            json_response(false, 'Lỗi SQL sản phẩm: ' . $conn->error);
        }

        if ($keyword !== '') {
            $like = '%' . $keyword . '%';
            $stmt->bind_param('ss', $like, $like);
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
                'ton_hien_tai' => (int)$row['ton_kho'],
                'hinh_anh' => $row['hinh_anh']
            ];
        }

        json_response(true, '', $data);
    }

    if ($action === 'list') {
        $sql = "
            SELECT pn.*, ncc.ten_nha_cung_cap
            FROM phieu_nhap pn
            INNER JOIN nha_cung_cap ncc ON pn.nha_cung_cap_id = ncc.id
            ORDER BY pn.id DESC
        ";
        $rs = $conn->query($sql);

        if (!$rs) {
            json_response(false, 'Lỗi lấy danh sách phiếu nhập: ' . $conn->error);
        }

        $data = [];
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }

        json_response(true, '', $data);
    }

    if ($action === 'create') {
        $nha_cung_cap_id = (int)($_POST['nha_cung_cap_id'] ?? 0);
        $ghi_chu = trim($_POST['ghi_chu'] ?? '');
        $itemsJson = $_POST['items'] ?? '[]';
        $items = json_decode($itemsJson, true);

        if ($nha_cung_cap_id <= 0) {
            json_response(false, 'Vui lòng chọn nhà cung cấp.');
        }

        if (!is_array($items) || count($items) === 0) {
            json_response(false, 'Vui lòng thêm ít nhất 1 sản phẩm.');
        }

        $stmtCheckSupplier = $conn->prepare("
            SELECT id
            FROM nha_cung_cap
            WHERE id = ? AND trang_thai = 1
            LIMIT 1
        ");
        $stmtCheckSupplier->bind_param('i', $nha_cung_cap_id);
        $stmtCheckSupplier->execute();
        $supplier = $stmtCheckSupplier->get_result()->fetch_assoc();

        if (!$supplier) {
            json_response(false, 'Nhà cung cấp không hợp lệ.');
        }

        $conn->begin_transaction();

        $ma_phieu = tao_ma_phieu($conn);
        $admin_id = (int)$_SESSION['user']['id'];
        $tong_tien = 0;

        $stmtCheckProduct = $conn->prepare("
            SELECT id
            FROM san_pham
            WHERE id = ? AND trang_thai = 1
            LIMIT 1
        ");

        foreach ($items as $item) {
            $san_pham_id = (int)($item['san_pham_id'] ?? 0);
            $so_luong = (int)($item['so_luong'] ?? 0);
            $gia_nhap = (float)($item['gia_nhap'] ?? 0);

            if ($san_pham_id <= 0 || $so_luong <= 0 || $gia_nhap < 0) {
                throw new Exception('Dữ liệu sản phẩm trong phiếu không hợp lệ.');
            }

            $stmtCheckProduct->bind_param('i', $san_pham_id);
            $stmtCheckProduct->execute();
            $product = $stmtCheckProduct->get_result()->fetch_assoc();

            if (!$product) {
                throw new Exception('Có sản phẩm không tồn tại hoặc đã ẩn.');
            }

            $tong_tien += $so_luong * $gia_nhap;
        }

        $stmt = $conn->prepare("
            INSERT INTO phieu_nhap (
                ma_phieu, nha_cung_cap_id, ngay_nhap, tong_tien, ghi_chu, trang_thai, admin_id
            ) VALUES (?, ?, NOW(), ?, ?, 'draft', ?)
        ");
        $stmt->bind_param('sidsi', $ma_phieu, $nha_cung_cap_id, $tong_tien, $ghi_chu, $admin_id);
        $stmt->execute();

        $phieu_nhap_id = $conn->insert_id;

        $stmtItem = $conn->prepare("
            INSERT INTO chi_tiet_phieu_nhap (
                phieu_nhap_id, san_pham_id, so_luong, gia_nhap
            ) VALUES (?, ?, ?, ?)
        ");

        foreach ($items as $item) {
            $san_pham_id = (int)$item['san_pham_id'];
            $so_luong = (int)$item['so_luong'];
            $gia_nhap = (float)$item['gia_nhap'];

            $stmtItem->bind_param('iiid', $phieu_nhap_id, $san_pham_id, $so_luong, $gia_nhap);
            $stmtItem->execute();
        }

        $conn->commit();
        json_response(true, 'Tạo phiếu nhập thành công.');
    }

    if ($action === 'confirm') {
        $id = (int)($_POST['id'] ?? 0);

        if ($id <= 0) {
            json_response(false, 'ID phiếu nhập không hợp lệ.');
        }

        $conn->begin_transaction();

        $stmt = $conn->prepare("
            SELECT *
            FROM phieu_nhap
            WHERE id = ?
            FOR UPDATE
        ");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $phieu = $stmt->get_result()->fetch_assoc();

        if (!$phieu) {
            throw new Exception('Phiếu nhập không tồn tại.');
        }

        if ($phieu['trang_thai'] === 'confirmed') {
            throw new Exception('Phiếu nhập đã được xác nhận.');
        }

        if ($phieu['trang_thai'] === 'cancelled') {
            throw new Exception('Phiếu nhập đã bị hủy.');
        }

        $stmt2 = $conn->prepare("
            SELECT san_pham_id, so_luong
            FROM chi_tiet_phieu_nhap
            WHERE phieu_nhap_id = ?
        ");
        $stmt2->bind_param('i', $id);
        $stmt2->execute();
        $rs2 = $stmt2->get_result();

        while ($row = $rs2->fetch_assoc()) {
            $stmtUpdate = $conn->prepare("
                UPDATE san_pham
                SET so_luong_ton = so_luong_ton + ?
                WHERE id = ?
            ");
            $stmtUpdate->bind_param('ii', $row['so_luong'], $row['san_pham_id']);
            $stmtUpdate->execute();
        }

        $stmt3 = $conn->prepare("
            UPDATE phieu_nhap
            SET trang_thai = 'confirmed'
            WHERE id = ?
        ");
        $stmt3->bind_param('i', $id);
        $stmt3->execute();

        $conn->commit();
        json_response(true, 'Xác nhận phiếu nhập thành công.');
    }

    if ($action === 'cancel') {
        $id = (int)($_POST['id'] ?? 0);

        if ($id <= 0) {
            json_response(false, 'ID phiếu nhập không hợp lệ.');
        }

        $stmt = $conn->prepare("
            UPDATE phieu_nhap
            SET trang_thai = 'cancelled'
            WHERE id = ? AND trang_thai = 'draft'
        ");
        $stmt->bind_param('i', $id);
        $stmt->execute();

        json_response(true, 'Đã hủy phiếu nhập.');
    }

    json_response(false, 'Action không hợp lệ.');
} catch (Exception $e) {
    try {
        $conn->rollback();
    } catch (Throwable $t) {
    }
    json_response(false, $e->getMessage());
}