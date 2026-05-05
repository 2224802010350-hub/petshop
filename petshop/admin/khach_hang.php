<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['user'])) { header("Location: dang_nhap.php"); exit; }
include __DIR__ . "/_header.php";
?>

<div class="card" style="width:100%;max-width:none;margin:0">
  <div class="card__head">
    <h2>👤 Quản lý khách hàng</h2>
    <div class="row" style="flex:1;justify-content:flex-end;gap:10px">
      <input class="input" id="q" placeholder="Tìm theo tên / SĐT / email..." style="max-width:360px">
      <button class="btn" id="btnAdd">+ Thêm khách hàng</button>
    </div>
  </div>

  <div class="card__body">
    <div class="toast" id="toast"></div>

    <div class="tableWrap">
      <table>
        <thead>
          <tr>
            <th style="width:60px">ID</th>
            <th style="width:140px" >Khách hàng</th>
            <th style="width:120px">SĐT</th>
            <th>Email</th>
            <th style="width:30px">Địa chỉ</th>
            <th style="width:30px">Hạng</th>
            <th style="width:60px">Điểm</th>
            <th style="width:100px">Hành động</th>
          </tr>
        </thead>
        <tbody id="list"></tbody>
      </table>
    </div>
  </div>
</div>

<!-- MODAL THÊM/SỬA -->
<div class="modal" id="modal">
  <div class="modal__panel" style="max-width:820px">
    <div class="modal__head">
      <b id="modalTitle">Thêm khách hàng</b>
      <button class="btn btn--ghost" id="btnClose">✕</button>
    </div>
    <div class="modal__body">
      <form id="f">
        <input type="hidden" name="id" id="id">

        <div class="grid2">
          <div>
            <label class="muted">Họ tên</label>
            <input class="input" name="ho_ten" id="ho_ten" required>
          </div>
          <div>
            <label class="muted">Số điện thoại</label>
            <input class="input" name="so_dien_thoai" id="so_dien_thoai" required placeholder="VD: 098xxxxxxx">
          </div>

          <div>
            <label class="muted">Email</label>
            <input class="input" name="email" id="email" placeholder="(không bắt buộc)">
          </div>
          <div>
            <label class="muted">Hạng khách</label>
            <select class="input" name="hang_khach" id="hang_khach">
              <option value="thuong">Thường</option>
              <option value="vip">VIP</option>
            </select>
          </div>

          <div style="grid-column:1/-1">
            <label class="muted">Địa chỉ</label>
            <input class="input" name="dia_chi" id="dia_chi" placeholder="(không bắt buộc)">
          </div>

          <div>
            <label class="muted">Điểm</label>
            <input class="input" type="number" min="0" name="diem" id="diem" value="0">
          </div>
        </div>

        <div class="hr"></div>
        <div class="row" style="justify-content:flex-end">
          <button class="btn btn--ghost" type="button" id="btnReset">Làm mới</button>
          <button class="btn" type="submit">💾 Lưu</button>
        </div>

        <div class="toast err" id="formMsg" style="display:none;margin-top:10px"></div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL LỊCH SỬ -->
<div class="modal" id="modalHist">
  <div class="modal__panel" style="max-width:980px">
    <div class="modal__head">
      <b id="histTitle">Lịch sử khách hàng</b>
      <button class="btn btn--ghost" id="btnCloseHist">✕</button>
    </div>
    <div class="modal__body">
      <div class="tabs">
        <button class="tab active" id="tabMua">🧾 Lịch sử mua</button>
        <button class="tab" id="tabDv">🛁 Lịch sử dịch vụ</button>
      </div>

      <div id="paneMua">
        <div class="tableWrap">
          <table>
            <thead>
              <tr>
                <th style="width:90px">Mã đơn</th>
                <th style="width:180px">Ngày tạo</th>
                <th style="width:160px">Trạng thái</th>
                <th>Tổng tiền</th>
              </tr>
            </thead>
            <tbody id="lsMua"></tbody>
          </table>
        </div>
      </div>

      <div id="paneDv" style="display:none">
        <div class="tableWrap">
          <table>
            <thead>
              <tr>
                <th style="width:90px">Mã lịch</th>
                <th>Dịch vụ</th>
                <th style="width:220px">Thời gian hẹn</th>
                <th style="width:180px">Trạng thái</th>
              </tr>
            </thead>
            <tbody id="lsDv"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
const API = "api/api_khach_hang.php";

const list = document.getElementById("list");
const q = document.getElementById("q");
const toast = document.getElementById("toast");

const modal = document.getElementById("modal");
const modalTitle = document.getElementById("modalTitle");
const btnAdd = document.getElementById("btnAdd");
const btnClose = document.getElementById("btnClose");
const btnReset = document.getElementById("btnReset");

const f = document.getElementById("f");
const formMsg = document.getElementById("formMsg");

const id = document.getElementById("id");
const ho_ten = document.getElementById("ho_ten");
const so_dien_thoai = document.getElementById("so_dien_thoai");
const email = document.getElementById("email");
const dia_chi = document.getElementById("dia_chi");
const hang_khach = document.getElementById("hang_khach");
const diem = document.getElementById("diem");

const modalHist = document.getElementById("modalHist");
const btnCloseHist = document.getElementById("btnCloseHist");
const histTitle = document.getElementById("histTitle");
const tabMua = document.getElementById("tabMua");
const tabDv = document.getElementById("tabDv");
const paneMua = document.getElementById("paneMua");
const paneDv = document.getElementById("paneDv");
const lsMua = document.getElementById("lsMua");
const lsDv = document.getElementById("lsDv");

let ALL = [];

function showToast(text, ok=true){
  toast.className = "toast " + (ok ? "ok" : "err");
  toast.style.display = "block";
  toast.innerText = text;
  setTimeout(()=> toast.style.display="none", 2400);
}

function openModal(edit=false){
  modal.style.display = "block";
  formMsg.style.display="none";
  modalTitle.innerText = edit ? "Sửa khách hàng" : "Thêm khách hàng";
  setTimeout(()=>ho_ten.focus(), 50);
}
function closeModal(){ modal.style.display = "none"; }

function resetForm(){
  f.reset();
  id.value="";
  hang_khach.value="thuong";
  diem.value="0";
  formMsg.style.display="none";
}

btnAdd.addEventListener("click", ()=>{ resetForm(); openModal(false); });
btnClose.addEventListener("click", closeModal);
modal.addEventListener("click", (e)=>{ if (e.target===modal) closeModal(); });
btnReset.addEventListener("click", resetForm);

async function loadKH(){
  const text = (q.value||"").trim();
  const url = text ? `${API}?action=list&q=${encodeURIComponent(text)}` : `${API}?action=list`;
  const r = await fetch(url, { credentials:"same-origin" });
  const d = await r.json();

  if (!d.ok){
    list.innerHTML = `<tr><td colspan="8">Không tải được khách hàng</td></tr>`;
    return;
  }
  ALL = d.items || [];
  render(ALL);
}

function render(items){
  if (!items.length){
    list.innerHTML = `<tr><td colspan="8">Không có dữ liệu</td></tr>`;
    return;
  }

  list.innerHTML = items.map(x=>`
    <tr>
      <td><b>${x.id}</b></td>
      <td style="font-weight:900">${escapeHtml(x.ho_ten||"")}</td>
      <td>${escapeHtml(x.so_dien_thoai||"")}</td>
      <td class="muted">${escapeHtml(x.email||"")}</td>
      <td class="muted">${escapeHtml(x.dia_chi||"")}</td>
      <td>
  <td>
  <span class="badge">
    ${x.hang_thanh_vien || 'Đồng'}
  </span>
</td>

<td>
  <b style="color:#16a34a">
    ${x.diem ?? 0}
  </b>
</td>
      <td>
        <div class="actions">
          <button class="btn btn--ghost" onclick='editKH(${JSON.stringify(x).replaceAll("'", "\\'")})'>Sửa</button>
          <button class="btn btn--ghost" onclick='openHist(${x.id}, "${escapeJs(x.ho_ten||"")}","${escapeJs(x.so_dien_thoai||"")}")'>Lịch sử</button>
          <button class="btn btn--danger" onclick='delKH(${x.id})'>Xóa</button>
        </div>
      </td>
    </tr>
  `).join("");
}

q.addEventListener("input", ()=> loadKH());

function editKH(x){
  resetForm();
  id.value = x.id;
  ho_ten.value = x.ho_ten || "";
  so_dien_thoai.value = x.so_dien_thoai || "";
  email.value = x.email || "";
  dia_chi.value = x.dia_chi || "";
  hang_khach.value = x.hang_khach || "thuong";
  diem.value = x.diem ?? 0;
  openModal(true);
}

async function delKH(khId){
  if (!confirm("Xóa khách hàng này? (Nếu đã có đơn hàng/lịch hẹn sẽ không xóa được)")) return;
  const fd = new FormData();
  fd.append("action","delete");
  fd.append("id", khId);

  const r = await fetch(API, { method:"POST", body:fd, credentials:"same-origin" });
  const d = await r.json();

  if (!d.ok){ showToast(d.msg || "Xóa thất bại", false); return; }
  showToast(d.msg || "Đã xóa");
  await loadKH();
}

f.addEventListener("submit", async (e)=>{
  e.preventDefault();
  formMsg.style.display="none";

  const name = ho_ten.value.trim();
  const phone = so_dien_thoai.value.trim();

  if (!name){ formMsg.style.display="block"; formMsg.innerText="Họ tên không được rỗng"; return; }
  if (!phone){ formMsg.style.display="block"; formMsg.innerText="SĐT không được rỗng"; return; }

  const fd = new FormData(f);
  fd.append("action","save");

  const r = await fetch(API, { method:"POST", body:fd, credentials:"same-origin" });
  const d = await r.json();

  if (!d.ok){
    formMsg.style.display="block";
    formMsg.innerText = d.msg || "Lưu thất bại";
    return;
  }

  showToast(d.msg || "Lưu thành công");
  closeModal();
  await loadKH();
});

// ====== LỊCH SỬ ======
function openHist(khId, name, phone){
  modalHist.style.display = "block";
  histTitle.innerText = `Lịch sử: ${name} (${phone})`;

  tabMua.click();
  loadHistMua(khId);
  loadHistDv(khId);
}
function closeHist(){ modalHist.style.display="none"; }
btnCloseHist.addEventListener("click", closeHist);
modalHist.addEventListener("click", (e)=>{ if (e.target===modalHist) closeHist(); });

tabMua.addEventListener("click", ()=>{
  tabMua.classList.add("active"); tabDv.classList.remove("active");
  paneMua.style.display="block"; paneDv.style.display="none";
});
tabDv.addEventListener("click", ()=>{
  tabDv.classList.add("active"); tabMua.classList.remove("active");
  paneDv.style.display="block"; paneMua.style.display="none";
});

async function loadHistMua(khId){
  lsMua.innerHTML = `<tr><td colspan="4">Đang tải...</td></tr>`;
  const r = await fetch(`${API}?action=lich_su_mua&id=${khId}`, { credentials:"same-origin" });
  const d = await r.json();
  if (!d.ok){ lsMua.innerHTML = `<tr><td colspan="4">Không tải được</td></tr>`; return; }
  const items = d.items || [];
  if (!items.length){ lsMua.innerHTML = `<tr><td colspan="4">Chưa có đơn hàng</td></tr>`; return; }

  lsMua.innerHTML = items.map(x=>`
    <tr>
      <td><b>#${x.id}</b></td>
      <td>${escapeHtml(x.ngay_tao||"")}</td>
      <td>${escapeHtml(x.trang_thai||"")}</td>
      <td><b>${fmtMoney(x.tong_tien||0)}</b></td>
    </tr>
  `).join("");
}

async function loadHistDv(khId){
  lsDv.innerHTML = `<tr><td colspan="4">Đang tải...</td></tr>`;
  const r = await fetch(`${API}?action=lich_su_dich_vu&id=${khId}`, { credentials:"same-origin" });
  const d = await r.json();
  if (!d.ok){ lsDv.innerHTML = `<tr><td colspan="4">Không tải được</td></tr>`; return; }
  const items = d.items || [];
  if (!items.length){ lsDv.innerHTML = `<tr><td colspan="4">Chưa có lịch hẹn</td></tr>`; return; }

  lsDv.innerHTML = items.map(x=>`
    <tr>
      <td><b>#${x.id}</b></td>
      <td>${escapeHtml(x.ten_dich_vu||"(không rõ)")}</td>
      <td>${escapeHtml(x.thoi_gian_hen||"")}</td>
      <td>${escapeHtml(x.trang_thai||"")}</td>
    </tr>
  `).join("");
}

// utils
function fmtMoney(n){
  try { return new Intl.NumberFormat('vi-VN').format(Number(n)) + " ₫"; }
  catch(e){ return n + " ₫"; }
}
function escapeHtml(s){
  return String(s).replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m]));
}
function escapeJs(s){ return String(s).replaceAll("\\","\\\\").replaceAll('"','\\"'); }

document.addEventListener("DOMContentLoaded", loadKH);
</script>

<?php include __DIR__ . "/_footer.php"; ?>
