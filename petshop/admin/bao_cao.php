<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['user'])) { header("Location: dang_nhap.php"); exit; }
include __DIR__ . "/_header.php";
?>

<div class="card" style="width:100%;max-width:none;margin:0">
  <div class="card__head">
    <h2>📈 Báo cáo thống kê</h2>
  </div>

  <div class="card__body">

    <div class="report-hero">
      <div>
        <div class="hero-badge">PETSHOP REPORT</div>
        <h1>Báo cáo kinh doanh</h1>
        <p>Theo dõi doanh thu, đơn hàng, khách hàng và sản phẩm bán chạy theo ngày tháng.</p>
      </div>
      <div class="hero-money" id="heroDoanhThu">0 ₫</div>
    </div>

    <div class="reportFilterWrap">
      <div class="reportFilterLeft">
        <div class="filterBox">
          <label>📅 Từ ngày</label>
          <input type="date" id="fromDate">
        </div>

        <div class="filterBox">
          <label>📅 Đến ngày</label>
          <input type="date" id="toDate">
        </div>
      </div>

      <div class="reportFilterRight">
        <button class="reportBtn primary" onclick="loadReport()">📊 Xem báo cáo</button>
        <button class="reportBtn light" onclick="printReport()">🖨️ In báo cáo</button>
        <button class="reportBtn success" onclick="exportReport()">⬇️ Xuất CSV</button>
      </div>
    </div>

    <div class="toast" id="toast"></div>

    <div class="grid2" style="grid-template-columns: repeat(4, 1fr); gap:14px">
      <div class="card stat-card"><div class="muted">Doanh thu</div><h2 id="doanhThu">0 ₫</h2></div>
      <div class="card stat-card"><div class="muted">Tổng đơn hàng</div><h2 id="tongDon">0</h2></div>
      <div class="card stat-card"><div class="muted">Đã thanh toán</div><h2 id="donDaThanhToan">0</h2></div>
      <div class="card stat-card"><div class="muted">Chưa thanh toán</div><h2 id="donChuaThanhToan">0</h2></div>
      <div class="card stat-card"><div class="muted">Tổng khách hàng</div><h2 id="tongKhach">0</h2></div>
      <div class="card stat-card"><div class="muted">Tổng sản phẩm</div><h2 id="tongSanPham">0</h2></div>
      <div class="card stat-card"><div class="muted">Sắp hết hàng</div><h2 id="sapHetHang">0</h2></div>
      <div class="card stat-card"><div class="muted">Gợi ý</div><h2 id="goiYHomNay">Theo dõi tồn kho</h2></div>
    </div>

    <div style="height:18px"></div>

    <div class="grid2" style="grid-template-columns:1fr 1fr;gap:14px">
      <div class="card sub-card">
        <div class="card__head"><h3>Doanh thu theo ngày</h3></div>
        <div class="card__body"><div id="chartRevenue"></div></div>
      </div>

      <div class="card sub-card">
        <div class="card__head"><h3>Top sản phẩm bán chạy</h3></div>
        <div class="card__body">
          <div class="tableWrap">
            <table>
              <thead>
                <tr>
                  <th>Sản phẩm</th>
                  <th>SKU</th>
                  <th>SL bán</th>
                  <th>Doanh thu</th>
                </tr>
              </thead>
              <tbody id="topProducts"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div style="height:18px"></div>

    <div class="card sub-card">
      <div class="card__head"><h3>Top khách hàng mua nhiều</h3></div>
      <div class="card__body">
        <div class="tableWrap">
          <table>
            <thead>
              <tr>
                <th>Khách hàng</th>
                <th>Số điện thoại</th>
                <th>Số đơn</th>
                <th>Tổng mua</th>
              </tr>
            </thead>
            <tbody id="topCustomers"></tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>

<style>
.report-hero{
  margin-bottom:18px;
  padding:26px;
  border-radius:24px;
  background:linear-gradient(135deg,#0f172a,#2563eb);
  color:white;
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:18px;
  box-shadow:0 18px 45px rgba(37,99,235,.25);
}

.report-hero h1{
  margin:8px 0;
  font-size:34px;
}

.report-hero p{
  margin:0;
  color:#dbeafe;
}

.hero-badge{
  display:inline-block;
  padding:7px 12px;
  border-radius:999px;
  background:rgba(255,255,255,.15);
  font-weight:900;
  font-size:12px;
}

.hero-money{
  font-size:36px;
  font-weight:900;
  white-space:nowrap;
}

.reportFilterWrap{
  background:white;
  border-radius:26px;
  padding:22px;
  margin-bottom:20px;
  display:flex;
  justify-content:space-between;
  align-items:end;
  gap:20px;
  flex-wrap:wrap;
  border:1px solid #e5e7eb;
  box-shadow:0 12px 35px rgba(15,23,42,.06);
}

.reportFilterLeft{
  display:flex;
  gap:16px;
  flex-wrap:wrap;
}

.filterBox{
  display:flex;
  flex-direction:column;
  gap:8px;
}

.filterBox label{
  font-size:14px;
  font-weight:900;
  color:#334155;
}

.filterBox input{
  min-width:220px;
  height:52px;
  border-radius:16px;
  border:1px solid #dbe3ef;
  padding:0 16px;
  font-size:15px;
  font-weight:600;
  background:#f8fafc;
  transition:.2s;
}

.filterBox input:focus{
  outline:none;
  border-color:#2563eb;
  background:white;
  box-shadow:0 0 0 4px rgba(37,99,235,.12);
}

.reportFilterRight{
  display:flex;
  gap:12px;
  flex-wrap:wrap;
}

.reportBtn{
  border:none;
  border-radius:16px;
  height:52px;
  padding:0 22px;
  font-size:14px;
  font-weight:900;
  cursor:pointer;
  transition:.2s;
  display:flex;
  align-items:center;
  justify-content:center;
  gap:8px;
}

.reportBtn:hover{
  transform:translateY(-2px);
}

.reportBtn.primary{
  background:linear-gradient(135deg,#2563eb,#1d4ed8);
  color:white;
  box-shadow:0 10px 24px rgba(37,99,235,.22);
}

.reportBtn.light{
  background:#f8fafc;
  color:#0f172a;
  border:1px solid #e5e7eb;
}

.reportBtn.success{
  background:linear-gradient(135deg,#16a34a,#15803d);
  color:white;
  box-shadow:0 10px 24px rgba(22,163,74,.22);
}

.sub-card{
  box-shadow:none !important;
  border:1px solid #e5e7eb;
}

.stat-card{
  padding:18px;
  border:1px solid #e5e7eb;
  box-shadow:none !important;
  transition:.2s;
}

.stat-card:hover{
  transform:translateY(-5px);
  box-shadow:0 14px 35px rgba(15,23,42,.12) !important;
}

.stat-card h2{
  margin:8px 0 0;
  font-size:26px;
  color:#0f172a;
}

.bar-row{
  display:grid;
  grid-template-columns:120px 1fr 130px;
  align-items:center;
  gap:10px;
  margin-bottom:12px;
}

.bar-bg{
  height:18px;
  background:#e5e7eb;
  border-radius:999px;
  overflow:hidden;
}

.bar-fill{
  height:100%;
  background:#2563eb;
  border-radius:999px;
}

@media(max-width:1100px){
  .grid2{grid-template-columns:1fr !important}
  .report-hero{flex-direction:column;align-items:flex-start}
}

@media(max-width:900px){
  .reportFilterWrap{
    flex-direction:column;
    align-items:stretch;
  }

  .reportFilterLeft{
    width:100%;
  }

  .filterBox{
    flex:1;
  }

  .filterBox input{
    width:100%;
    min-width:unset;
  }

  .reportFilterRight{
    width:100%;
  }

  .reportBtn{
    flex:1;
  }
}
</style>

<script>
const API_REPORT = "api/api_bao_cao.php";
const toast = document.getElementById("toast");

function today(){
  const d = new Date();
  return d.toISOString().slice(0,10);
}

function firstDayThisMonth(){
  const d = new Date();
  d.setDate(1);
  return d.toISOString().slice(0,10);
}

document.getElementById("fromDate").value = firstDayThisMonth();
document.getElementById("toDate").value = today();

function getParams(){
  const from = document.getElementById("fromDate").value;
  const to = document.getElementById("toDate").value;
  return `from=${encodeURIComponent(from)}&to=${encodeURIComponent(to)}`;
}

function showToast(text, ok=true){
  toast.className = "toast " + (ok ? "ok" : "err");
  toast.style.display = "block";
  toast.innerText = text;
  setTimeout(() => toast.style.display = "none", 2400);
}

function money(n){
  return new Intl.NumberFormat("vi-VN").format(Number(n || 0)) + " ₫";
}

function esc(s){
  return String(s ?? "").replace(/[&<>"']/g, m => ({
    "&":"&amp;",
    "<":"&lt;",
    ">":"&gt;",
    '"':"&quot;",
    "'":"&#039;"
  })[m]);
}

async function loadReport(){
  try {
    const r = await fetch(API_REPORT + "?action=report&" + getParams() + "&t=" + Date.now(), {
      credentials:"same-origin",
      cache:"no-store"
    });

    const d = await r.json();

    if (!d.ok) {
      showToast(d.msg || "Không tải được báo cáo", false);
      return;
    }

    const s = d.stats || {};

    let goiY = "Hệ thống đang ổn định";
    if ((s.sap_het_hang || 0) > 0) goiY = "⚠️ Có sản phẩm sắp hết hàng";
    if ((s.don_chua_thanh_toan || 0) > 0) goiY = "💰 Có đơn chưa thanh toán";

    document.getElementById("goiYHomNay").innerText = goiY;
    document.getElementById("doanhThu").innerText = money(s.doanh_thu);
    document.getElementById("heroDoanhThu").innerText = money(s.doanh_thu);
    document.getElementById("tongDon").innerText = s.tong_don || 0;
    document.getElementById("donDaThanhToan").innerText = s.don_da_thanh_toan || 0;
    document.getElementById("donChuaThanhToan").innerText = s.don_chua_thanh_toan || 0;
    document.getElementById("tongKhach").innerText = s.tong_khach || 0;
    document.getElementById("tongSanPham").innerText = s.tong_san_pham || 0;
    document.getElementById("sapHetHang").innerText = s.sap_het_hang || 0;

    renderRevenueChart(d.doanh_thu_ngay || []);
    renderTopProducts(d.top_san_pham || []);
    renderTopCustomers(d.top_khach_hang || []);

  } catch (e) {
    showToast("Lỗi tải báo cáo", false);
  }
}

function renderRevenueChart(items){
  const box = document.getElementById("chartRevenue");

  if (!items.length) {
    box.innerHTML = `<div class="muted">Chưa có doanh thu.</div>`;
    return;
  }

  const max = Math.max(...items.map(x => Number(x.doanh_thu || 0)), 1);

  box.innerHTML = items.map(x => {
    const value = Number(x.doanh_thu || 0);
    const percent = Math.max(4, Math.round(value / max * 100));

    return `
      <div class="bar-row">
        <div><b>${esc(x.ngay)}</b></div>
        <div class="bar-bg"><div class="bar-fill" style="width:${percent}%"></div></div>
        <div style="text-align:right"><b>${money(value)}</b></div>
      </div>
    `;
  }).join("");
}

function renderTopProducts(items){
  const tbody = document.getElementById("topProducts");

  if (!items.length) {
    tbody.innerHTML = `<tr><td colspan="4">Chưa có dữ liệu</td></tr>`;
    return;
  }

  tbody.innerHTML = items.map(x => `
    <tr>
      <td><b>${esc(x.ten_san_pham)}</b></td>
      <td class="muted">${esc(x.ma_sku || "")}</td>
      <td><b>${x.so_luong_ban || 0}</b></td>
      <td><b>${money(x.doanh_thu)}</b></td>
    </tr>
  `).join("");
}

function renderTopCustomers(items){
  const tbody = document.getElementById("topCustomers");

  if (!items.length) {
    tbody.innerHTML = `<tr><td colspan="4">Chưa có dữ liệu</td></tr>`;
    return;
  }

  tbody.innerHTML = items.map(x => `
    <tr>
      <td><b>${esc(x.ho_ten)}</b></td>
      <td>${esc(x.so_dien_thoai || "")}</td>
      <td><b>${x.so_don || 0}</b></td>
      <td><b>${money(x.tong_mua)}</b></td>
    </tr>
  `).join("");
}

function printReport(){
  window.open("in_bao_cao.php?" + getParams(), "_blank");
}

function exportReport(){
  window.open(API_REPORT + "?action=export&" + getParams(), "_blank");
}

document.addEventListener("DOMContentLoaded", loadReport);
</script>

<?php include __DIR__ . "/_footer.php"; ?>