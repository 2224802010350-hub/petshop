<?php
require_once __DIR__ . "/../../config/ket_noi_csdl.php";

$CATEGORY_ID = isset($CATEGORY_ID) ? (int)$CATEGORY_ID : 0;
$PAGE_TITLE = $PAGE_TITLE ?? "Sản phẩm";

if ($CATEGORY_ID <= 0) {
  echo "<div style='max-width:1200px;margin:40px auto;padding:20px'>Chưa chọn danh mục.</div>";
  return;
}

$stmt = $conn->prepare("
  SELECT id, ten_san_pham, gia_ban, hinh_anh, mo_ta, ton_kho
  FROM san_pham
  WHERE id_danh_muc = ?
    AND trang_thai = 1
  ORDER BY id DESC
");

$stmt->bind_param("i", $CATEGORY_ID);
$stmt->execute();
$rs = $stmt->get_result();

function product_img_url($filename) {
  $filename = trim((string)$filename);

  if ($filename === "") {
    return "/petshop/petshop/assets/uploads/products/no-image.jpg";
  }

  if (preg_match('#^https?://#i', $filename)) {
    return $filename;
  }

  if (str_starts_with($filename, "/")) {
    return $filename;
  }

  return "/petshop/petshop/assets/uploads/products/" . rawurlencode($filename);
}
?>

<style>
.productWrap{
  max-width:1200px;
  margin:45px auto;
  padding:0 20px;
}

.productTitle{
  font-size:34px;
  font-weight:900;
  color:#1f2937;
  margin-bottom:8px;
}

.productSub{
  color:#64748b;
  margin-bottom:26px;
}

.productGrid{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:22px;
}

.productCard{
  background:white;
  border-radius:22px;
  padding:14px;
  box-shadow:0 14px 35px rgba(15,23,42,.08);
  border:1px solid #eef2f7;
}

.productCard img{
  width:100%;
  height:210px;
  object-fit:cover;
  border-radius:18px;
  background:#f1f5f9;
}

.productCard h3{
  font-size:17px;
  margin:12px 0 8px;
  color:#111827;
  min-height:46px;
}

.productPrice{
  color:#f97316;
  font-weight:900;
  font-size:19px;
}

.productStock{
  color:#64748b;
  font-size:14px;
  margin-top:6px;
}

.productBtn{
  display:block;
  margin-top:12px;
  text-align:center;
  padding:11px;
  border-radius:999px;
  background:#f97316;
  color:white;
  text-decoration:none;
  font-weight:900;
}

.emptyBox{
  padding:20px;
  background:white;
  border-radius:18px;
  border:1px solid #e5e7eb;
  color:#64748b;
}

@media(max-width:900px){
  .productGrid{grid-template-columns:repeat(2,1fr)}
}

@media(max-width:520px){
  .productGrid{grid-template-columns:1fr}
}
</style>

<section class="productWrap">
  <h1 class="productTitle"><?= htmlspecialchars($PAGE_TITLE) ?></h1>
  
  <?php if ($rs->num_rows === 0): ?>
    <div class="emptyBox">
      Chưa có sản phẩm trong danh mục này. Vào Admin → Sản phẩm → chọn đúng danh mục rồi lưu.
    </div>
  <?php else: ?>
    <div class="productGrid">
      <?php while($sp = $rs->fetch_assoc()): ?>
        <div class="productCard">
          <img
            src="<?= htmlspecialchars(product_img_url($sp["hinh_anh"] ?? "")) ?>"
            alt="<?= htmlspecialchars($sp["ten_san_pham"]) ?>"
            onerror="this.src='/petshop/petshop/assets/uploads/products/no-image.jpg';">

          <h3><?= htmlspecialchars($sp["ten_san_pham"]) ?></h3>

          <div class="productPrice">
            <?= number_format((int)$sp["gia_ban"], 0, ",", ".") ?>đ
          </div>

          <div class="productStock">
            Tồn kho: <?= (int)$sp["ton_kho"] ?>
          </div>

          <a class="productBtn" href="/petshop/petshop/trang_khach/chi_tiet.php?id=<?= (int)$sp["id"] ?>">
            Xem chi tiết
          </a>
        </div>
      <?php endwhile; ?>
    </div>
  <?php endif; ?>
</section>