<?php
include dirname(__DIR__) . "/header.php";
include dirname(dirname(__DIR__)) . "/config/ket_noi_csdl.php";

$so_dien_thoai = trim($_GET['so_dien_thoai'] ?? '');
$result = null;

if ($so_dien_thoai != '') {
    $search = "%" . $so_dien_thoai . "%";

    $sql = "SELECT * FROM dat_dich_vu_spa 
            WHERE so_dien_thoai LIKE ?
            ORDER BY ngay_tao DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<section style="padding:40px 20px; background:#fff8e8;">
    <div style="max-width:1000px; margin:auto; background:#fffdf3; padding:30px; border-radius:24px; box-shadow:0 8px 25px rgba(0,0,0,0.08);">

        <h2 style="text-align:center; color:#f58220; font-weight:800;">
            Tra cứu trạng thái lịch hẹn Spa
        </h2>

        <p style="text-align:center; color:#666;">
            Nhập số điện thoại đã dùng để đặt lịch.
        </p>

        <form method="GET" style="margin:25px 0; display:flex; gap:10px;">
            <input type="text" name="so_dien_thoai"
                   value="<?php echo htmlspecialchars($so_dien_thoai); ?>"
                   placeholder="Nhập số điện thoại, ví dụ: 0901234567"
                   required
                   style="flex:1; padding:13px; border:1px solid #ddd; border-radius:12px;">

            <button type="submit"
                    style="padding:13px 28px; border:none; border-radius:12px; background:#00a6a6; color:white; font-weight:bold;">
                Tra cứu
            </button>
        </form>

        <?php if ($so_dien_thoai != '') { ?>
            <?php if ($result && $result->num_rows > 0) { ?>

                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse; background:white;">
                        <thead>
                            <tr style="background:#00a6a6; color:white;">
                                <th style="padding:12px; border:1px solid #ddd;">Họ tên</th>
                                <th style="padding:12px; border:1px solid #ddd;">SĐT</th>
                                <th style="padding:12px; border:1px solid #ddd;">Thú cưng</th>
                                <th style="padding:12px; border:1px solid #ddd;">Cân nặng</th>
                                <th style="padding:12px; border:1px solid #ddd;">Dịch vụ chính</th>
                                <th style="padding:12px; border:1px solid #ddd;">Dịch vụ thêm</th>
                                <th style="padding:12px; border:1px solid #ddd;">Ngày</th>
                                <th style="padding:12px; border:1px solid #ddd;">Giờ</th>
                                <th style="padding:12px; border:1px solid #ddd;">Trạng thái</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td style="padding:12px; border:1px solid #ddd;">
                                        <?php echo htmlspecialchars($row['ho_ten']); ?>
                                    </td>

                                    <td style="padding:12px; border:1px solid #ddd;">
                                        <?php echo htmlspecialchars($row['so_dien_thoai']); ?>
                                    </td>

                                    <td style="padding:12px; border:1px solid #ddd;">
                                        <?php echo htmlspecialchars($row['ten_thu_cung']); ?>
                                    </td>

                                    <td style="padding:12px; border:1px solid #ddd;">
                                        <?php echo htmlspecialchars($row['can_nang']); ?>
                                    </td>

                                    <td style="padding:12px; border:1px solid #ddd;">
                                        <?php echo htmlspecialchars($row['dich_vu_chinh']); ?>
                                    </td>

                                    <td style="padding:12px; border:1px solid #ddd;">
                                        <?php echo !empty($row['dich_vu_them']) ? htmlspecialchars($row['dich_vu_them']) : "Không có"; ?>
                                    </td>

                                    <td style="padding:12px; border:1px solid #ddd;">
                                        <?php echo date("d/m/Y", strtotime($row['ngay_dat'])); ?>
                                    </td>

                                    <td style="padding:12px; border:1px solid #ddd;">
                                        <?php echo date("H:i", strtotime($row['gio_dat'])); ?>
                                    </td>

                                    <td style="padding:12px; border:1px solid #ddd; font-weight:bold; color:#f58220;">
                                        <?php echo htmlspecialchars($row['trang_thai']); ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            <?php } else { ?>
                <p style="color:red; text-align:center; font-weight:bold;">
                    Không tìm thấy lịch hẹn nào với số điện thoại này.
                </p>
            <?php } ?>
        <?php } ?>

        <div style="text-align:center; margin-top:25px;">
            <a href="dich_vu_spa.php"
               style="display:inline-block; padding:12px 25px; background:#f58220; color:white; border-radius:20px; text-decoration:none; font-weight:bold;">
                Quay lại đặt dịch vụ
            </a>
        </div>

    </div>
</section>

<?php include dirname(__DIR__) . "/footer_contact.php"; ?>

</main>
</body>
</html>