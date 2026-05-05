<?php
// expects: $pageTitle, $crumb, $items (array)
?>
<section class="vpPageTitle" style="padding:18px 0 10px;">
  <div class="muted" style="font-size:13px;margin-bottom:6px;">
    <?= htmlspecialchars($crumb) ?>
  </div>
  <h1 style="margin:0 0 10px; font-size:34px;"><?= htmlspecialchars($pageTitle) ?></h1>

  <div style="
    border-radius:18px;
    border:1px solid #e5e7eb;
    padding:18px;
    background:
      radial-gradient(circle at 30px 30px, rgba(14,165,165,.08), transparent 40%),
      radial-gradient(circle at 200px 90px, rgba(249,115,22,.10), transparent 35%),
      #fff;
  ">
    <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
      <div style="font-weight:1000;font-size:28px;letter-spacing:.4px;">THỨC ĂN & PHỤ KIỆN</div>
      <a href="/petshop/petshop/trang_khach/shop_thu_cung/index.php"
         style="padding:10px 12px;border-radius:12px;border:1px solid #e5e7eb;text-decoration:none;font-weight:900;">
        XEM TẤT CẢ >>
      </a>
    </div>
  </div>
</section>

<section class="section" style="padding:12px 0 30px;">
  <div style="
    background:#f8fafc;
    border:1px solid #e5e7eb;
    border-radius:18px;
    padding:18px;
  ">
    <div class="shopGrid">

      <?php foreach($items as $it): ?>
        <a href="<?= htmlspecialchars($it['href']) ?>" style="
          display:block;
          background:#fff;
          border:1px solid #e5e7eb;
          border-radius:14px;
          overflow:hidden;
          text-decoration:none;
          color:#0f172a;
        ">
          <img src="<?= htmlspecialchars($it['img']) ?>" alt=""
               style="width:100%;height:220px;object-fit:cover;display:block;"
               onerror="this.src='/petshop/petshop/uploads/products/1769097934_ac9dfd64.webp'; this.onerror=null;">

          <div style="padding:12px 12px 14px;">
            <div style="font-weight:900;margin-bottom:6px;"><?= htmlspecialchars($it['name']) ?></div>
            <div style="font-weight:900;color:#0f172a;"><?= htmlspecialchars($it['price']) ?></div>
          </div>
        </a>
      <?php endforeach; ?>

    </div>
  </div>

  <style>
    .shopGrid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;}
    @media (max-width:1100px){ .shopGrid{ grid-template-columns:repeat(3,1fr);} }
    @media (max-width:850px){  .shopGrid{ grid-template-columns:repeat(2,1fr);} }
    @media (max-width:520px){  .shopGrid{ grid-template-columns:1fr;} }
  </style>
</section>
