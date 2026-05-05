<?php
include("../config/ket_noi_csdl.php");

$action = $_GET['action'] ?? '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

/* XÓA */
if ($action == "delete" && $id > 0) {
    $stmt = $conn->prepare("DELETE FROM dich_vu_spa WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: Spa.php");
    exit();
}

/* THÊM */
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['form_action'] ?? '') == "add") {
    $can_nang = $_POST['can_nang'];
    $ve_sinh = intval($_POST['ve_sinh']);
    $spa_co_ban = intval($_POST['spa_co_ban']);
    $spa_full = intval($_POST['spa_full']);
    $grooming = intval($_POST['grooming']);

    $stmt = $conn->prepare("
        INSERT INTO dich_vu_spa 
        (can_nang, ve_sinh, spa_co_ban, spa_full, grooming)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("siiii", $can_nang, $ve_sinh, $spa_co_ban, $spa_full, $grooming);
    $stmt->execute();

    header("Location: Spa.php");
    exit();
}

/* SỬA */
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['form_action'] ?? '') == "edit") {
    $id = intval($_POST['id']);
    $can_nang = $_POST['can_nang'];
    $ve_sinh = intval($_POST['ve_sinh']);
    $spa_co_ban = intval($_POST['spa_co_ban']);
    $spa_full = intval($_POST['spa_full']);
    $grooming = intval($_POST['grooming']);

    $stmt = $conn->prepare("
        UPDATE dich_vu_spa 
        SET can_nang = ?, ve_sinh = ?, spa_co_ban = ?, spa_full = ?, grooming = ?
        WHERE id = ?
    ");
    $stmt->bind_param("siiiii", $can_nang, $ve_sinh, $spa_co_ban, $spa_full, $grooming, $id);
    $stmt->execute();

    header("Location: Spa.php");
    exit();
}

/* LẤY DỮ LIỆU ĐỂ SỬA */
$edit_data = null;

if ($action == "edit" && $id > 0) {
    $stmt = $conn->prepare("SELECT * FROM dich_vu_spa WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $edit_data = $stmt->get_result()->fetch_assoc();
}

/* LẤY DANH SÁCH */
$result = $conn->query("SELECT * FROM dich_vu_spa ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bảng giá Spa thú cưng</title>

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
            font-weight: bold;
            text-align: center;
            margin-bottom: 25px;
        }

        th {
            background: #00a6a6;
            color: white;
            text-align: center;
        }

        td {
            text-align: center;
            vertical-align: middle;
            font-weight: 600;
        }

        .form-box {
            background: #fff3d6;
            border-radius: 14px;
            padding: 22px;
            margin-top: 30px;
        }

        .price-note {
            color: #777;
            font-size: 14px;
            text-align: center;
            margin-top: 15px;
        }

        .btn {
            border-radius: 8px;
            font-weight: 600;
        }

        label {
            font-weight: 600;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="box">

        <h3>🐾 BẢNG GIÁ SPA THÚ CƯNG</h3>

        <!-- BẢNG GIÁ -->
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Cân nặng</th>
                    <th>Vệ sinh</th>
                    <th>Spa cơ bản</th>
                    <th>Spa Full</th>
                    <th>Grooming</th>
                    <th>Hành động</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($result && $result->num_rows > 0) { ?>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['can_nang']); ?></td>
                            <td><?php echo number_format($row['ve_sinh'] / 1000); ?></td>
                            <td><?php echo number_format($row['spa_co_ban'] / 1000); ?></td>
                            <td><?php echo number_format($row['spa_full'] / 1000); ?></td>
                            <td><?php echo number_format($row['grooming'] / 1000); ?></td>

                            <td>
                                <a href="Spa.php?action=edit&id=<?php echo $row['id']; ?>"
                                   class="btn btn-warning btn-sm">
                                    Sửa
                                </a>

                                <a href="Spa.php?action=delete&id=<?php echo $row['id']; ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Bạn có chắc muốn xóa dịch vụ này không?')">
                                    Xóa
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="6" class="text-danger">
                            Chưa có dữ liệu bảng giá.
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <p class="price-note">
            Đơn vị hiển thị: 150 = 150.000 VNĐ. Khi nhập giá, nhập đầy đủ: 150000.
        </p>

        <!-- FORM THÊM / SỬA ĐƯA XUỐNG DƯỚI -->
        <div class="form-box">
            <?php if ($edit_data) { ?>
                <h5 class="mb-3 text-warning">Sửa dịch vụ</h5>

                <form method="POST">
                    <input type="hidden" name="form_action" value="edit">
                    <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label>Cân nặng</label>
                            <input type="text" name="can_nang" class="form-control"
                                   value="<?php echo htmlspecialchars($edit_data['can_nang']); ?>" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Vệ sinh</label>
                            <input type="number" name="ve_sinh" class="form-control"
                                   value="<?php echo $edit_data['ve_sinh']; ?>" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Spa cơ bản</label>
                            <input type="number" name="spa_co_ban" class="form-control"
                                   value="<?php echo $edit_data['spa_co_ban']; ?>" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Spa Full</label>
                            <input type="number" name="spa_full" class="form-control"
                                   value="<?php echo $edit_data['spa_full']; ?>" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Grooming</label>
                            <input type="number" name="grooming" class="form-control"
                                   value="<?php echo $edit_data['grooming']; ?>" required>
                        </div>

                        <div class="form-group col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-warning btn-block">
                                Cập nhật
                            </button>
                        </div>
                    </div>

                    <a href="Spa.php" class="btn btn-secondary btn-sm">Hủy sửa</a>
                </form>

            <?php } else { ?>
                <h5 class="mb-3 text-success">Thêm dịch vụ mới</h5>

                <form method="POST">
                    <input type="hidden" name="form_action" value="add">

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label>Cân nặng</label>
                            <input type="text" name="can_nang" class="form-control" placeholder="< 3kg" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Vệ sinh</label>
                            <input type="number" name="ve_sinh" class="form-control" placeholder="150000" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Spa cơ bản</label>
                            <input type="number" name="spa_co_ban" class="form-control" placeholder="200000" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Spa Full</label>
                            <input type="number" name="spa_full" class="form-control" placeholder="300000" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Grooming</label>
                            <input type="number" name="grooming" class="form-control" placeholder="450000" required>
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
    <a href="/petshop/petshop/admin/dich_vu.php" style="text-decoration:none;">
    <button style="background-color:#4CAF50; color:white; padding:10px 20px; border:none; border-radius:5px; cursor:pointer;">
        Quay về trang trước
    </button>
</a>

</div>

</body>
</html>