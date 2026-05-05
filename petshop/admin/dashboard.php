<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['user'])) { header("Location: dang_nhap.php"); exit; }
include __DIR__ . "/_header.php";
?>

<style>
.dash-hero{
  padding:28px;
  border-radius:26px;
  background:linear-gradient(135deg,#0f172a,#2563eb);
  color:white;
  margin-bottom:20px;
  box-shadow:0 18px 45px rgba(37,99,235,.25);
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:18px;
}
.dash-hero h1{margin:8px 0;font-size:34px}
.dash-hero p{margin:0;color:#dbeafe}
.hero-badge{
  display:inline-block;
  padding:7px 12px;
  border-radius:999px;
  background:rgba(255,255,255,.16);
  font-size:12px;
  font-weight:900;
}
.hero-time{
  text-align:right;
  font-size:14px;
  color:#dbeafe;
}
.hero-money{
  font-size:30px;
  font-weight:900;
  color:#fff;
  margin-top:8px;
}
.dash-grid4{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:16px;
  margin-bottom:18px;
}
.dash-card{
  background:#fff;
  border-radius:20px;
  padding:20px;
  border:1px solid #e5e7eb;
  box-shadow:0 10px 28px rgba(15,23,42,.08);
  transition:.2s;
}
.dash-card:hover{
  transform:translateY(-5px);
  box-shadow:0 18px 38px rgba(15,23,42,.13);
}
.dash-icon{font-size:30px}
.dash-label{color:#64748b;margin-top:8px}
.dash-value{font-size:28px;font-weight:900;margin-top:6px;color:#0f172a}
.dash-sub{color:#94a3b8;font-size:13px;margin-top:4px}
.dash-grid2{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:16px;
  margin-bottom:18px;
}
.section-title{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:12px;
}
.section-title h3{margin:0}
.quick-grid{
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:16px;
}
.quick-card{
  text-decoration:none;
  color:#0f172a;
  background:#fff;
  border-radius:20px;
  padding:20px;
  border:1px solid #e5e7eb;
  box-shadow:0 10px 28px rgba(15,23,42,.08);
  transition:.2s;
}
.quick-card:hover{
  transform:translateY(-5px);
  border-color:#2563eb;
}
.quick-icon{font-size:32px}
.quick-card h3{margin:10px 0 6px}
.quick-card p{margin:0;color:#64748b}
.status-pill{
  padding:6px 10px;
  border-radius:999px;
  background:#eef2ff;
  color:#1d4ed8;
  font-weight:800;
  font-size:12px;
}
.low-stock{
  color:#dc2626;
  font-weight:900;
}
@media(max-width:1100px){
  .dash-grid4{grid-template-columns:repeat(2,1fr)}
  .quick-grid{grid-template-columns:repeat(2,1fr)}
  .dash-grid2{grid-template-columns:1fr}
}
@media(max-width:700px){
  .dash-grid4,.quick-grid{grid-template-columns:1fr}
  .dash-hero{flex-direction:column;align-items:flex-start}
  .hero-time{text-align:left}
}
</style>

<div class="dash-hero">
  <div>
    <div class="hero-badge">PETSHOP ADMIN DASHBOARD</div>
    <h1>Xin chào, <?= htmlspecialchars($_SESSION['user']['ho_ten'] ?? 'Admin') ?> 👋</h1>
    <p>Quản lý nhanh doanh thu, đơn hàng, khách hàng, sản phẩm và tồn kho.</p>
  </div>
  <div class="hero-time">
    <div id="nowChip">...</div>
    <div class="hero-money" id="heroRevenue">0 ₫</div>
  </div>
</div>

<div class="dash-grid4">
  <div class="dash-card">
    <div class="dash-icon">👤</div>
    <div class="dash-label">Khách hàng</div>
    <div class="dash-value" id="k_kh">0</div>
    <div class="dash-sub">Tổng khách đã lưu</div>
  </div>

  <div class="dash-card">
    <div class="dash-icon">📦</div>
    <div class="dash-label">Sản phẩm</div>
    <div class="dash-value" id="k_sp">0</div>
    <div class="dash-sub">Sản phẩm đang quản lý</div>
  </div>

  <div class="dash-card">
    <div class="dash-icon">🧾</div>
    <div class="dash-label">Đơn hàng</div>
    <div class="dash-value" id="k_dh">0</div>
    <div class="dash-sub">Tổng đơn phát sinh</div>
  </div>

  <div class="dash-card">
    <div class="dash-icon">💰</div>
    <div class="dash-label">Doanh thu</div>
    <div class="dash-value" id="k_dt">0 ₫</div>
    <div class="dash-sub">Đơn đã thanh toán</div>
  </div>
</div>

<div class="dash-grid2">
  <div class="dash-card">
    <div class="dash-icon">📅</div>
    <div class="dash-label">Doanh thu hôm nay</div>
    <div class="dash-value" id="k_today">0 ₫</div>
    <div class="dash-sub">Tính theo đơn đã thanh toán</div>
  </div>

  <div class="dash-card">
    <div class="dash-icon">📈</div>
    <div class="dash-label">Doanh thu tháng này</div>
    <div class="dash-value" id="k_month">0 ₫</div>
    <div class="dash-sub">Tính theo tháng hiện tại</div>
  </div>
</div>

<div class="card" style="width:100%;max-width:none;margin-bottom:18px">
  <div class="card__head">
    <h2>⚡ Truy cập nhanh</h2>
  </div>
  <div class="card__body">
    <div class="quick-grid">
      <a class="quick-card" href="/petshop/petshop/admin/pos.php">
        <div class="quick-icon">🛒</div>
        <h3>POS tạo đơn</h3>
        <p>Tạo đơn tại quầy, chọn khách hàng và sản phẩm.</p>
      </a>

      <a class="quick-card" href="/petshop/petshop/admin/don_hang.php">
        <div class="quick-icon">🧾</div>
        <h3>Bán hàng / Đơn hàng</h3>
        <p>Xác nhận thanh toán, cập nhật giao hàng, in hóa đơn.</p>
      </a>

      <a class="quick-card" href="/petshop/petshop/admin/bao_cao.php">
        <div class="quick-icon">📈</div>
        <h3>Báo cáo thống kê</h3>
        <p>Xem doanh thu, top sản phẩm và top khách hàng.</p>
      </a>

      <a class="quick-card" href="/petshop/petshop/admin/khach_hang.php">
        <div class="quick-icon">👤</div>
        <h3>Khách hàng</h3>
        <p>Quản lý khách hàng và điểm thân thiết.</p>
      </a>

      <a class="quick-card" href="/petshop/petshop/admin/ton_kho.php">
        <div class="quick-icon">📊</div>
        <h3>Tồn kho</h3>
        <p>Theo dõi số lượng tồn và hàng sắp hết.</p>
      </a>

      <a class="quick-card" href="/petshop/petshop/admin/san_pham.php">
        <div class="quick-icon">📦</div>
        <h3>Sản phẩm</h3>
        <p>Thêm, sửa, xóa sản phẩm trong cửa hàng.</p>
      </a>
    </div>
  </div>
</div>

<div class="dash-grid2">
  <div class="dash-card">
    <div class="section-title">
      <h3>🧾 Đơn hàng gần đây</h3>
      <a class="btn-sm" href="/petshop/petshop/admin/don_hang.php">Xem tất cả</a>
    </div>
    <div style="overflow:auto">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Khách</th>
            <th>Trạng thái</th>
            <th>Tổng tiền</th>
            <th>Ngày</th>
          </tr>
        </thead>
        <tbody id="recentOrders">
          <tr><td colspan="5">Đang tải...</td></tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="dash-card">
    <div class="section-title">
      <h3>⚠️ Tồn kho thấp</h3>
      <a class="btn-sm" href="/petshop/petshop/admin/ton_kho.php">Quản lý kho</a>
    </div>
    <div class="muted" style="margin-bottom:8px">Ngưỡng cảnh báo: tồn kho ≤ 5</div>
    <div style="overflow:auto">
      <table>
        <thead>
          <tr>
            <th>SKU</th>
            <th>Sản phẩm</th>
            <th>Tồn</th>
          </tr>
        </thead>
        <tbody id="lowStock">
          <tr><td colspan="3">Đang tải...</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
function fmtMoney(n){
  return new Intl.NumberFormat('vi-VN').format(Number(n || 0)) + ' ₫';
}

function fmtDate(s){
  if(!s) return '';
  return String(s).replace('T',' ').slice(0,19);
}

function esc(s){
  return String(s ?? '').replace(/[&<>"']/g, m => ({
    '&':'&amp;',
    '<':'&lt;',
    '>':'&gt;',
    '"':'&quot;',
    "'":'&#039;'
  })[m]);
}

document.getElementById("nowChip").innerText =
  new Date().toLocaleString('vi-VN');

(async function(){
  try{
    const res = await fetch("/petshop/petshop/admin/api/api_dashboard.php?t=" + Date.now(), {
  credentials:"same-origin",
  cache:"no-store"
});
    const d = await res.json();

    document.getElementById("k_kh").innerText = d.counts?.khach_hang ?? 0;
    document.getElementById("k_sp").innerText = d.counts?.san_pham ?? 0;
    document.getElementById("k_dh").innerText = d.counts?.don_hang ?? 0;

    document.getElementById("k_dt").innerText = fmtMoney(d.revenue?.total_paid ?? 0);
    document.getElementById("heroRevenue").innerText = fmtMoney(d.revenue?.total_paid ?? 0);
    document.getElementById("k_today").innerText = fmtMoney(d.revenue?.today_paid ?? 0);
    document.getElementById("k_month").innerText = fmtMoney(d.revenue?.month_paid ?? 0);

    const ro = document.getElementById("recentOrders");
    if (!d.recent_orders || d.recent_orders.length === 0){
      ro.innerHTML = `<tr><td colspan="5">Chưa có đơn hàng</td></tr>`;
    } else {
      ro.innerHTML = d.recent_orders.map(o => `
        <tr>
          <td><b>#${esc(o.id)}</b></td>
          <td>${esc(o.khach || 'Khách lẻ')}</td>
          <td><span class="status-pill">${esc(o.trang_thai || '')}</span></td>
          <td><b>${fmtMoney(o.tong_tien)}</b></td>
          <td>${esc(fmtDate(o.ngay_tao))}</td>
        </tr>
      `).join("");
    }

    const ls = document.getElementById("lowStock");
    if (!d.low_stock || d.low_stock.length === 0){
      ls.innerHTML = `<tr><td colspan="3">Không có sản phẩm sắp hết</td></tr>`;
    } else {
      ls.innerHTML = d.low_stock.map(p => `
        <tr>
          <td>${esc(p.ma_sku || '')}</td>
          <td><b>${esc(p.ten_san_pham || '')}</b></td>
          <td class="low-stock">${esc(p.ton_kho ?? 0)}</td>
        </tr>
      `).join("");
    }
  }catch(e){
    document.getElementById("recentOrders").innerHTML = `<tr><td colspan="5">Lỗi tải dữ liệu</td></tr>`;
    document.getElementById("lowStock").innerHTML = `<tr><td colspan="3">Lỗi tải dữ liệu</td></tr>`;
  }
})();
</script>

<?php include __DIR__ . "/_footer.php"; ?>