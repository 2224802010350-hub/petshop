<?php include __DIR__ . "/header.php"; ?>
<?php require_once __DIR__ . "/../config/ket_noi_csdl.php"; ?>

<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$sp = null;
$db_error = "";

if ($id > 0 && isset($conn) && $conn instanceof mysqli) {
    try {
        $sql = "SELECT id, ten_san_pham, gia_ban, hinh_anh, mo_ta, ton_kho
                FROM san_pham
                WHERE id = ? AND trang_thai = 1
                LIMIT 1";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $res = $stmt->get_result();
            $sp = $res->fetch_assoc();
            $stmt->close();
        }
    } catch (Throwable $e) {
        $db_error = $e->getMessage();
    }
}

if (!$sp) {
    $sp = [
        "ten_san_pham" => "Chó Bichon",
        "gia_ban" => 8500000,
        "hinh_anh" => "https://vuipet.com/wp-content/uploads/2024/06/ban-cho-bichon-dep-vuipet-1-800x800.jpg",
        "mo_ta" => "Mô tả chi tiết về thú cưng hoặc sản phẩm ở đây.",
        "ton_kho" => 0
    ];
}

function detail_img_url($filename) {
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

$ten = $sp["ten_san_pham"] ?? "Sản phẩm";
$gia = (int)($sp["gia_ban"] ?? 0);
$hinh = detail_img_url($sp["hinh_anh"] ?? "");
$moTa = $sp["mo_ta"] ?? "";
$tonKho = (int)($sp["ton_kho"] ?? 0);
?>

<style>
.detailWrap{
  max-width:1200px;
  margin:40px auto;
  padding:0 20px;
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:34px;
}

.detailGallery{
  background:#fff;
  border-radius:24px;
  padding:18px;
  box-shadow:0 14px 38px rgba(15,23,42,.08);
  border:1px solid #eef2f7;
}

.detailGallery img{
  width:100%;
  height:470px;
  object-fit:cover;
  border-radius:20px;
  background:#f1f5f9;
}

.detailInfo{
  background:#fff;
  border-radius:24px;
  padding:30px;
  box-shadow:0 14px 38px rgba(15,23,42,.08);
  border:1px solid #eef2f7;
}

.sectionTag{
  display:inline-block;
  padding:8px 13px;
  border-radius:999px;
  background:#fff7ed;
  color:#ea580c;
  font-weight:900;
  font-size:13px;
}

.detailInfo h1{
  margin:14px 0;
  font-size:34px;
  color:#111827;
}

.detailPrice{
  font-size:30px;
  font-weight:900;
  color:#f97316;
  margin-bottom:12px;
}

.detailStock{
  color:#64748b;
  margin-bottom:18px;
}

.detailInfo p{
  color:#334155;
  line-height:1.8;
}

.detailNotice{
  background:#fff7ed;
  border:1px solid #fed7aa;
  color:#c2410c;
  padding:12px 14px;
  border-radius:14px;
  margin-bottom:14px;
  font-weight:800;
}

.detailActions{
  display:flex;
  gap:12px;
  margin-top:24px;
  flex-wrap:wrap;
}

.btnPrimary,
.btnOutline{
  padding:13px 20px;
  border-radius:999px;
  text-decoration:none;
  font-weight:900;
}

.btnPrimary{
  background:#f97316;
  color:white;
}

.btnOutline{
  border:1px solid #f97316;
  color:#f97316;
  background:white;
}

@media(max-width:850px){
  .detailWrap{
    grid-template-columns:1fr;
  }
}
</style>

<section class="detailWrap">
  <div class="detailGallery">
    <img
      src="<?php echo htmlspecialchars($hinh); ?>"
      alt="<?php echo htmlspecialchars($ten); ?>"
      onerror="this.src='/petshop/petshop/assets/uploads/products/no-image.jpg';">
  </div>

  <div class="detailInfo">
    <span class="sectionTag">Chi tiết sản phẩm</span>

    <h1><?php echo htmlspecialchars($ten); ?></h1>

    <div class="detailPrice">
      <?php echo number_format($gia, 0, ",", "."); ?>đ
    </div>

    <div class="detailStock">
      Tồn kho: <b><?php echo $tonKho; ?></b>
    </div>

    <?php if (!empty($db_error)): ?>
      <div class="detailNotice">
        DB đang lỗi, trang hiện dữ liệu mẫu.
      </div>
    <?php endif; ?>

    <p><?php echo nl2br(htmlspecialchars($moTa)); ?></p>

    <div class="detailActions">
      <a href="gio_hang.php" class="btnPrimary">Thêm vào giỏ</a>
      <a href="lien_he.php" class="btnOutline">Liên hệ tư vấn</a>
    </div>
  </div>
</section>

</main>
</body>
</html>