<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['user'])) { header("Location: dang_nhap.php"); exit; }
include __DIR__ . "/_header.php";
?>

<div class="card" style="width:100%;max-width:none;margin:0">
  <div class="card__head">
    <h2>🛒 POS - Tạo đơn tại quầy</h2>
    <div class="row" style="flex:1;justify-content:flex-end">
      <a class="btn btn--ghost" href="/petshop/petshop/admin/don_hang.php">← Danh sách đơn</a>
    </div>
  </div>

  <div class="card__body">
    <div class="toast" id="toast"></div>

    <div class="grid2" style="grid-template-columns:1.2fr .8fr;gap:14px">
      <div class="card" style="box-shadow:none">
        <div class="card__head">
          <b>Tìm sản phẩm</b>
          <div class="row" style="flex:1;justify-content:flex-end">
            <input class="input" id="qsp" placeholder="Nhập tên hoặc SKU..." style="max-width:360px">
          </div>
        </div>

        <div class="card__body">
          <div class="tableWrap" style="max-height:420px">
            <table>
              <thead>
                <tr>
                  <th>Sản phẩm</th>
                  <th style="width:130px">Giá</th>
                  <th style="width:90px">Tồn</th>
                  <th style="width:120px"></th>
                </tr>
              </thead>
              <tbody id="spList"></tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="card" style="box-shadow:none">
        <div class="card__head">
          <b>Giỏ hàng</b>
          <span class="badge" id="count">0 món</span>
        </div>

        <div class="card__body">
          <div style="margin-bottom:10px; position:relative">
            <label class="muted">Khách hàng</label>

            <div class="row" style="gap:8px">
              <input class="input" id="qkh" placeholder="Nhập SĐT, tên hoặc email để tìm khách" style="flex:1">
              <button class="btn btn--ghost" type="button" onclick="openCustomerModal()">+ Thêm</button>
            </div>

            <div id="khSuggest" style="display:none;margin-top:8px;border:1px solid #e5e7eb;border-radius:12px;background:#fff;overflow:hidden"></div>

            <div class="muted" style="margin-top:6px" id="khInfo">Khách: <b>Khách lẻ</b></div>
          </div>

          <div class="tableWrap" style="max-height:260px">
            <table>
              <thead>
                <tr>
                  <th>Sản phẩm</th>
                  <th style="width:70px">SL</th>
                  <th style="width:110px">Thành tiền</th>
                  <th style="width:40px"></th>
                </tr>
              </thead>
              <tbody id="cart"></tbody>
            </table>
          </div>

          <div class="hr"></div>

          <div class="row" style="justify-content:space-between">
            <div class="muted">Tạm tính</div>
            <b id="tamTinh">0 ₫</b>
          </div>

          <div class="row" style="justify-content:space-between;margin-top:6px">
            <div class="muted">Giảm giá</div>
            <b id="giamGia">0 ₫</b>
          </div>

          <div class="row" style="justify-content:space-between;margin-top:6px">
            <div style="font-weight:900">Tổng</div>
            <div style="font-size:20px;font-weight:900" id="tong">0 ₫</div>
          </div>

          <div class="hr"></div>

          <div class="row" style="justify-content:flex-end">
            <button class="btn btn--ghost" id="btnClear">Xóa giỏ</button>
            <button class="btn" id="btnCreate">Tạo đơn</button>
          </div>

          <div class="muted" style="margin-top:10px">
            Sau khi tạo đơn, bạn có thể vào danh sách đơn để thanh toán/in hóa đơn.
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="customerModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.35);z-index:9999;align-items:center;justify-content:center">
  <div class="card" style="width:430px;max-width:95%;padding:20px">
    <h3 style="margin-top:0">Thêm khách hàng mới</h3>

    <input class="input" id="newName" placeholder="Họ tên" style="margin-bottom:10px">
    <input class="input" id="newPhone" placeholder="Số điện thoại" style="margin-bottom:10px">
    <input class="input" id="newEmail" placeholder="Email" style="margin-bottom:10px">
    <input class="input" id="newAddress" placeholder="Địa chỉ" style="margin-bottom:14px">

    <div class="row" style="justify-content:flex-end;gap:8px">
      <button class="btn btn--ghost" type="button" onclick="closeCustomerModal()">Đóng</button>
      <button class="btn" type="button" onclick="saveNewCustomer()">Lưu khách</button>
    </div>
  </div>
</div>

<script>
const API_SP = "api/api_san_pham.php?action=list";
const API_DON = "api/api_don_hang.php";

const toast = document.getElementById("toast");

function showToast(text, ok=true){
  toast.className = "toast " + (ok ? "ok" : "err");
  toast.style.display = "block";
  toast.innerText = text;
  setTimeout(() => toast.style.display = "none", 2600);
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

let PRODUCTS = [];
let CART = [];
let KH = null;

const spList = document.getElementById("spList");
const qsp = document.getElementById("qsp");
const cart = document.getElementById("cart");
const count = document.getElementById("count");
const tamTinh = document.getElementById("tamTinh");
const giamGia = document.getElementById("giamGia");
const tong = document.getElementById("tong");
const btnClear = document.getElementById("btnClear");
const btnCreate = document.getElementById("btnCreate");
const qkh = document.getElementById("qkh");
const khInfo = document.getElementById("khInfo");
const khSuggest = document.getElementById("khSuggest");

async function loadProducts(){
  try {
    const r = await fetch(API_SP, { credentials:"same-origin" });
    const d = await r.json();

    if (!d.ok){
      spList.innerHTML = `<tr><td colspan="4">Không tải được sản phẩm</td></tr>`;
      return;
    }

    PRODUCTS = d.items || [];
    renderProducts(PRODUCTS);
  } catch (e) {
    spList.innerHTML = `<tr><td colspan="4">Lỗi tải sản phẩm</td></tr>`;
  }
}

function renderProducts(items){
  const text = (qsp.value || "").toLowerCase().trim();

  const filtered = !text ? items : items.filter(p =>
    (p.ten_san_pham || "").toLowerCase().includes(text) ||
    (p.ma_sku || "").toLowerCase().includes(text)
  );

  if (!filtered.length){
    spList.innerHTML = `<tr><td colspan="4">Không có sản phẩm</td></tr>`;
    return;
  }

  spList.innerHTML = filtered.map(p => `
    <tr>
      <td>
        <div style="font-weight:900">${esc(p.ten_san_pham)}</div>
        <div class="muted">${esc(p.ma_sku || "")}</div>
      </td>
      <td><b>${money(p.gia_ban)}</b></td>
      <td><b>${p.ton_kho}</b></td>
      <td>
        <button class="btn btn--ghost" onclick="addToCart(${p.id})">Thêm</button>
      </td>
    </tr>
  `).join("");
}

function addToCart(pid){
  const p = PRODUCTS.find(x => Number(x.id) === Number(pid));
  if (!p) return;

  if (Number(p.ton_kho) <= 0){
    showToast("Sản phẩm hết hàng", false);
    return;
  }

  const found = CART.find(x => Number(x.id) === Number(pid));

  if (found){
    if (found.so_luong + 1 > Number(p.ton_kho)){
      showToast("Không đủ tồn kho", false);
      return;
    }
    found.so_luong += 1;
  } else {
    CART.push({
      id: Number(p.id),
      ten: p.ten_san_pham,
      gia: Number(p.gia_ban),
      so_luong: 1,
      ton: Number(p.ton_kho)
    });
  }

  renderCart();
}

function renderCart(){
  if (!CART.length){
    cart.innerHTML = `<tr><td colspan="4">Giỏ hàng trống</td></tr>`;
  } else {
    cart.innerHTML = CART.map(it => `
      <tr>
        <td>
          <div style="font-weight:900">${esc(it.ten)}</div>
          <div class="muted">${money(it.gia)}</div>
        </td>
        <td>
          <input class="input" style="padding:8px 10px" type="number" min="1" value="${it.so_luong}"
            onchange="setQty(${it.id}, this.value)">
        </td>
        <td><b>${money(it.gia * it.so_luong)}</b></td>
        <td>
          <button class="btn btn--danger" style="padding:8px 10px" onclick="removeItem(${it.id})">x</button>
        </td>
      </tr>
    `).join("");
  }

  count.innerText = CART.length + " món";
  calc();
}

function setQty(pid, v){
  v = Number(v || 1);

  const it = CART.find(x => Number(x.id) === Number(pid));
  if (!it) return;

  if (v < 1) v = 1;

  if (v > it.ton){
    showToast("Vượt tồn kho", false);
    v = it.ton;
  }

  it.so_luong = v;
  renderCart();
}

function removeItem(pid){
  CART = CART.filter(x => Number(x.id) !== Number(pid));
  renderCart();
}

function calc(){
  let t = 0;
  CART.forEach(it => t += it.gia * it.so_luong);

  tamTinh.innerText = money(t);
  giamGia.innerText = money(0);
  tong.innerText = money(t);
}

btnClear.addEventListener("click", () => {
  CART = [];
  renderCart();
});

qsp.addEventListener("input", () => renderProducts(PRODUCTS));

let khTimer = null;

qkh.addEventListener("input", () => {
  clearTimeout(khTimer);
  khTimer = setTimeout(findKH, 300);
});

async function findKH(){
  const q = (qkh.value || "").trim();

  if (!q){
    KH = null;
    khSuggest.style.display = "none";
    khInfo.innerHTML = `Khách: <b>Khách lẻ</b>`;
    return;
  }

  try {
    const r = await fetch(API_DON + "?action=search_customers&q=" + encodeURIComponent(q), {
      credentials:"same-origin"
    });

    const text = await r.text();
    let d;

    try {
      d = JSON.parse(text);
    } catch (e) {
      khSuggest.style.display = "block";
      khSuggest.innerHTML = `<div style="padding:10px;color:#ef4444">API lỗi: ${esc(text)}</div>`;
      return;
    }

    if (!d.ok || !(d.items || []).length){
      KH = null;
      khSuggest.style.display = "block";
      khSuggest.innerHTML = `<div style="padding:10px;color:#64748b">Không tìm thấy khách hàng</div>`;
      khInfo.innerHTML = `Khách: <b>Khách lẻ</b>`;
      return;
    }

    khSuggest.style.display = "block";
    khSuggest.innerHTML = d.items.map(k => `
      <div onclick="selectCustomer(${Number(k.id)}, '${esc(k.ho_ten)}', '${esc(k.so_dien_thoai)}')"
           style="padding:10px 12px;cursor:pointer;border-bottom:1px solid #e5e7eb">
        <b>${esc(k.ho_ten)}</b><br>
        <span class="muted">${esc(k.so_dien_thoai)}${k.email ? " - " + esc(k.email) : ""}</span>
      </div>
    `).join("");

  } catch (e) {
    khSuggest.style.display = "block";
    khSuggest.innerHTML = `<div style="padding:10px;color:#ef4444">Lỗi tìm khách hàng</div>`;
  }
}

function selectCustomer(id, name, phone){
  KH = {
    id: Number(id),
    ho_ten: name,
    so_dien_thoai: phone
  };

  qkh.value = phone;
  khSuggest.style.display = "none";
  khInfo.innerHTML = `Khách: <b>${esc(name)}</b> (${esc(phone)})`;
}

function openCustomerModal(){
  document.getElementById("customerModal").style.display = "flex";
}

function closeCustomerModal(){
  document.getElementById("customerModal").style.display = "none";
}

async function saveNewCustomer(){
  const name = document.getElementById("newName").value.trim();
  const phone = document.getElementById("newPhone").value.trim();
  const email = document.getElementById("newEmail").value.trim();
  const address = document.getElementById("newAddress").value.trim();

  if (!name || !phone){
    showToast("Vui lòng nhập họ tên và số điện thoại", false);
    return;
  }

  const fd = new FormData();
  fd.append("action", "create_customer");
  fd.append("ho_ten", name);
  fd.append("so_dien_thoai", phone);
  fd.append("email", email);
  fd.append("dia_chi", address);

  try {
    const r = await fetch(API_DON, {
      method:"POST",
      body:fd,
      credentials:"same-origin"
    });

    const d = await r.json();

    if (!d.ok){
      showToast(d.msg || "Không thêm được khách hàng", false);
      return;
    }

    KH = d.customer;
    qkh.value = KH.so_dien_thoai;
    khInfo.innerHTML = `Khách: <b>${esc(KH.ho_ten)}</b> (${esc(KH.so_dien_thoai)})`;

    document.getElementById("newName").value = "";
    document.getElementById("newPhone").value = "";
    document.getElementById("newEmail").value = "";
    document.getElementById("newAddress").value = "";

    closeCustomerModal();
    showToast("Đã thêm và chọn khách hàng");
  } catch (e) {
    showToast("Lỗi thêm khách hàng", false);
  }
}

btnCreate.addEventListener("click", async () => {
  if (!CART.length){
    showToast("Giỏ hàng trống", false);
    return;
  }

  const payloadItems = CART.map(it => ({
    id: it.id,
    so_luong: it.so_luong
  }));

  const fd = new FormData();
  fd.append("action", "create");
  fd.append("id_khach_hang", KH ? KH.id : 0);
  fd.append("items", JSON.stringify(payloadItems));

  try {
    const r = await fetch(API_DON, {
      method:"POST",
      body:fd,
      credentials:"same-origin"
    });

    const d = await r.json();

    if (!d.ok){
      showToast(d.msg || "Tạo đơn thất bại", false);
      return;
    }

    showToast("Đã tạo đơn #" + d.id_don_hang);

    CART = [];
    renderCart();

    setTimeout(() => {
      window.location.href = "/petshop/petshop/admin/don_hang.php";
    }, 800);
  } catch (e) {
    showToast("Lỗi tạo đơn", false);
  }
});

document.addEventListener("click", function(e){
  if (!e.target.closest("#qkh") && !e.target.closest("#khSuggest")) {
    khSuggest.style.display = "none";
  }
});

document.addEventListener("DOMContentLoaded", async () => {
  await loadProducts();
  renderCart();
});
</script>

<?php include __DIR__ . "/_footer.php"; ?>