<?php
include("../config/ket_noi_csdl.php");

$action = $_GET['action'] ?? '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$conn->query("
CREATE TABLE IF NOT EXISTS dich_vu_khachsan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    can_nang VARCHAR(50) NOT NULL,
    qua_dem INT NOT NULL DEFAULT 0,
    trong_ngay INT NOT NULL DEFAULT 0,
    nua_ngay INT NOT NULL DEFAULT 0,
    mot_den_ba_tieng INT NOT NULL DEFAULT 0
)
");

if ($action === "delete" && $id > 0) {
    $stmt = $conn->prepare("DELETE FROM dich_vu_khachsan WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: khach_san.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $form_action = $_POST['form_action'] ?? '';

    $can_nang = trim($_POST['can_nang'] ?? '');
    $qua_dem = intval($_POST['qua_dem'] ?? 0);
    $trong_ngay = intval($_POST['trong_ngay'] ?? 0);
    $nua_ngay = intval($_POST['nua_ngay'] ?? 0);
    $mot_den_ba_tieng = intval($_POST['mot_den_ba_tieng'] ?? 0);

    if ($can_nang == "") {
        die("Lỗi: Cân nặng không được để trống.");
    }

    if ($form_action === "add") {
        $stmt = $conn->prepare("
            INSERT INTO dich_vu_khachsan
            (can_nang, qua_dem, trong_ngay, nua_ngay, mot_den_ba_tieng)
            VALUES (?, ?, ?, ?, ?)
        ");

        if (!$stmt) {
            die("Lỗi SQL thêm: " . $conn->error);
        }

        $stmt->bind_param(
            "siiii",
            $can_nang,
            $qua_dem,
            $trong_ngay,
            $nua_ngay,
            $mot_den_ba_tieng
        );

        if (!$stmt->execute()) {
            die("Lỗi thêm dữ liệu: " . $stmt->error);
        }

        header("Location: khach_san.php");
        exit();
    }

    if ($form_action === "edit") {
        $id = intval($_POST['id'] ?? 0);

        if ($id <= 0) {
            die("Lỗi: Không có ID để cập nhật.");
        }

        $stmt = $conn->prepare("
            UPDATE dich_vu_khachsan
            SET can_nang = ?,
                qua_dem = ?,
                trong_ngay = ?,
                nua_ngay = ?,
                mot_den_ba_tieng = ?
            WHERE id = ?
        ");

        if (!$stmt) {
            die("Lỗi SQL cập nhật: " . $conn->error);
        }

        $stmt->bind_param(
            "siiiii",
            $can_nang,
            $qua_dem,
            $trong_ngay,
            $nua_ngay,
            $mot_den_ba_tieng,
            $id
        );

        if (!$stmt->execute()) {
            die("Lỗi cập nhật dữ liệu: " . $stmt->error);
        }

        header("Location: khach_san.php");
        exit();
    }
}

$edit_data = null;

if ($action === "edit" && $id > 0) {
    $stmt = $conn->prepare("SELECT * FROM dich_vu_khachsan WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result_edit = $stmt->get_result();

    if ($result_edit && $result_edit->num_rows > 0) {
        $edit_data = $result_edit->fetch_assoc();
    }
}

$result = $conn->query("SELECT * FROM dich_vu_khachsan ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý bảng giá khách sạn thú cưng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #fff8e8;
            font-family: Arial, sans-serif;
        }

        .box {
            background: white;
            padding: 25px;
            border-radius: 16px;
            margin-top: 30px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.12);
        }

        h3 {
            color: #f58220;
            text-align: center;
            font-weight: bold;
            margin-bottom: 25px;
        }

        th {
            background: #00a6a6;
            color: white;
            text-align: center;
            white-space: nowrap;
        }

        td {
            text-align: center;
            vertical-align: middle;
            font-weight: 600;
        }

        .form-box {
            background: #fff3d6;
            padding: 22px;
            border-radius: 14px;
            margin-top: 25px;
        }

        .btn {
            border-radius: 8px;
            font-weight: 600;
        }

        label {
            font-weight: 600;
        }

        .note {
            color: #777;
            font-size: 14px;
            text-align: center;
            margin-top: 15px;
        }

        .table-wrap {
            overflow-x: auto;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="box">

        <h3>🏨 QUẢN LÝ BẢNG GIÁ KHÁCH SẠN THÚ CƯNG</h3>

        <div class="mb-3">
            <a href="dich_vu.php" class="btn btn-secondary">Quay lại dịch vụ</a>
        </div>

        <div class="table-wrap">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Cân nặng</th>
                        <th>Qua đêm</th>
                        <th>Trong ngày</th>
                        <th>Nửa ngày</th>
                        <th>1 - 3 tiếng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if ($result && $result->num_rows > 0) { ?>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['can_nang']); ?></td>
                                <td><?php echo number_format($row['qua_dem'] / 1000); ?></td>
                                <td><?php echo number_format($row['trong_ngay'] / 1000); ?></td>
                                <td><?php echo number_format($row['nua_ngay'] / 1000); ?></td>
                                <td><?php echo number_format($row['mot_den_ba_tieng'] / 1000); ?></td>

                                <td>
                                    <a href="khach_san.php?action=edit&id=<?php echo intval($row['id']); ?>"
                                       class="btn btn-warning btn-sm">
                                        Sửa
                                    </a>

                                    <a href="khach_san.php?action=delete&id=<?php echo intval($row['id']); ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Bạn có chắc muốn xóa dòng giá này không?')">
                                        Xóa
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="6" class="text-danger">Chưa có dữ liệu bảng giá khách sạn.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <p class="note">
            Đơn vị hiển thị: 280 = 280.000 VNĐ. Khi nhập giá, nhập đầy đủ: 280000.
        </p>

        <div class="form-box">
            <?php if ($edit_data) { ?>

                <h5 class="mb-3 text-warning">Sửa bảng giá khách sạn</h5>

                <form method="POST" action="khach_san.php">
                    <input type="hidden" name="form_action" value="edit">
                    <input type="hidden" name="id" value="<?php echo intval($edit_data['id']); ?>">

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label>Cân nặng</label>
                            <input type="text" name="can_nang" class="form-control"
                                   value="<?php echo htmlspecialchars($edit_data['can_nang']); ?>" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Qua đêm</label>
                            <input type="number" name="qua_dem" class="form-control"
                                   value="<?php echo intval($edit_data['qua_dem']); ?>" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Trong ngày</label>
                            <input type="number" name="trong_ngay" class="form-control"
                                   value="<?php echo intval($edit_data['trong_ngay']); ?>" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Nửa ngày</label>
                            <input type="number" name="nua_ngay" class="form-control"
                                   value="<?php echo intval($edit_data['nua_ngay']); ?>" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>1 - 3 tiếng</label>
                            <input type="number" name="mot_den_ba_tieng" class="form-control"
                                   value="<?php echo intval($edit_data['mot_den_ba_tieng']); ?>" required>
                        </div>

                        <div class="form-group col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-warning btn-block">
                                Cập nhật
                            </button>
                        </div>
                    </div>

                    <a href="khach_san.php" class="btn btn-secondary btn-sm">Hủy sửa</a>
                </form>

            <?php } else { ?>

                <h5 class="mb-3 text-success">Thêm bảng giá khách sạn mới</h5>

                <form method="POST" action="khach_san.php">
                    <input type="hidden" name="form_action" value="add">

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label>Cân nặng</label>
                            <input type="text" name="can_nang" class="form-control" placeholder="< 3kg" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Qua đêm</label>
                            <input type="number" name="qua_dem" class="form-control" placeholder="280000" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Trong ngày</label>
                            <input type="number" name="trong_ngay" class="form-control" placeholder="130000" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Nửa ngày</label>
                            <input type="number" name="nua_ngay" class="form-control" placeholder="100000" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>1 - 3 tiếng</label>
                            <input type="number" name="mot_den_ba_tieng" class="form-control" placeholder="60000" required>
                        </div>

                        <div class="form-group col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-success btn-block">Thêm</button>
                        </div>
                    </div>
                </form>

            <?php } ?>
        </div>

    </div>
</div>

</body>
</html>