<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . "/../config/ket_noi_csdl.php";

$id = (int)($_GET["id"] ?? 0);

$stmt = $conn->prepare("
  SELECT pn.*, ncc.ten_nha_cung_cap, ncc.so_dien_thoai, ncc.dia_chi
  FROM phieu_nhap pn
  LEFT JOIN nha_cung_cap ncc ON pn.nha_cung_cap_id = ncc.id
  WHERE pn.id = ?
  LIMIT 1
");
$stmt->bind_param("i", $id);
$stmt->execute();
$phieu = $stmt->get_result()->fetch_assoc();

if (!$phieu) die("Không tìm thấy phiếu nhập.");

$stmt = $conn->prepare("
  SELECT ct.*, sp.ten_san_pham, sp.ma_sku
  FROM chi_tiet_phieu_nhap ct
  LEFT JOIN san_pham sp ON ct.san_pham_id = sp.id
  WHERE ct.phieu_nhap_id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$ct = $stmt->get_result();
?>

<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<title>In phiếu nhập</title>

<style>
*{box-sizing:border-box}

body{
  margin:0;
  padding:30px;
  font-family:Arial, sans-serif;
  color:#111827;
  background:#f8fafc;
}

.printPage{
  max-width:900px;
  margin:0 auto;
  background:white;
  padding:38px;
  border-radius:20px;
  box-shadow:0 12px 35px rgba(15,23,42,.08);
}

.printTop{
  display:flex;
  justify-content:space-between;
  border-bottom:3px solid #f97316;
  padding-bottom:18px;
  margin-bottom:22px;
}

.brand h1{
  margin:0;
  font-size:30px;
  color:#f97316;
}

.brand p{
  margin:6px 0 0;
  color:#64748b;
}

.printTitle{
  text-align:center;
  margin:24px 0;
}

.printTitle h2{
  margin:0;
  font-size:30px;
  letter-spacing:1px;
}

.infoGrid{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:12px 28px;
  margin-bottom:22px;
}

.infoItem{
  padding:12px 0;
  border-bottom:1px dashed #cbd5e1;
}

.infoItem b{
  display:inline-block;
  min-width:130px;
}

table{
  width:100%;
  border-collapse:collapse;
  margin-top:16px;
}

th{
  background:#f97316;
  color:white;
  padding:12px;
  border:1px solid #ea580c;
  text-align:left;
}

td{
  padding:12px;
  border:1px solid #e5e7eb;
}

.money{
  text-align:right;
  font-weight:bold;
}

.totalBox{
  margin-top:20px;
  display:flex;
  justify-content:flex-end;
}

.totalInner{
  width:320px;
  background:#fff7ed;
  border:1px solid #fed7aa;
  padding:16px;
  border-radius:14px;
  font-size:20px;
  font-weight:bold;
  display:flex;
  justify-content:space-between;
}

.signArea{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:60px;
  margin-top:50px;
  text-align:center;
}

.signBox{
  min-height:100px;
}

.printActions{
  text-align:center;
  margin-bottom:20px;
}

.printBtn{
  border:0;
  background:#f97316;
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

  .printPage{
    box-shadow:none;
    border-radius:0;
    max-width:none;
  }

  .printActions{
    display:none;
  }
}
</style>
</head>

<body>

<div class="printActions">
  <button class="printBtn" onclick="window.print()">🖨️ In phiếu nhập</button>
</div>

<div class="printPage">
  <div class="printTop">
    <div class="brand">
      <h1>VuiPet Shop</h1>
      <p>Hệ thống quản lý cửa hàng thú cưng</p>
    </div>

    <div style="text-align:right">
      <b>Mã phiếu:</b> <?= htmlspecialchars($phieu["ma_phieu"] ?? ("PN#" . $id)) ?><br>
      <b>Ngày in:</b> <?= date("d/m/Y H:i") ?>
    </div>
  </div>

  <div class="printTitle">
    <h2>PHIẾU NHẬP KHO</h2>
  </div>

  <div class="infoGrid">
    <div class="infoItem">
      <b>Nhà cung cấp:</b>
      <?= htmlspecialchars($phieu["ten_nha_cung_cap"] ?? "-") ?>
    </div>

    <div class="infoItem">
      <b>Ngày nhập:</b>
      <?= htmlspecialchars($phieu["ngay_nhap"] ?? "-") ?>
    </div>

    <div class="infoItem">
      <b>Số điện thoại:</b>
      <?= htmlspecialchars($phieu["so_dien_thoai"] ?? "-") ?>
    </div>

    <div class="infoItem">
      <b>Trạng thái:</b>
      <?= htmlspecialchars($phieu["trang_thai"] ?? "draft") ?>
    </div>

    <div class="infoItem" style="grid-column:1/-1">
      <b>Địa chỉ NCC:</b>
      <?= htmlspecialchars($phieu["dia_chi"] ?? "-") ?>
    </div>

    <div class="infoItem" style="grid-column:1/-1">
      <b>Ghi chú:</b>
      <?= htmlspecialchars($phieu["ghi_chu"] ?? "-") ?>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th style="width:60px">STT</th>
        <th>Sản phẩm</th>
        <th style="width:90px">SL</th>
        <th style="width:150px">Giá nhập</th>
        <th style="width:160px">Thành tiền</th>
      </tr>
    </thead>

    <tbody>
      <?php
      $i = 1;
      while($row = $ct->fetch_assoc()):
        $thanhTien = (int)$row["so_luong"] * (float)$row["gia_nhap"];
      ?>
      <tr>
        <td><?= $i++ ?></td>
        <td>
          <b><?= htmlspecialchars($row["ten_san_pham"] ?? "Sản phẩm") ?></b><br>
          <small>SKU: <?= htmlspecialchars($row["ma_sku"] ?? "—") ?></small>
        </td>
        <td><?= (int)$row["so_luong"] ?></td>
        <td class="money"><?= number_format((float)$row["gia_nhap"],0,",",".") ?>đ</td>
        <td class="money"><?= number_format($thanhTien,0,",",".") ?>đ</td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <div class="totalBox">
    <div class="totalInner">
      <span>Tổng tiền</span>
      <span><?= number_format((float)$phieu["tong_tien"],0,",",".") ?>đ</span>
    </div>
  </div>

  <div class="signArea">
    <div class="signBox">
      <b>Người lập phiếu</b><br>
      <small>(Ký và ghi rõ họ tên)</small>
    </div>

    <div class="signBox">
      <b>Nhà cung cấp</b><br>
      <small>(Ký và ghi rõ họ tên)</small>
    </div>
  </div>
</div>

</body>
</html>