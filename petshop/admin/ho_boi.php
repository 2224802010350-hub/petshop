<?php
include("../config/ket_noi_csdl.php");

$action = $_GET['action'] ?? '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

/* XÓA */
if ($action == "delete" && $id > 0) {
    $stmt = $conn->prepare("DELETE FROM dich_vu_ho_boi WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: ho_boi.php");
    exit();
}

/* THÊM */
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['form_action'] ?? '') == "add") {
    $can_nang = trim($_POST['can_nang']);
    $mot_lan = intval($_POST['mot_lan']);
    $goi_5_lan = intval($_POST['goi_5_lan']);
    $goi_10_lan = intval($_POST['goi_10_lan']);
    $uu_dai = intval($_POST['uu_dai']);

    $stmt = $conn->prepare("
        INSERT INTO dich_vu_ho_boi 
        (can_nang, mot_lan, goi_5_lan, goi_10_lan, uu_dai)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("siiii", $can_nang, $mot_lan, $goi_5_lan, $goi_10_lan, $uu_dai);
    $stmt->execute();

    header("Location: ho_boi.php");
    exit();
}

/* SỬA */
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['form_action'] ?? '') == "edit") {
    $id = intval($_POST['id']);
    $can_nang = trim($_POST['can_nang']);
    $mot_lan = intval($_POST['mot_lan']);
    $goi_5_lan = intval($_POST['goi_5_lan']);
    $goi_10_lan = intval($_POST['goi_10_lan']);
    $uu_dai = intval($_POST['uu_dai']);

    $stmt = $conn->prepare("
        UPDATE dich_vu_ho_boi 
        SET can_nang = ?, 
            mot_lan = ?, 
            goi_5_lan = ?, 
            goi_10_lan = ?, 
            uu_dai = ?
        WHERE id = ?
    ");

    $stmt->bind_param("siiiii", $can_nang, $mot_lan, $goi_5_lan, $goi_10_lan, $uu_dai, $id);
    $stmt->execute();

    header("Location: ho_boi.php");
    exit();
}

/* LẤY DỮ LIỆU SỬA */
$edit_data = null;

if ($action == "edit" && $id > 0) {
    $stmt = $conn->prepare("SELECT * FROM dich_vu_ho_boi WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result_edit = $stmt->get_result();

    if ($result_edit && $result_edit->num_rows > 0) {
        $edit_data = $result_edit->fetch_assoc();
    }
}

/* LẤY DANH SÁCH */
$result = $conn->query("SELECT * FROM dich_vu_ho_boi ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý bảng giá hồ bơi</title>

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
    </style>
</head>

<body>

<div class="container">
    <div class="box">

        <h3>🏊 QUẢN LÝ BẢNG GIÁ HỒ BƠI - SÂN CHƠI</h3>

       <div class="mb-3">
    <a href="dich_vu.php" class="btn btn-secondary">Quay lại dịch vụ</a>
</div>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Cân nặng</th>
                    <th>1 lần</th>
                    <th>Gói 5 lần</th>
                    <th>Gói 10 lần</th>
                    <th>Ưu đãi</th>
                    <th>Hành động</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($result && $result->num_rows > 0) { ?>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['can_nang']); ?></td>
                            <td><?php echo number_format($row['mot_lan'] / 1000); ?></td>
                            <td><?php echo number_format($row['goi_5_lan'] / 1000); ?></td>
                            <td><?php echo number_format($row['goi_10_lan'] / 1000); ?></td>
                            <td><?php echo number_format($row['uu_dai'] / 1000); ?></td>

                            <td>
                                <a href="?action=edit&id=<?php echo intval($row['id']); ?>"
                                   class="btn btn-warning btn-sm">
                                    Sửa
                                </a>

                                <a href="?action=delete&id=<?php echo intval($row['id']); ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Bạn có chắc muốn xóa dòng giá này không?')">
                                    Xóa
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="6" class="text-danger">
                            Chưa có dữ liệu bảng giá hồ bơi.
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <p class="note">
            Đơn vị hiển thị: 280 = 280.000 VNĐ. Khi nhập giá, nhập đầy đủ: 280000.
        </p>

        <div class="form-box">
            <?php if (isset($edit_data) && $edit_data) { ?>

                <h5 class="mb-3 text-warning">Sửa bảng giá hồ bơi</h5>

                <form method="POST" action="ho_boi.php">
                    <input type="hidden" name="form_action" value="edit">
                    <input type="hidden" name="id" value="<?php echo intval($edit_data['id']); ?>">

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label>Cân nặng</label>
                            <input type="text" name="can_nang" class="form-control"
                                   value="<?php echo htmlspecialchars($edit_data['can_nang']); ?>" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>1 lần</label>
                            <input type="number" name="mot_lan" class="form-control"
                                   value="<?php echo intval($edit_data['mot_lan']); ?>" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Gói 5 lần</label>
                            <input type="number" name="goi_5_lan" class="form-control"
                                   value="<?php echo intval($edit_data['goi_5_lan']); ?>" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Gói 10 lần</label>
                            <input type="number" name="goi_10_lan" class="form-control"
                                   value="<?php echo intval($edit_data['goi_10_lan']); ?>" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Ưu đãi</label>
                            <input type="number" name="uu_dai" class="form-control"
                                   value="<?php echo intval($edit_data['uu_dai']); ?>" required>
                        </div>

                        <div class="form-group col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-warning btn-block">
                                Cập nhật
                            </button>
                        </div>
                    </div>

                    <a href="ho_boi.php" class="btn btn-secondary btn-sm">Hủy sửa</a>
                </form>

            <?php } else { ?>

                <h5 class="mb-3 text-success">Thêm bảng giá hồ bơi mới</h5>

                <form method="POST" action="ho_boi.php">
                    <input type="hidden" name="form_action" value="add">

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label>Cân nặng</label>
                            <input type="text" name="can_nang" class="form-control" placeholder="< 5kg" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>1 lần</label>
                            <input type="number" name="mot_lan" class="form-control" placeholder="280000" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Gói 5 lần</label>
                            <input type="number" name="goi_5_lan" class="form-control" placeholder="1110000" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Gói 10 lần</label>
                            <input type="number" name="goi_10_lan" class="form-control" placeholder="2000000" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Ưu đãi</label>
                            <input type="number" name="uu_dai" class="form-control" placeholder="50000" required>
                        </div>

                        <div class="form-group col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-success btn-block">
                                Thêm
                            </button>
                        </div>
                    </div>
                </form>

            <?php } ?>
        </div>

    </div>
</div>

</body>
</html>