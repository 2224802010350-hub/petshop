<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['user'])) { header("Location: dang_nhap.php"); exit; }
include __DIR__ . "/_header.php";
?>

<div class="card">
  <div class="card__head">
    <h2>📂 Quản lý danh mục</h2>
    <button class="btn" onclick="openModal()">+ Thêm</button>
  </div>

  <div class="card__body">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Tên</th>
          <th>Danh mục cha</th>
          <th>Loại</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody id="list"></tbody>
    </table>
  </div>
</div>

<!-- MODAL -->
<div class="modal" id="modal">
  <div class="modal__panel">
    <h3 id="title">Thêm danh mục</h3>

    <input type="hidden" id="id">

    <label>Tên danh mục</label>
    <input class="input" id="ten">

    <label>Danh mục cha</label>
    <select class="input" id="parent"></select>

    <label>Loại (chó / mèo / phụ kiện...)</label>
    <input class="input" id="loai">

    <br><br>
    <button class="btn" onclick="save()">💾 Lưu</button>
    <button class="btn btn--ghost" onclick="closeModal()">Đóng</button>
  </div>
</div>

<script>
const API = "/petshop/petshop/admin/api/api_danh_muc.php";
let DATA = [];

async function load(){
  const res = await fetch(API + "?action=list");
  const d = await res.json();

  DATA = d.items || [];

  render();
  loadParents();
}

function render(){
  const list = document.getElementById("list");

  list.innerHTML = DATA.map(x => `
    <tr>
      <td>${x.id}</td>
      <td>${x.id_cha ? "↳ " : "📁 "}${x.ten_danh_muc}</td>
      <td>${x.ten_cha || "-"}</td>
      <td>${x.loai || "-"}</td>
      <td>
        <button onclick='edit(${JSON.stringify(x)})'>Sửa</button>
        <button onclick='del(${x.id})'>Xóa</button>
      </td>
    </tr>
  `).join("");
}

async function loadParents(){
  const res = await fetch(API + "?action=parents");
  const d = await res.json();

  const select = document.getElementById("parent");

  select.innerHTML = `<option value="">-- Không có (danh mục cha) --</option>`;

  (d.items || []).forEach(x=>{
    select.innerHTML += `<option value="${x.id}">${x.ten_danh_muc}</option>`;
  });
}

function openModal(){
  document.getElementById("modal").style.display="block";
  document.getElementById("id").value="";
  document.getElementById("ten").value="";
  document.getElementById("loai").value="";
}

function closeModal(){
  document.getElementById("modal").style.display="none";
}

function edit(x){
  openModal();
  document.getElementById("title").innerText="Sửa danh mục";

  document.getElementById("id").value = x.id;
  document.getElementById("ten").value = x.ten_danh_muc;
  document.getElementById("parent").value = x.id_cha || "";
  document.getElementById("loai").value = x.loai || "";
}

async function save(){
  const fd = new FormData();

  fd.append("action","save");
  fd.append("id", document.getElementById("id").value);
  fd.append("ten_danh_muc", document.getElementById("ten").value);
  fd.append("id_cha", document.getElementById("parent").value);
  fd.append("loai", document.getElementById("loai").value);

  const res = await fetch(API, { method:"POST", body:fd });
  const d = await res.json();

  alert(d.msg);
  closeModal();
  load();
}

async function del(id){
  if(!confirm("Xóa?")) return;

  const fd = new FormData();
  fd.append("action","delete");
  fd.append("id", id);

  const res = await fetch(API, { method:"POST", body:fd });
  const d = await res.json();

  alert(d.msg);
  load();
}

load();
</script>

<?php include __DIR__ . "/_footer.php"; ?>