<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['user'])) { header("Location: dang_nhap.php"); exit; }
include __DIR__ . "/_header.php";
?>

<style>
.dmPage{
  width:100%;
}

.dmHero{
  background:linear-gradient(135deg,#0f172a,#1e293b);
  color:white;
  border-radius:26px;
  padding:26px;
  margin-bottom:22px;
  box-shadow:0 18px 45px rgba(15,23,42,.18);
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:18px;
}

.dmHero h1{
  margin:0;
  font-size:30px;
  font-weight:900;
}

.dmHero p{
  margin:8px 0 0;
  color:#cbd5e1;
}

.dmHero .btn{
  background:#f97316;
  color:white;
  border:0;
  border-radius:999px;
  padding:14px 22px;
  font-weight:900;
  cursor:pointer;
  box-shadow:0 12px 25px rgba(249,115,22,.25);
}

.dmCard{
  background:white;
  border-radius:26px;
  box-shadow:0 18px 45px rgba(15,23,42,.08);
  border:1px solid #eef2f7;
  overflow:hidden;
}

.dmToolbar{
  padding:18px 22px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:14px;
  border-bottom:1px solid #eef2f7;
}

.dmSearch{
  width:380px;
  max-width:100%;
  border:1px solid #dbe3ef;
  background:#f8fafc;
  border-radius:999px;
  padding:14px 18px;
  outline:none;
  font-weight:700;
}

.dmSearch:focus{
  border-color:#f97316;
  box-shadow:0 0 0 4px rgba(249,115,22,.12);
  background:white;
}

.dmStats{
  display:flex;
  gap:10px;
  flex-wrap:wrap;
}

.dmChip{
  padding:10px 14px;
  border-radius:999px;
  background:#f8fafc;
  color:#475569;
  font-weight:900;
  border:1px solid #eef2f7;
}

.dmTableWrap{
  padding:0 22px 22px;
  overflow:auto;
}

.dmTable{
  width:100%;
  border-collapse:collapse;
  min-width:900px;
}

.dmTable th{
  text-align:left;
  padding:17px 12px;
  background:#f8fafc;
  color:#64748b;
  font-size:14px;
  font-weight:900;
  border-bottom:1px solid #e5e7eb;
}

.dmTable td{
  padding:17px 12px;
  border-bottom:1px solid #eef2f7;
  vertical-align:middle;
}

.dmName{
  display:flex;
  align-items:center;
  gap:12px;
  font-weight:900;
  color:#0f172a;
}

.dmIcon{
  width:38px;
  height:38px;
  display:flex;
  align-items:center;
  justify-content:center;
  border-radius:14px;
  background:#fff7ed;
  color:#f97316;
  font-size:20px;
}

.dmChild{
  padding-left:32px;
  color:#334155;
}

.dmBadge{
  display:inline-flex;
  align-items:center;
  padding:8px 12px;
  border-radius:999px;
  background:#eef2ff;
  color:#3730a3;
  font-weight:900;
  font-size:13px;
}

.dmBadge.parent{
  background:#dcfce7;
  color:#166534;
}

.dmBadge.empty{
  background:#f1f5f9;
  color:#64748b;
}

.dmActions{
  display:flex;
  gap:8px;
}

.dmBtn{
  border:0;
  border-radius:999px;
  padding:10px 14px;
  font-weight:900;
  cursor:pointer;
}

.dmBtn.edit{
  background:#eef2ff;
  color:#3730a3;
}

.dmBtn.delete{
  background:#fee2e2;
  color:#991b1b;
}

.dmEmpty{
  padding:30px;
  text-align:center;
  color:#64748b;
  font-weight:800;
}

/* MODAL ĐẸP */
.dmModal{
  display:none;
  position:fixed;
  inset:0;
  background:rgba(15,23,42,.55);
  z-index:9999;
  padding:24px;
}

.dmModalPanel{
  width:100%;
  max-width:620px;
  background:white;
  margin:60px auto;
  border-radius:28px;
  overflow:hidden;
  box-shadow:0 30px 80px rgba(15,23,42,.25);
  animation:dmPop .18s ease-out;
}

@keyframes dmPop{
  from{transform:translateY(20px);opacity:0}
  to{transform:translateY(0);opacity:1}
}

.dmModalHead{
  padding:22px 26px;
  background:linear-gradient(135deg,#fff7ed,#ffffff);
  border-bottom:1px solid #eef2f7;
  display:flex;
  justify-content:space-between;
  align-items:center;
}

.dmModalHead h3{
  margin:0;
  font-size:24px;
  font-weight:900;
}

.dmClose{
  width:42px;
  height:42px;
  border:0;
  border-radius:50%;
  background:#f1f5f9;
  font-weight:900;
  cursor:pointer;
}

.dmModalBody{
  padding:26px;
}

.dmFormGroup{
  margin-bottom:16px;
}

.dmFormGroup label{
  display:block;
  font-weight:900;
  color:#334155;
  margin-bottom:8px;
}

.dmInput{
  width:100%;
  border:1px solid #dbe3ef;
  background:#f8fafc;
  border-radius:16px;
  padding:15px 16px;
  outline:none;
  font-weight:700;
}

.dmInput:focus{
  border-color:#f97316;
  box-shadow:0 0 0 4px rgba(249,115,22,.12);
  background:white;
}

.dmModalFoot{
  padding:18px 26px 26px;
  display:flex;
  justify-content:flex-end;
  gap:10px;
}

.dmSave{
  background:#f97316;
  color:white;
  border:0;
  border-radius:999px;
  padding:13px 22px;
  font-weight:900;
  cursor:pointer;
}

.dmCancel{
  background:#f1f5f9;
  color:#0f172a;
  border:0;
  border-radius:999px;
  padding:13px 22px;
  font-weight:900;
  cursor:pointer;
}

@media(max-width:800px){
  .dmHero{
    flex-direction:column;
    align-items:flex-start;
  }

  .dmToolbar{
    flex-direction:column;
    align-items:stretch;
  }

  .dmSearch{
    width:100%;
  }
}
</style>

<div class="dmPage">

  <div class="dmHero">
    <div>
      <h1>📂 Quản lý danh mục</h1>
      <p>Quản lý danh mục lớn, danh mục con cho chó mèo, shop thú cưng và sản phẩm.</p>
    </div>

    <button class="btn" onclick="openModal()">+ Thêm danh mục</button>
  </div>

  <div class="dmCard">
    <div class="dmToolbar">
      <input class="dmSearch" id="searchInput" placeholder="Tìm danh mục theo tên / loại...">

      <div class="dmStats">
        <span class="dmChip">Tổng: <b id="totalCount">0</b></span>
        <span class="dmChip">Danh mục cha: <b id="parentCount">0</b></span>
        <span class="dmChip">Danh mục con: <b id="childCount">0</b></span>
      </div>
    </div>

    <div class="dmTableWrap">
      <table class="dmTable">
        <thead>
          <tr>
            <th style="width:80px">ID</th>
            <th>Tên danh mục</th>
            <th style="width:220px">Danh mục cha</th>
            <th style="width:180px">Loại</th>
            <th style="width:190px">Hành động</th>
          </tr>
        </thead>
        <tbody id="list">
          <tr>
            <td colspan="5" class="dmEmpty">Đang tải dữ liệu...</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- MODAL -->
<div class="dmModal" id="modal">
  <div class="dmModalPanel">
    <div class="dmModalHead">
      <h3 id="title">Thêm danh mục</h3>
      <button class="dmClose" onclick="closeModal()">✕</button>
    </div>

    <div class="dmModalBody">
      <input type="hidden" id="id">

      <div class="dmFormGroup">
        <label>Tên danh mục</label>
        <input class="dmInput" id="ten" placeholder="Ví dụ: Thức ăn cho chó">
      </div>

      <div class="dmFormGroup">
        <label>Danh mục cha</label>
        <select class="dmInput" id="parent"></select>
      </div>

      <div class="dmFormGroup">
        <label>Loại danh mục</label>
        <input class="dmInput" id="loai" placeholder="Ví dụ: chó, mèo, phụ kiện...">
      </div>
    </div>

    <div class="dmModalFoot">
      <button class="dmCancel" onclick="closeModal()">Đóng</button>
      <button class="dmSave" onclick="save()">💾 Lưu danh mục</button>
    </div>
  </div>
</div>

<script>
const API = "/petshop/petshop/admin/api/api_danh_muc.php";
let DATA = [];
let FILTERED = [];

async function load(){
  const list = document.getElementById("list");
  list.innerHTML = `<tr><td colspan="5" class="dmEmpty">Đang tải dữ liệu...</td></tr>`;

  try{
    const res = await fetch(API + "?action=list&t=" + Date.now(), {
      credentials:"same-origin",
      cache:"no-store"
    });

    const d = await res.json();

    if(!d.ok && d.ok !== undefined){
      list.innerHTML = `<tr><td colspan="5" class="dmEmpty">${d.msg || "Không tải được danh mục"}</td></tr>`;
      return;
    }

    DATA = d.items || [];
    FILTERED = DATA;

    render();
    loadParents();
    updateStats();

  }catch(e){
    list.innerHTML = `<tr><td colspan="5" class="dmEmpty">Lỗi tải dữ liệu. Kiểm tra API.</td></tr>`;
  }
}

function render(){
  const list = document.getElementById("list");

  if(!FILTERED.length){
    list.innerHTML = `<tr><td colspan="5" class="dmEmpty">Không có danh mục nào.</td></tr>`;
    return;
  }

  list.innerHTML = FILTERED.map(x => {
    const isChild = Number(x.id_cha || 0) > 0;

    return `
      <tr>
        <td><b>#${x.id}</b></td>

        <td>
          <div class="dmName ${isChild ? "dmChild" : ""}">
            <span class="dmIcon">${isChild ? "↳" : "📁"}</span>
            <span>${escapeHtml(x.ten_danh_muc || "")}</span>
          </div>
        </td>

        <td>
          ${
            x.ten_cha
            ? `<span class="dmBadge parent">${escapeHtml(x.ten_cha)}</span>`
            : `<span class="dmBadge empty">Không có</span>`
          }
        </td>

        <td>
          <span class="dmBadge">${escapeHtml(x.loai || "-")}</span>
        </td>

        <td>
          <div class="dmActions">
            <button class="dmBtn edit" onclick='edit(${JSON.stringify(x).replaceAll("'", "\\'")})'>Sửa</button>
            <button class="dmBtn delete" onclick='del(${x.id})'>Xóa</button>
          </div>
        </td>
      </tr>
    `;
  }).join("");
}

async function loadParents(){
  try{
    const res = await fetch(API + "?action=parents&t=" + Date.now(), {
      credentials:"same-origin",
      cache:"no-store"
    });

    const d = await res.json();
    const select = document.getElementById("parent");

    select.innerHTML = `<option value="">-- Không có (danh mục cha) --</option>`;

    (d.items || []).forEach(x=>{
      select.innerHTML += `<option value="${x.id}">${escapeHtml(x.ten_danh_muc)}</option>`;
    });
  }catch(e){}
}

function updateStats(){
  document.getElementById("totalCount").innerText = DATA.length;
  document.getElementById("parentCount").innerText = DATA.filter(x => !x.id_cha || Number(x.id_cha) === 0).length;
  document.getElementById("childCount").innerText = DATA.filter(x => Number(x.id_cha || 0) > 0).length;
}

function openModal(){
  document.getElementById("modal").style.display="block";
  document.getElementById("title").innerText="Thêm danh mục";
  document.getElementById("id").value="";
  document.getElementById("ten").value="";
  document.getElementById("loai").value="";
  document.getElementById("parent").value="";
  setTimeout(()=>document.getElementById("ten").focus(), 50);
}

function closeModal(){
  document.getElementById("modal").style.display="none";
}

function edit(x){
  openModal();
  document.getElementById("title").innerText="Sửa danh mục";
  document.getElementById("id").value = x.id;
  document.getElementById("ten").value = x.ten_danh_muc || "";
  document.getElementById("parent").value = x.id_cha || "";
  document.getElementById("loai").value = x.loai || "";
}

async function save(){
  const ten = document.getElementById("ten").value.trim();

  if(!ten){
    alert("Vui lòng nhập tên danh mục");
    return;
  }

  const fd = new FormData();
  fd.append("action","save");
  fd.append("id", document.getElementById("id").value);
  fd.append("ten_danh_muc", ten);
  fd.append("id_cha", document.getElementById("parent").value);
  fd.append("loai", document.getElementById("loai").value.trim());

  const res = await fetch(API, {
    method:"POST",
    body:fd,
    credentials:"same-origin"
  });

  const d = await res.json();

  alert(d.msg || (d.ok ? "Đã lưu" : "Lưu thất bại"));

  if(d.ok || d.success){
    closeModal();
    load();
  }
}

async function del(id){
  if(!confirm("Bạn có chắc muốn xóa danh mục này?")) return;

  const fd = new FormData();
  fd.append("action","delete");
  fd.append("id", id);

  const res = await fetch(API, {
    method:"POST",
    body:fd,
    credentials:"same-origin"
  });

  const d = await res.json();

  alert(d.msg || (d.ok ? "Đã xóa" : "Xóa thất bại"));
  load();
}

document.getElementById("searchInput").addEventListener("input", function(){
  const q = this.value.trim().toLowerCase();

  FILTERED = DATA.filter(x => {
    return String(x.ten_danh_muc || "").toLowerCase().includes(q)
      || String(x.ten_cha || "").toLowerCase().includes(q)
      || String(x.loai || "").toLowerCase().includes(q);
  });

  render();
});

document.getElementById("modal").addEventListener("click", function(e){
  if(e.target === this) closeModal();
});

function escapeHtml(s){
  return String(s).replace(/[&<>"']/g, m => ({
    "&":"&amp;",
    "<":"&lt;",
    ">":"&gt;",
    '"':"&quot;",
    "'":"&#039;"
  }[m]));
}

load();
</script>

<?php include __DIR__ . "/_footer.php"; ?>