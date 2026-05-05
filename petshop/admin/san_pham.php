<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['user'])) { header("Location: dang_nhap.php"); exit; }
include __DIR__ . "/_header.php";
?>

<div class="card" style="width:100%;max-width:none;margin:0">
  <div class="card__head">
    <h2>📦 Quản lý sản phẩm</h2>
    <div class="row" style="flex:1;justify-content:flex-end">
      <input class="input" id="q" placeholder="Tìm theo SKU / tên..." style="max-width:360px">
      <button class="btn" id="btnAdd">+ Thêm sản phẩm</button>
    </div>
  </div>

  <div class="card__body">
    <div class="toast" id="toast"></div>

    <div class="tableWrap">
      <table>
        <thead>
          <tr>
            <th style="width:70px">ID</th>
            <th style="width:90px">Ảnh</th>
            <th style="width:140px">SKU</th>
            <th>Tên sản phẩm</th>
            <th style="width:220px">Danh mục</th>
            <th style="width:130px">Giá</th>
            <th style="width:90px">Tồn</th>
            <th style="width:90px">TT</th>
            <th style="width:170px">Hành động</th>
          </tr>
        </thead>
        <tbody id="list">
          <tr><td colspan="9">Đang tải...</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- MODAL ADD/EDIT -->
<div class="modal" id="modal">
  <div class="modal__panel" style="max-width:900px">
    <div class="modal__head">
      <b id="modalTitle">Thêm sản phẩm</b>
      <button class="btn btn--ghost" id="btnClose" type="button">✕</button>
    </div>

    <div class="modal__body">
      <form id="f" enctype="multipart/form-data">
        <input type="hidden" name="id" id="id">

        <div class="grid2">
          <div>
            <label class="muted">Danh mục</label>
            <select class="input" name="id_danh_muc" id="id_danh_muc" required>
              <option value="">-- Chọn danh mục --</option>
            </select>
          </div>

          <div>
            <label class="muted">SKU</label>
            <input class="input" name="ma_sku" id="ma_sku" required placeholder="VD: CAT_FOOD_01">
          </div>

          <div style="grid-column:1/-1">
            <label class="muted">Tên sản phẩm</label>
            <input class="input" name="ten_san_pham" id="ten_san_pham" required placeholder="Nhập tên sản phẩm">
          </div>

          <div style="grid-column:1/-1">
            <label class="muted">Mô tả</label>
            <textarea class="input" name="mo_ta" id="mo_ta" rows="4" placeholder="Nhập mô tả sản phẩm..."></textarea>
          </div>

          <div>
            <label class="muted">Giá bán</label>
            <input class="input" name="gia_ban" id="gia_ban" inputmode="numeric" placeholder="VD: 150000" required>
          </div>

          <div>
            <label class="muted">Tồn kho</label>
            <input class="input" name="ton_kho" id="ton_kho" type="number" min="0" value="0" required>
          </div>

          <div>
            <label class="muted">Trạng thái</label>
            <select class="input" name="trang_thai" id="trang_thai">
              <option value="1">Đang bán</option>
              <option value="0">Ẩn</option>
            </select>
          </div>

          <div style="grid-column:1/-1">
            <label class="muted">Hình ảnh ≤ 2MB</label>
            <div class="previewBox">
              <img id="previewImg" src="/petshop/petshop/assets/img/no-image.png" alt="" style="width:100px;height:100px;object-fit:cover;border-radius:14px;border:1px solid #e5e7eb">
              <div style="flex:1">
                <input class="input" name="hinh_anh" id="hinh_anh" type="file" accept="image/*">
                <div class="muted" style="margin-top:6px">JPG / PNG / WEBP, tối đa 2MB</div>
              </div>
            </div>
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

<script>
const API_DM = "api/api_danh_muc.php";
const API_SP = "api/api_san_pham.php";

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
const id_danh_muc = document.getElementById("id_danh_muc");
const ma_sku = document.getElementById("ma_sku");
const ten_san_pham = document.getElementById("ten_san_pham");
const mo_ta = document.getElementById("mo_ta");
const gia_ban = document.getElementById("gia_ban");
const ton_kho = document.getElementById("ton_kho");
const trang_thai = document.getElementById("trang_thai");
const hinh_anh = document.getElementById("hinh_anh");
const previewImg = document.getElementById("previewImg");

let ALL = [];

function esc(s){
  return String(s ?? "").replace(/[&<>"']/g, m => ({
    "&":"&amp;",
    "<":"&lt;",
    ">":"&gt;",
    '"':"&quot;",
    "'":"&#039;"
  })[m]);
}

function showToast(text, ok=true){
  toast.className = "toast " + (ok ? "ok" : "err");
  toast.style.display = "block";
  toast.innerText = text;
  setTimeout(()=> toast.style.display="none", 2500);
}

function money(n){
  return Number(n || 0).toLocaleString("vi-VN") + " ₫";
}

function openModal(edit=false){
  modal.style.display = "block";
  modalTitle.innerText = edit ? "Sửa sản phẩm" : "Thêm sản phẩm";
  formMsg.style.display = "none";
}

function closeModal(){
  modal.style.display = "none";
}

function resetForm(){
  f.reset();
  id.value = "";
  id_danh_muc.value = "";
  gia_ban.value = "";
  ton_kho.value = 0;
  trang_thai.value = 1;
  previewImg.src = "/petshop/petshop/assets/img/no-image.png";
  formMsg.style.display = "none";
}

btnAdd.onclick = function(){
  resetForm();
  openModal(false);
};

btnClose.onclick = closeModal;
btnReset.onclick = resetForm;

modal.addEventListener("click", function(e){
  if (e.target === modal) closeModal();
});

gia_ban.addEventListener("input", function(){
  let v = gia_ban.value.replace(/[^\d]/g, "");
  gia_ban.value = v ? Number(v).toLocaleString("vi-VN") : "";
});

hinh_anh.addEventListener("change", function(){
  if (hinh_anh.files && hinh_anh.files[0]) {
    previewImg.src = URL.createObjectURL(hinh_anh.files[0]);
  }
});

async function loadDanhMuc(){
  const r = await fetch(API_DM + "?action=list&t=" + Date.now(), {
    credentials:"same-origin",
    cache:"no-store"
  });

  const d = await r.json();

  id_danh_muc.innerHTML = `<option value="">-- Chọn danh mục --</option>`;

  if (!d.ok){
    showToast(d.msg || "Không tải được danh mục", false);
    return;
  }

  const items = d.items || [];
  const parents = items.filter(x => !x.id_cha && String(x.trang_thai) === "1");
  const children = items.filter(x => x.id_cha && String(x.trang_thai) === "1");

  parents.forEach(parent => {
    const group = document.createElement("optgroup");
    group.label = parent.ten_danh_muc;

    const childList = children.filter(c => Number(c.id_cha) === Number(parent.id));

    if (childList.length === 0) {
      const opt = document.createElement("option");
      opt.value = parent.id;
      opt.textContent = parent.ten_danh_muc + " (danh mục lớn)";
      group.appendChild(opt);
    } else {
      childList.forEach(child => {
        const opt = document.createElement("option");
        opt.value = child.id;
        opt.textContent = "↳ " + child.ten_danh_muc;
        group.appendChild(opt);
      });
    }

    id_danh_muc.appendChild(group);
  });
}

async function loadSanPham(){
  const r = await fetch(API_SP + "?action=admin_list&t=" + Date.now(), {
    credentials:"same-origin",
    cache:"no-store"
  });

  const d = await r.json();

  if (!d.ok){
    list.innerHTML = `<tr><td colspan="9">Không tải được sản phẩm: ${esc(d.msg || "")}</td></tr>`;
    return;
  }

  ALL = d.items || [];
  renderTable();
}

function renderTable(){
  const text = (q.value || "").toLowerCase().trim();

  const items = ALL.filter(p =>
    !text ||
    String(p.ma_sku || "").toLowerCase().includes(text) ||
    String(p.ten_san_pham || "").toLowerCase().includes(text)
  );

  if (!items.length){
    list.innerHTML = `<tr><td colspan="9">Chưa có sản phẩm</td></tr>`;
    return;
  }

  list.innerHTML = items.map(p => `
    <tr>
      <td><b>#${esc(p.id)}</b></td>
      <td>
        ${
          p.hinh_anh
          ? `<img src="/petshop/petshop/assets/uploads/products/${esc(p.hinh_anh)}" width="64" height="64" style="object-fit:cover;border-radius:12px;border:1px solid #e5e7eb">`
          : `<span class="muted">No</span>`
        }
      </td>
      <td><b>${esc(p.ma_sku || "")}</b></td>
      <td>
        <div style="font-weight:900">${esc(p.ten_san_pham || "")}</div>
        <div class="muted">${esc(String(p.mo_ta || "").slice(0,80))}</div>
      </td>
      <td>
        ${p.ten_danh_muc_cha ? `<span class="muted">${esc(p.ten_danh_muc_cha)} / </span>` : ""}
        <b>${esc(p.ten_danh_muc || "")}</b>
      </td>
      <td><b>${money(p.gia_ban)}</b></td>
      <td><b>${esc(p.ton_kho || 0)}</b></td>
      <td>
        ${String(p.trang_thai)==="1" 
          ? `<span class="badge">Bán</span>` 
          : `<span class="badge" style="opacity:.6">Ẩn</span>`}
      </td>
      <td>
        <div class="actions">
          <button class="btn btn--ghost" onclick='editSP(${JSON.stringify(p).replaceAll("'", "\\'")})'>Sửa</button>
          <button class="btn btn--danger" onclick="delSP(${p.id})">Xóa</button>
        </div>
      </td>
    </tr>
  `).join("");
}

q.oninput = renderTable;

function editSP(p){
  resetForm();

  id.value = p.id;
  id_danh_muc.value = p.id_danh_muc;
  ma_sku.value = p.ma_sku || "";
  ten_san_pham.value = p.ten_san_pham || "";
  mo_ta.value = p.mo_ta || "";
  gia_ban.value = Number(p.gia_ban || 0).toLocaleString("vi-VN");
  ton_kho.value = p.ton_kho || 0;
  trang_thai.value = p.trang_thai || 1;

  previewImg.src = p.hinh_anh
    ? `/petshop/petshop/assets/uploads/products/${p.hinh_anh}`
    : "/petshop/petshop/assets/img/no-image.png";

  openModal(true);
}

async function delSP(pid){
  if (!confirm("Xóa sản phẩm này?")) return;

  const fd = new FormData();
  fd.append("action","delete");
  fd.append("id", pid);

  const r = await fetch(API_SP, {
    method:"POST",
    body:fd,
    credentials:"same-origin"
  });

  const d = await r.json();

  if (!d.ok){
    showToast(d.msg || "Xóa thất bại", false);
    return;
  }

  showToast(d.msg || "Đã xóa sản phẩm");
  await loadSanPham();
}

f.onsubmit = async function(e){
  e.preventDefault();
  formMsg.style.display = "none";

  if (!id_danh_muc.value){
    formMsg.style.display = "block";
    formMsg.innerText = "Vui lòng chọn danh mục";
    return;
  }

  const fd = new FormData(f);
  fd.append("action","save");

  const r = await fetch(API_SP, {
    method:"POST",
    body:fd,
    credentials:"same-origin"
  });

  const d = await r.json();

  if (!d.ok){
    formMsg.style.display = "block";
    formMsg.innerText = d.msg || "Lưu thất bại";
    return;
  }

  showToast(d.msg || "Lưu thành công");
  closeModal();
  await loadSanPham();
};

document.addEventListener("DOMContentLoaded", async function(){
  await loadDanhMuc();
  await loadSanPham();
});
</script>

<?php include __DIR__ . "/_footer.php"; ?>