<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['user'])) { header("Location: dang_nhap.php"); exit; }

require_once __DIR__ . "/../config/ket_noi_csdl.php";

$from = $_GET["from"] ?? date("Y-m-01");
$to = $_GET["to"] ?? date("Y-m-d");

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $from)) $from = date("Y-m-01");
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $to)) $to = date("Y-m-d");

$stmt = $conn->prepare("
  SELECT 
    COALESCE(SUM(CASE WHEN trang_thai = 'DA_THANH_TOAN' THEN tong_tien ELSE 0 END),0) AS doanh_thu,
    COUNT(*) AS tong_don,
    SUM(CASE WHEN trang_thai = 'DA_THANH_TOAN' THEN 1 ELSE 0 END) AS da_thanh_toan
  FROM don_hang
  WHERE DATE(ngay_tao) BETWEEN ? AND ?
");
$stmt->bind_param("ss", $from, $to);
$stmt->execute();
$stats = $stmt->get_result()->fetch_assoc();

$stmt = $conn->prepare("
  SELECT dh.id, kh.ho_ten, kh.so_dien_thoai, dh.ngay_tao, dh.tong_tien, dh.trang_thai
  FROM don_hang dh
  LEFT JOIN khach_hang kh ON kh.id = dh.id_khach_hang
  WHERE DATE(dh.ngay_tao) BETWEEN ? AND ?
  ORDER BY dh.id DESC
");
$stmt->bind_param("ss", $from, $to);
$stmt->execute();
$orders = $stmt->get_result();
?>

<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<title>In báo cáo</title>

<style>
body{
  margin:0;
  padding:30px;
  font-family:Arial, sans-serif;
  background:#f8fafc;
  color:#0f172a;
}

.printPage{
  max-width:1000px;
  margin:0 auto;
  background:white;
  padding:36px;
  border-radius:20px;
  box-shadow:0 12px 35px rgba(15,23,42,.08);
}

.top{
  display:flex;
  justify-content:space-between;
  border-bottom:3px solid #2563eb;
  padding-bottom:18px;
  margin-bottom:24px;
}

.brand h1{
  margin:0;
  color:#2563eb;
}

.title{
  text-align:center;
  margin:24px 0;
}

.title h2{
  margin:0;
  font-size:30px;
}

.stats{
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:14px;
  margin-bottom:22px;
}

.stat{
  background:#eff6ff;
  border:1px solid #bfdbfe;
  border-radius:14px;
  padding:16px;
}

.stat b{
  display:block;
  font-size:24px;
  margin-top:8px;
}

table{
  width:100%;
  border-collapse:collapse;
}

th{
  background:#2563eb;
  color:white;
  padding:12px;
  border:1px solid #1d4ed8;
}

td{
  padding:11px;
  border:1px solid #e5e7eb;
}

.money{
  text-align:right;
  font-weight:bold;
}

.actions{
  text-align:center;
  margin-bottom:20px;
}

.btn{
  border:0;
  background:#2563eb;
  color:white;
  padding:12px 22px;
  border-radius:999px;
  font-weight:bold;
  cursor:pointer;
}

@media print{
  body{
    background:white;
    padding:0;
  }

  .actions{
    display:none;
  }

  .printPage{
    box-shadow:none;
    border-radius:0;
    max-width:none;
  }
}
</style>
</head>

<body>

<div class="actions">
  <button class="btn" onclick="window.print()">🖨️ In báo cáo</button>
</div>

<div class="printPage">
  <div class="top">
    <div class="brand">
      <h1>VuiPet Shop</h1>
      <p>Hệ thống quản lý cửa hàng thú cưng</p>
    </div>

    <div style="text-align:right">
      <b>Ngày in:</b> <?= date("d/m/Y H:i") ?><br>
      <b>Từ:</b> <?= htmlspecialchars($from) ?><br>
      <b>Đến:</b> <?= htmlspecialchars($to) ?>
    </div>
  </div>

  <div class="title">
    <h2>BÁO CÁO KINH DOANH</h2>
  </div>

  <div class="stats">
    <div class="stat">
      Doanh thu
      <b><?= number_format((float)$stats["doanh_thu"],0,",",".") ?>đ</b>
    </div>

    <div class="stat">
      Tổng đơn
      <b><?= (int)$stats["tong_don"] ?></b>
    </div>

    <div class="stat">
      Đã thanh toán
      <b><?= (int)$stats["da_thanh_toan"] ?></b>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th>Mã đơn</th>
        <th>Khách hàng</th>
        <th>SĐT</th>
        <th>Ngày tạo</th>
        <th>Tổng tiền</th>
        <th>Trạng thái</th>
      </tr>
    </thead>

    <tbody>
      <?php if ($orders && $orders->num_rows > 0): ?>
        <?php while($row = $orders->fetch_assoc()): ?>
          <tr>
            <td>#<?= (int)$row["id"] ?></td>
            <td><?= htmlspecialchars($row["ho_ten"] ?? "Khách lẻ") ?></td>
            <td><?= htmlspecialchars($row["so_dien_thoai"] ?? "-") ?></td>
            <td><?= htmlspecialchars($row["ngay_tao"]) ?></td>
            <td class="money"><?= number_format((float)$row["tong_tien"],0,",",".") ?>đ</td>
            <td><?= htmlspecialchars($row["trang_thai"]) ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="6" style="text-align:center">Không có đơn hàng trong khoảng thời gian này.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

</body>
</html>
