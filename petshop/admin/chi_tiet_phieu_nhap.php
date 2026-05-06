<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['user'])) { header("Location: dang_nhap.php"); exit; }

include __DIR__ . "/_header.php";
require_once __DIR__ . "/../config/ket_noi_csdl.php";

$id = (int)($_GET["id"] ?? 0);

$phieu = null;
if ($id > 0) {
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
}

if (!$phieu) {
    echo "<div class='card'><div class='card__body'>Không tìm thấy phiếu nhập.</div></div>";
    include __DIR__ . "/_footer.php";
    exit;
}

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

<style>
.detailImport{
  width:100%;
}

.importHero{
  background:linear-gradient(135deg,#0f172a,#1e293b);
  color:white;
  border-radius:26px;
  padding:26px;
  margin-bottom:22px;
  box-shadow:0 18px 45px rgba(15,23,42,.16);
  display:flex;
  justify-content:space-between;
  gap:18px;
  align-items:center;
}

.importHero h1{
  margin:0;
  font-size:32px;
  font-weight:900;
}

.importHero p{
  margin:8px 0 0;
  color:#cbd5e1;
}

.importActions{
  display:flex;
  gap:10px;
  flex-wrap:wrap;
}

.importBtn{
  display:inline-block;
  border:0;
  border-radius:999px;
  padding:13px 20px;
  font-weight:900;
  text-decoration:none;
  cursor:pointer;
}

.importBtn.orange{
  background:#f97316;
  color:white;
}

.importBtn.light{
  background:white;
  color:#0f172a;
}

.infoGrid{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:16px;
  margin-bottom:22px;
}

.infoCard{
  background:white;
  border-radius:22px;
  padding:18px;
  border:1px solid #eef2f7;
  box-shadow:0 12px 32px rgba(15,23,42,.07);
}

.infoLabel{
  color:#64748b;
  font-size:14px;
  font-weight:800;
  margin-bottom:8px;
}

.infoValue{
  color:#0f172a;
  font-size:18px;
  font-weight:900;
}

.importTableCard{
  background:white;
  border-radius:26px;
  border:1px solid #eef2f7;
  box-shadow:0 18px 45px rgba(15,23,42,.08);
  overflow:hidden;
}

.importTableHead{
  padding:20px 24px;
  border-bottom:1px solid #eef2f7;
  display:flex;
  justify-content:space-between;
  align-items:center;
}

.importTableHead h2{
  margin:0;
  font-size:24px;
  font-weight:900;
}

.importTableWrap{
  overflow:auto;
}

.importTable{
  width:100%;
  border-collapse:collapse;
  min-width:850px;
}

.importTable th{
  background:#f8fafc;
  color:#475569;
  padding:16px;
  text-align:left;
  border-bottom:1px solid #e5e7eb;
}

.importTable td{
  padding:16px;
  border-bottom:1px solid #eef2f7;
}

.productName{
  font-weight:900;
  color:#0f172a;
}

.productSku{
  color:#64748b;
  font-size:13px;
  margin-top:4px;
}

.money{
  font-weight:900;
  color:#f97316;
}

.importTotal{
  display:flex;
  justify-content:flex-end;
  padding:22px 24px;
  background:#fff7ed;
  font-size:24px;
  font-weight:900;
}

.status{
  display:inline-block;
  padding:8px 13px;
  border-radius:999px;
  font-weight:900;
  background:#e2e8f0;
  color:#334155;
}

.status.confirmed{
  background:#dcfce7;
  color:#166534;
}

.status.cancelled{
  background:#fee2e2;
  color:#991b1b;
}

@media(max-width:900px){
  .importHero{
    flex-direction:column;
    align-items:flex-start;
  }

  .infoGrid{
    grid-template-columns:1fr 1fr;
  }
}

@media(max-width:560px){
  .infoGrid{
    grid-template-columns:1fr;
  }
}
</style>

<div class="detailImport">
  <div class="importHero">
    <div>
      <h1>📦 Chi tiết phiếu nhập</h1>
      <p>Xem lại thông tin nhà cung cấp, sản phẩm nhập kho và tổng tiền.</p>
    </div>

    <div class="importActions">
      <a class="importBtn light" href="phieu_nhap.php">← Quay lại</a>
      <a class="importBtn orange" target="_blank" href="in_phieu_nhap.php?id=<?= $id ?>">🖨️ In phiếu</a>
    </div>
  </div>

  <div class="infoGrid">
    <div class="infoCard">
      <div class="infoLabel">Mã phiếu</div>
      <div class="infoValue"><?= htmlspecialchars($phieu["ma_phieu"] ?? ("PN#" . $id)) ?></div>
    </div>

    <div class="infoCard">
      <div class="infoLabel">Nhà cung cấp</div>
      <div class="infoValue"><?= htmlspecialchars($phieu["ten_nha_cung_cap"] ?? "-") ?></div>
    </div>

    <div class="infoCard">
      <div class="infoLabel">Ngày nhập</div>
      <div class="infoValue"><?= htmlspecialchars($phieu["ngay_nhap"] ?? "-") ?></div>
    </div>

    <div class="infoCard">
      <div class="infoLabel">Trạng thái</div>
      <div class="infoValue">
        <span class="status <?= htmlspecialchars($phieu["trang_thai"] ?? "") ?>">
          <?= htmlspecialchars($phieu["trang_thai"] ?? "draft") ?>
        </span>
      </div>
    </div>
  </div>

  <div class="importTableCard">
    <div class="importTableHead">
      <h2>Danh sách sản phẩm nhập</h2>
    </div>

    <div class="importTableWrap">
      <table class="importTable">
        <thead>
          <tr>
            <th style="width:60px">STT</th>
            <th>Sản phẩm</th>
            <th style="width:130px">Số lượng</th>
            <th style="width:180px">Giá nhập</th>
            <th style="width:190px">Thành tiền</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $i = 1;
          while($row = $ct->fetch_assoc()):
            $thanhTien = (int)$row["so_luong"] * (float)$row["gia_nhap"];
          ?>
            <tr>
              <td><b><?= $i++ ?></b></td>
              <td>
                <div class="productName"><?= htmlspecialchars($row["ten_san_pham"] ?? "Sản phẩm") ?></div>
                <div class="productSku">SKU: <?= htmlspecialchars($row["ma_sku"] ?? "—") ?></div>
              </td>
              <td><b><?= (int)$row["so_luong"] ?></b></td>
              <td><?= number_format((float)$row["gia_nhap"],0,",",".") ?>đ</td>
              <td class="money"><?= number_format($thanhTien,0,",",".") ?>đ</td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <div class="importTotal">
      Tổng tiền: <span style="color:#f97316;margin-left:10px"><?= number_format((float)$phieu["tong_tien"],0,",",".") ?>đ</span>
    </div>
  </div>
</div>

<?php include __DIR__ . "/_footer.php"; ?>