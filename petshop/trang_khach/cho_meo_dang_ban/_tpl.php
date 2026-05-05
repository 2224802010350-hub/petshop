<?php
// expects: $pageTitle, $crumb, $items (array)
?>
<section class="vpPageTitle" style="padding:18px 0 10px;">
  <div class="muted" style="font-size:13px;margin-bottom:6px;">
    <?= htmlspecialchars($crumb) ?>
  </div>
  <h1 style="margin:0 0 8px; font-size:34px;"><?= htmlspecialchars($pageTitle) ?></h1>

  <div style="display:flex;justify-content:flex-end;gap:10px;align-items:center;margin-top:10px;">
    <select style="padding:10px 12px;border:1px solid #e5e7eb;border-radius:12px;">
      <option>Sort by latest</option>
      <option>Giá tăng dần</option>
      <option>Giá giảm dần</option>
    </select>
  </div>
</section>

<section class="section" style="padding:8px 0 30px;">
  <div style="
    background:#f8fafc;
    border:1px solid #e5e7eb;
    border-radius:18px;
    padding:18px;
  ">
    <div class="petGrid">

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
          <div style="position:relative;">
            <img src="<?= htmlspecialchars($it['img']) ?>" alt=""
                 style="width:100%;height:220px;object-fit:cover;display:block;"
                 onerror="this.src='/petshop/petshop/uploads/products/1769097854_e35a86db.jpg'; this.onerror=null;">
            <?php if(!empty($it['badge'])): ?>
              <div style="
                position:absolute;left:10px;top:10px;
                background:#0b74ff;color:#fff;
                padding:6px 10px;border-radius:10px;
                font-weight:800;font-size:12px;
              "><?= htmlspecialchars($it['badge']) ?></div>
            <?php endif; ?>
          </div>

          <div style="padding:12px 12px 14px;">
            <div style="font-weight:900;margin-bottom:6px;"><?= htmlspecialchars($it['name']) ?></div>
            <div style="font-weight:900;color:#0f172a;"><?= htmlspecialchars($it['price']) ?></div>
          </div>
        </a>
      <?php endforeach; ?>

    </div>
  </div>

  <style>
    .petGrid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;}
    @media (max-width:1100px){ .petGrid{ grid-template-columns:repeat(3,1fr); } }
    @media (max-width:850px){  .petGrid{ grid-template-columns:repeat(2,1fr); } }
    @media (max-width:520px){  .petGrid{ grid-template-columns:1fr; } }
  </style>
</section>
