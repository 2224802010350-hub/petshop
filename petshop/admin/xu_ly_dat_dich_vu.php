<?php
include("../config/ket_noi_csdl.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../trang_khach/dich_vu/dich_vu_spa.php");
    exit();
}

$ma_tra_cuu = "DV" . time();

$ho_ten = trim($_POST['ho_ten'] ?? '');
$so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');
$ten_thu_cung = trim($_POST['ten_thu_cung'] ?? '');
$can_nang = trim($_POST['can_nang'] ?? '');
$dich_vu_chinh = trim($_POST['dich_vu_chinh'] ?? '');
$ngay_dat = trim($_POST['ngay_dat'] ?? '');
$gio_dat = trim($_POST['gio_dat'] ?? '');
$ghi_chu = trim($_POST['ghi_chu'] ?? '');

$loai_dich_vu = trim($_POST['loai_dich_vu'] ?? '');

if ($loai_dich_vu == '') {
    if (stripos($dich_vu_chinh, 'hồ bơi') !== false || stripos($dich_vu_chinh, 'sân chơi') !== false) {
        $loai_dich_vu = 'Hồ bơi - Sân chơi';
    } elseif (stripos($dich_vu_chinh, 'hotel') !== false || stripos($dich_vu_chinh, 'khách sạn') !== false || stripos($dich_vu_chinh, 'trông giữ') !== false) {
        $loai_dich_vu = 'Khách sạn thú cưng';
    } else {
        $loai_dich_vu = 'Spa thú cưng';
    }
}

$dich_vu_them = "";
if (isset($_POST['dich_vu_them']) && is_array($_POST['dich_vu_them'])) {
    $dich_vu_them = implode(", ", $_POST['dich_vu_them']);
}

if (
    $ho_ten == "" ||
    $so_dien_thoai == "" ||
    $ten_thu_cung == "" ||
    $can_nang == "" ||
    $dich_vu_chinh == "" ||
    $ngay_dat == "" ||
    $gio_dat == ""
) {
    echo "<script>
        alert('Vui lòng nhập đầy đủ thông tin đặt lịch!');
        window.history.back();
    </script>";
    exit();
}

$sql = "INSERT INTO dat_dich_vu_spa
        (ma_tra_cuu, ho_ten, so_dien_thoai, ten_thu_cung, can_nang, dich_vu_chinh, dich_vu_them, ngay_dat, gio_dat, ghi_chu, trang_thai)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Chờ xác nhận')";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "<script>
        alert('Lỗi SQL: " . addslashes($conn->error) . "');
        window.history.back();
    </script>";
    exit();
}

if ($ghi_chu != "") {
    $ghi_chu = "[Loại dịch vụ: " . $loai_dich_vu . "] " . $ghi_chu;
} else {
    $ghi_chu = "[Loại dịch vụ: " . $loai_dich_vu . "]";
}

$stmt->bind_param(
    "ssssssssss",
    $ma_tra_cuu,
    $ho_ten,
    $so_dien_thoai,
    $ten_thu_cung,
    $can_nang,
    $dich_vu_chinh,
    $dich_vu_them,
    $ngay_dat,
    $gio_dat,
    $ghi_chu
);

if ($stmt->execute()) {
    echo "<script>
        alert('Đặt lịch thành công! Admin sẽ xác nhận lịch hẹn của bạn.');
        window.location.href='../trang_khach/dich_vu/tra_cuu_lich_hen.php?so_dien_thoai=" . urlencode($so_dien_thoai) . "';
    </script>";
    exit();
} else {
    echo "<script>
        alert('Đặt lịch thất bại: " . addslashes($stmt->error) . "');
        window.history.back();
    </script>";
    exit();
}
?>