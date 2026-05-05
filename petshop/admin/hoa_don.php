<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['user'])) { header("Location: dang_nhap.php"); exit; }
$id = intval($_GET["id"] ?? 0);
include __DIR__ . "/_header.php";
?>

<div class="card" style="width:100%;max-width:none;margin:0">
  <div class="card__head">
    <h2>🧾 Hóa đơn #<?= $id ?></h2>
    <div class="row" style="flex:1;justify-content:flex-end">
      <button class="btn btn--ghost" onclick="window.print()">In</button>
      <a class="btn btn--ghost" href="/petshop/petshop/admin/don_hang.php">← Đơn hàng</a>
    </div>
  </div>

  <div class="card__body" id="wrap">
    <div class="muted">Đang tải...</div>
  </div>
</div>

<script>
const API = "api/api_don_hang.php?action=detail&id=<?= $id ?>";
const wrap = document.getElementById("wrap");

function money(n){
  return new Intl.NumberFormat('vi-VN').format(Number(n||0)) + " ₫";
}
function esc(s){ return String(s??"").replace(/[&<>"']/g,m=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m])); }

async function load(){
  const r = await fetch(API, { credentials:"same-origin" });
  const d = await r.json();
  if (!d.ok){ wrap.innerHTML = `<div class="toast err" style="display:block">Không tải được hóa đơn</div>`; return; }

  const don = d.don;
  const items = d.items || [];
  wrap.innerHTML = `
    <div style="display:flex;justify-content:space-between;gap:12px">
      <div>
        <div style="font-size:18px;font-weight:900">PETSHOP</div>
        <div class="muted">Hóa đơn bán hàng</div>
      </div>
      <div style="text-align:right">
        <div><b>Mã đơn:</b> #${don.id}</div>
        <div><b>Ngày:</b> ${esc(don.ngay_tao||"")}</div>
        <div><b>Trạng thái:</b> ${esc(don.trang_thai||"")}</div>
      </div>
    </div>

    <div class="hr"></div>

    <div>
      <div><b>Khách:</b> ${esc(don.ten_khach || "Khách lẻ")}</div>
      <div class="muted">${esc(don.sdt||"")}</div>
    </div>

    <div class="hr"></div>

    <div class="tableWrap">
      <table>
        <thead>
          <tr>
            <th>Sản phẩm</th>
            <th style="width:90px">SL</th>
            <th style="width:140px">Đơn giá</th>
            <th style="width:160px">Thành tiền</th>
          </tr>
        </thead>
        <tbody>
          ${items.map(it=>`
            <tr>
              <td>${esc(it.ten_san_pham||"")}</td>
              <td><b>${it.so_luong}</b></td>
              <td>${money(it.don_gia)}</td>
              <td><b>${money(Number(it.don_gia)*Number(it.so_luong))}</b></td>
            </tr>
          `).join("")}
        </tbody>
      </table>
    </div>

    <div class="hr"></div>

    <div style="max-width:420px;margin-left:auto">
      <div class="row" style="justify-content:space-between"><div class="muted">Tạm tính</div><b>${money(don.tam_tinh)}</b></div>
      <div class="row" style="justify-content:space-between;margin-top:6px"><div class="muted">Giảm giá</div><b>${money(don.giam_gia)}</b></div>
      <div class="row" style="justify-content:space-between;margin-top:6px;font-size:18px"><div style="font-weight:900">Tổng</div><div style="font-weight:900">${money(don.tong_tien)}</div></div>
    </div>
  `;
}
document.addEventListener("DOMContentLoaded", load);
</script>

<style>
@media print{
  .sidebar,.topbar{display:none !important;}
  .container{max-width:none !important;padding:0 !important;}
  .card{box-shadow:none !important;border:none !important;}
  .card__head{display:none !important;}
}
</style>

<?php include __DIR__ . "/_footer.php"; ?>
