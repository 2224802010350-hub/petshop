<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (
    !isset($_SESSION['user']) ||
    !is_array($_SESSION['user']) ||
    ($_SESSION['user']['vai_tro'] ?? '') !== 'admin'
) {
    header('Location: /petshop/petshop/admin/dang_nhap.php');
    exit;
}

include __DIR__ . "/_header.php";
require_once("../config/ket_noi_csdl.php");

$sql = "SELECT * FROM dat_dich_vu_spa ORDER BY ngay_tao DESC";
$result = $conn->query($sql);
?>

<style>
:root{
    --bg:#f3f6fb;
    --card:#fff;
    --text:#0f172a;
    --muted:#64748b;
    --line:#e2e8f0;
    --primary:#2563eb;
    --shadow:0 10px 30px rgba(15,23,42,.08);
    --radius:18px;
}

.lichSpaPage *{
    box-sizing:border-box;
}

.lichSpaPage{
    width:100%;
}

.lichSpaPage .wrap{
    width:100%;
    padding:0;
}

.lichSpaPage .hero{
    background:linear-gradient(135deg,#0f172a,#1e293b);
    border-radius:28px;
    padding:28px;
    color:white;
    margin-bottom:22px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:18px;
    box-shadow:0 18px 45px rgba(15,23,42,.18);
}

.lichSpaPage .hero h1{
    margin:0;
    font-size:34px;
    font-weight:900;
}

.lichSpaPage .hero p{
    margin:10px 0 0;
    color:#cbd5e1;
}

.lichSpaPage .heroBtn{
    background:#f97316;
    color:white;
    border:0;
    border-radius:999px;
    padding:13px 22px;
    font-weight:900;
    text-decoration:none;
    white-space:nowrap;
}

.lichSpaPage .stats{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:16px;
    margin-bottom:20px;
}

.lichSpaPage .statCard{
    background:white;
    border-radius:22px;
    padding:20px;
    box-shadow:var(--shadow);
    border:1px solid #eef2f7;
}

.lichSpaPage .statLabel{
    color:#64748b;
    font-size:14px;
    font-weight:700;
}

.lichSpaPage .statValue{
    font-size:30px;
    font-weight:900;
    margin-top:8px;
}

.lichSpaPage .card{
    background:white;
    border-radius:26px;
    box-shadow:var(--shadow);
    overflow:hidden;
    border:1px solid #eef2f7;
}

.lichSpaPage .cardHead{
    padding:20px 24px;
    border-bottom:1px solid #eef2f7;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.lichSpaPage .cardHead h2{
    margin:0;
    font-size:24px;
    font-weight:900;
}

.lichSpaPage .tableWrap{
    overflow:auto;
}

.lichSpaPage table{
    width:100%;
    border-collapse:collapse;
    min-width:1500px;
}

.lichSpaPage th{
    background:#f8fafc;
    color:#475569;
    font-size:14px;
    font-weight:900;
    padding:16px;
    border-bottom:1px solid #e5e7eb;
    text-align:center;
}

.lichSpaPage td{
    padding:16px;
    border-bottom:1px solid #eef2f7;
    text-align:center;
    vertical-align:middle;
}

.lichSpaPage tr:hover{
    background:#f8fbff;
}

.lichSpaPage .customer{
    font-weight:900;
    color:#0f172a;
}

.lichSpaPage .pet{
    color:#64748b;
    font-size:13px;
    margin-top:4px;
}

.lichSpaPage .status{
    display:inline-block;
    padding:8px 14px;
    border-radius:999px;
    font-weight:900;
    font-size:13px;
    white-space:nowrap;
}

.lichSpaPage .cho{
    background:#fff3cd;
    color:#856404;
}

.lichSpaPage .xacnhan{
    background:#dcfce7;
    color:#166534;
}

.lichSpaPage .hoanthanh{
    background:#dbeafe;
    color:#1d4ed8;
}

.lichSpaPage .huy{
    background:#fee2e2;
    color:#991b1b;
}

.lichSpaPage .actionWrap{
    display:flex;
    gap:6px;
    flex-wrap:wrap;
    justify-content:center;
}

.lichSpaPage .btn{
    border:0;
    border-radius:999px;
    padding:8px 14px;
    font-size:13px;
    font-weight:900;
    text-decoration:none;
    display:inline-block;
}

.lichSpaPage .btn-success{
    background:#16a34a;
    color:white;
}

.lichSpaPage .btn-primary{
    background:#2563eb;
    color:white;
}

.lichSpaPage .btn-warning{
    background:#f59e0b;
    color:white;
}

.lichSpaPage .btn-danger{
    background:#ef4444;
    color:white;
}

.lichSpaPage .empty{
    padding:30px;
    color:#64748b;
    font-weight:700;
}

@media(max-width:1100px){
    .lichSpaPage .stats{
        grid-template-columns:repeat(2,1fr);
    }
}

@media(max-width:700px){
    .lichSpaPage .hero{
        flex-direction:column;
        align-items:flex-start;
    }

    .lichSpaPage .stats{
        grid-template-columns:1fr;
    }
}
</style>

<div class="lichSpaPage">
<div class="wrap">

<div class="hero">
    <div>
        <h1>📅 Quản lý lịch hẹn Spa</h1>
        <p>Theo dõi lịch đặt dịch vụ spa, grooming và chăm sóc thú cưng.</p>
    </div>

    <a href="dashboard.php" class="heroBtn">
        ← Dashboard
    </a>
</div>

<?php
$total = 0;
$cho = 0;
$xacnhan = 0;
$hoanthanh = 0;

if ($result && $result->num_rows > 0) {
    $total = $result->num_rows;

    $result->data_seek(0);

    while($r = $result->fetch_assoc()){
        if($r['trang_thai'] == 'Chờ xác nhận') $cho++;
        if($r['trang_thai'] == 'Đã xác nhận') $xacnhan++;
        if($r['trang_thai'] == 'Đã hoàn thành') $hoanthanh++;
    }

    $result->data_seek(0);
}
?>

<div class="stats">
    <div class="statCard">
        <div class="statLabel">Tổng lịch hẹn</div>
        <div class="statValue"><?= $total ?></div>
    </div>

    <div class="statCard">
        <div class="statLabel">Chờ xác nhận</div>
        <div class="statValue"><?= $cho ?></div>
    </div>

    <div class="statCard">
        <div class="statLabel">Đã xác nhận</div>
        <div class="statValue"><?= $xacnhan ?></div>
    </div>

    <div class="statCard">
        <div class="statLabel">Hoàn thành</div>
        <div class="statValue"><?= $hoanthanh ?></div>
    </div>
</div>

<div class="card">

    <div class="cardHead">
        <h2>Danh sách lịch hẹn Spa</h2>
    </div>

    <div class="tableWrap">

        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Khách hàng</th>
                    <th>SĐT</th>
                    <th>Thú cưng</th>
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

                        <td><b><?= $stt++ ?></b></td>

                        <td>
                            <div class="customer">
                                <?= htmlspecialchars($row['ho_ten']) ?>
                            </div>

                            <div class="pet">
                                <?= htmlspecialchars($row['ten_thu_cung']) ?>
                            </div>
                        </td>

                        <td><?= htmlspecialchars($row['so_dien_thoai']) ?></td>

                        <td><?= htmlspecialchars($row['ten_thu_cung']) ?></td>

                        <td><?= htmlspecialchars($row['can_nang']) ?></td>

                        <td><?= htmlspecialchars($row['dich_vu_chinh']) ?></td>

                        <td>
                            <?= !empty($row['dich_vu_them'])
                                ? htmlspecialchars($row['dich_vu_them'])
                                : "Không có"; ?>
                        </td>

                        <td><?= date("d/m/Y", strtotime($row['ngay_dat'])) ?></td>

                        <td><?= date("H:i", strtotime($row['gio_dat'])) ?></td>

                        <td>
                            <?= !empty($row['ghi_chu'])
                                ? htmlspecialchars($row['ghi_chu'])
                                : "Không có"; ?>
                        </td>

                        <td>
                            <span class="status <?= $status_class ?>">
                                <?= htmlspecialchars($row['trang_thai']) ?>
                            </span>
                        </td>

                        <td><?= date("d/m/Y H:i", strtotime($row['ngay_tao'])) ?></td>

                        <td>

                            <div class="actionWrap">

                                <a href="xu_ly_lich_hen.php?action=xac_nhan&id=<?= $row['id'] ?>"
                                   class="btn btn-success">
                                    Xác nhận
                                </a>

                                <a href="xu_ly_lich_hen.php?action=hoan_thanh&id=<?= $row['id'] ?>"
                                   class="btn btn-primary">
                                    Hoàn thành
                                </a>

                                <a href="xu_ly_lich_hen.php?action=huy&id=<?= $row['id'] ?>"
                                   class="btn btn-warning">
                                    Hủy
                                </a>

                                <a href="xu_ly_lich_hen.php?action=xoa&id=<?= $row['id'] ?>"
                                   class="btn btn-danger"
                                   onclick="return confirm('Bạn có chắc muốn xóa lịch hẹn này không?')">
                                    Xóa
                                </a>

                            </div>

                        </td>

                    </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>
                    <td colspan="13" class="empty">
                        Chưa có lịch hẹn nào.
                    </td>
                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</div>
</div>

<?php include __DIR__ . "/_footer.php"; ?>