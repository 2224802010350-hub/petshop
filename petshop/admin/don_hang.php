<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['user'])) { header("Location: dang_nhap.php"); exit; }
include __DIR__ . "/_header.php";
?>

<div class="card" style="width:100%;max-width:none;margin:0">
  <div class="card__head">
    <h2>🧾 Bán hàng / Đơn hàng</h2>
    <div class="row" style="flex:1;justify-content:flex-end">
      <input class="input" id="q" placeholder="Tìm theo mã đơn / tên khách / SĐT..." style="max-width:360px">
      <a class="btn" href="/petshop/petshop/admin/pos.php">+ POS tạo đơn</a>
    </div>
  </div>

  <div class="card__body">
    <div class="toast" id="toast"></div>

    <div class="tableWrap">
      <table>
        <thead>
          <tr>
            <th style="width:90px">Mã đơn</th>
            <th style="width:180px">Ngày tạo</th>
            <th>Khách hàng</th>
            <th style="width:210px">Trạng thái giao hàng</th>
            <th style="width:190px">Phương thức TT</th>
            <th style="width:170px">Trạng thái TT</th>
            <th style="width:160px">Tổng tiền</th>
            <th style="width:360px">Hành động</th>
          </tr>
        </thead>
        <tbody id="list"></tbody>
      </table>
    </div>
  </div>
</div>

<script>
const API_DON = "api/api_don_hang.php";

const q = document.getElementById("q");
const list = document.getElementById("list");
const toast = document.getElementById("toast");

function showToast(text, ok=true){
  toast.className = "toast " + (ok ? "ok" : "err");
  toast.style.display = "block";
  toast.innerText = text;
  setTimeout(() => toast.style.display = "none", 2400);
}

function money(n){
  return new Intl.NumberFormat('vi-VN').format(Number(n || 0)) + " ₫";
}

function esc(s){
  return String(s ?? "").replace(/[&<>"']/g, m => ({
    '&':'&amp;',
    '<':'&lt;',
    '>':'&gt;',
    '"':'&quot;',
    "'":'&#039;'
  })[m]);
}

const SHIP_LABEL = {
  "DA_XAC_NHAN": "Đã xác nhận",
  "CHO_GIAO_HANG": "Chờ giao hàng",
  "GIAO_HANG_THANH_CONG": "Giao hàng thành công",
  "HUY": "Đã hủy"
};

const PAY_STATUS_LABEL = {
  "CHUA_THANH_TOAN": "Chưa thanh toán",
  "DA_THANH_TOAN": "Đã thanh toán",
  "HUY": "Đã hủy"
};

let ALL = [];

async function load(){
  const text = (q.value || "").trim();
  const ts = Date.now();
  const url = text
    ? `${API_DON}?action=list&q=${encodeURIComponent(text)}&t=${ts}`
    : `${API_DON}?action=list&t=${ts}`;

  try {
    const r = await fetch(url, { credentials:"same-origin", cache:"no-store" });
    const d = await r.json();

    if (!d.ok){
      list.innerHTML = `<tr><td colspan="8">${esc(d.msg || "Không tải được")}</td></tr>`;
      return;
    }

    ALL = d.items || [];
    render(ALL);
  } catch (e) {
    list.innerHTML = `<tr><td colspan="8">Lỗi tải đơn hàng</td></tr>`;
  }
}

function shipSelectHtml(order){
  const cur = order.trang_thai_giao_hang || "DA_XAC_NHAN";
  return `
    <select class="input" style="padding:9px 10px" onchange="updateShip(${order.id}, this.value)">
      <option value="DA_XAC_NHAN" ${cur==="DA_XAC_NHAN" ? "selected" : ""}>Đã xác nhận</option>
      <option value="CHO_GIAO_HANG" ${cur==="CHO_GIAO_HANG" ? "selected" : ""}>Chờ giao hàng</option>
      <option value="GIAO_HANG_THANH_CONG" ${cur==="GIAO_HANG_THANH_CONG" ? "selected" : ""}>Giao hàng thành công</option>
      <option value="HUY" ${cur==="HUY" ? "selected" : ""}>Đã hủy</option>
    </select>
  `;
}

function methodSelectHtml(order){
  const paid = (order.trang_thai === "DA_THANH_TOAN");
  const cur = (order.phuong_thuc_tt || "COD").toUpperCase();

  return `
    <select class="input" style="padding:9px 10px" ${paid ? "disabled" : ""} onchange="setPayMethod(${order.id}, this.value)">
      <option value="COD" ${cur==="COD" ? "selected" : ""}>COD (Tiền mặt)</option>
      <option value="ONLINE" ${cur==="ONLINE" ? "selected" : ""}>Online</option>
    </select>
  `;
}

function payStatusHtml(order){
  const st = order.trang_thai || "CHUA_THANH_TOAN";
  const label = PAY_STATUS_LABEL[st] || st;

  return `
    <div>
      <div style="font-weight:900">${esc(label)}</div>
      <div class="muted">${esc((order.phuong_thuc_tt || "COD").toUpperCase())}</div>
    </div>
  `;
}

function render(items){
  if (!items.length){
    list.innerHTML = `<tr><td colspan="8">Chưa có đơn hàng</td></tr>`;
    return;
  }

  list.innerHTML = items.map(x => {
    const paid = (x.trang_thai === "DA_THANH_TOAN");
    const method = (x.phuong_thuc_tt || "COD").toUpperCase();

    const actionHtml = paid
      ? `<span class="badge">Đã thanh toán</span>`
      : `<button class="btn" onclick="markPaid(${x.id})">Xác nhận đã thanh toán</button>`;

    return `
      <tr>
        <td><b>#${x.id}</b><br><span class="muted">${esc(x.ma_don || "")}</span></td>
        <td>${esc(x.ngay_tao || "")}</td>

        <td>
          <div style="font-weight:900">${esc(x.ten_khach || "Khách lẻ")}</div>
          <div class="muted">${esc(x.sdt || "")}${x.email ? ` • ${esc(x.email)}` : ""}</div>
        </td>

        <td>${shipSelectHtml(x)}</td>
        <td>${methodSelectHtml(x)}</td>
        <td>${payStatusHtml(x)}</td>
        <td><b>${money(x.tong_tien)}</b></td>

        <td>
          <div class="actions">
            <a class="btn btn--ghost" href="/petshop/petshop/admin/hoa_don.php?id=${x.id}">Xem/In</a>
            ${actionHtml}
          </div>
        </td>
      </tr>
    `;
  }).join("");
}

async function updateShip(id, status){
  const fd = new FormData();
  fd.append("action", "update_ship_status");
  fd.append("id_don_hang", id);
  fd.append("trang_thai_giao_hang", status);

  const r = await fetch(API_DON, {
    method:"POST",
    body:fd,
    credentials:"same-origin"
  });

  const d = await r.json();

  if (!d.ok){
    showToast(d.msg || "Cập nhật thất bại", false);
    return;
  }

  showToast(d.msg || "Đã cập nhật trạng thái");
  load();
}

async function setPayMethod(id, method){
  const fd = new FormData();
  fd.append("action", "set_method");
  fd.append("id_don_hang", id);
  fd.append("phuong_thuc_tt", method);

  const r = await fetch(API_DON, {
    method:"POST",
    body:fd,
    credentials:"same-origin"
  });

  const d = await r.json();

  if (!d.ok){
    showToast(d.msg || "Không đổi được phương thức", false);
    load();
    return;
  }

  showToast(d.msg || "Đã cập nhật phương thức");
  load();
}

async function markPaid(id){
  if (!confirm("Xác nhận đơn #" + id + " đã thanh toán?")) return;

  const fd = new FormData();
  fd.append("action", "mark_paid");
  fd.append("id_don_hang", id);

  const r = await fetch(API_DON, {
    method:"POST",
    body:fd,
    credentials:"same-origin",
    cache:"no-store"
  });

  const d = await r.json();

  if (!d.ok){
    showToast(d.msg || "Không xác nhận được thanh toán", false);
    return;
  }

  showToast(d.msg || "Đã xác nhận thanh toán");

  const it = ALL.find(x => Number(x.id) === Number(id));
  if (it){
    it.trang_thai = "DA_THANH_TOAN";
    render(ALL);
  }

  setTimeout(load, 200);
}

q.addEventListener("input", load);
document.addEventListener("DOMContentLoaded", load);
</script>

<?php include __DIR__ . "/_footer.php"; ?>