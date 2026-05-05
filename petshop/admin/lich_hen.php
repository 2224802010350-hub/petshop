<?php
include("../config/ket_noi_csdl.php");

$sql = "SELECT * FROM dat_dich_vu_spa ORDER BY ngay_tao DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý lịch hẹn Spa</title>

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
            white-space: nowrap;
        }

        td {
            text-align: center;
            vertical-align: middle;
            font-size: 14px;
        }

        .table-wrap {
            overflow-x: auto;
        }

        .status {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
            white-space: nowrap;
        }

        .cho {
            background: #fff3cd;
            color: #856404;
        }

        .xacnhan {
            background: #d4edda;
            color: #155724;
        }

        .hoanthanh {
            background: #d1ecf1;
            color: #0c5460;
        }

        .huy {
            background: #f8d7da;
            color: #721c24;
        }

        .btn-action {
            margin: 2px;
            font-size: 12px;
            border-radius: 15px;
            padding: 5px 10px;
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="box">

        <h3>📅 QUẢN LÝ LỊCH HẸN DỊCH VỤ SPA</h3>

        <div class="mb-3">
            <a href="dashboard.php" class="btn btn-secondary">
                Quay lại dashboard
            </a>
        </div>

        <div class="table-wrap">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Họ tên</th>
                        <th>SĐT</th>
                        <th>Tên thú cưng</th>
                        <th>Cân nặng</th>
                        <th>Dịch vụ chính</th>
                        <th>Dịch vụ thêm</th>
                        <th>Ngày đặt</th>
                        <th>Giờ đặt</th>
                        <th>Ghi chú</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Xử lý</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if ($result && $result->num_rows > 0) { ?>
                        <?php $stt = 1; ?>
                        <?php while ($row = $result->fetch_assoc()) { ?>

                            <?php
                            $status_class = "cho";

                            if ($row['trang_thai'] == "Đã xác nhận") {
                                $status_class = "xacnhan";
                            } elseif ($row['trang_thai'] == "Đã hoàn thành") {
                                $status_class = "hoanthanh";
                            } elseif ($row['trang_thai'] == "Đã hủy") {
                                $status_class = "huy";
                            }
                            ?>

                            <tr>
                                <td><?php echo $stt++; ?></td>

                                <td><?php echo htmlspecialchars($row['ho_ten']); ?></td>

                                <td><?php echo htmlspecialchars($row['so_dien_thoai']); ?></td>

                                <td><?php echo htmlspecialchars($row['ten_thu_cung']); ?></td>

                                <td><?php echo htmlspecialchars($row['can_nang']); ?></td>

                                <td><?php echo htmlspecialchars($row['dich_vu_chinh']); ?></td>

                                <td>
                                    <?php
                                    echo !empty($row['dich_vu_them'])
                                        ? htmlspecialchars($row['dich_vu_them'])
                                        : "Không có";
                                    ?>
                                </td>

                                <td><?php echo date("d/m/Y", strtotime($row['ngay_dat'])); ?></td>

                                <td><?php echo date("H:i", strtotime($row['gio_dat'])); ?></td>

                                <td>
                                    <?php
                                    echo !empty($row['ghi_chu'])
                                        ? htmlspecialchars($row['ghi_chu'])
                                        : "Không có";
                                    ?>
                                </td>

                                <td>
                                    <span class="status <?php echo $status_class; ?>">
                                        <?php echo htmlspecialchars($row['trang_thai']); ?>
                                    </span>
                                </td>

                                <td><?php echo date("d/m/Y H:i", strtotime($row['ngay_tao'])); ?></td>

                                <td style="min-width: 220px;">
                                    <a href="xu_ly_lich_hen.php?action=xac_nhan&id=<?php echo $row['id']; ?>"
                                       class="btn btn-success btn-sm btn-action">
                                        Xác nhận
                                    </a>

                                    <a href="xu_ly_lich_hen.php?action=hoan_thanh&id=<?php echo $row['id']; ?>"
                                       class="btn btn-primary btn-sm btn-action">
                                        Hoàn thành
                                    </a>

                                    <a href="xu_ly_lich_hen.php?action=huy&id=<?php echo $row['id']; ?>"
                                       class="btn btn-warning btn-sm btn-action">
                                        Hủy
                                    </a>

                                    <a href="xu_ly_lich_hen.php?action=xoa&id=<?php echo $row['id']; ?>"
                                       class="btn btn-danger btn-sm btn-action"
                                       onclick="return confirm('Bạn có chắc muốn xóa lịch hẹn này không?')">
                                        Xóa
                                    </a>
                                </td>
                            </tr>

                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="13" class="text-danger">
                                Chưa có lịch hẹn nào.
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>