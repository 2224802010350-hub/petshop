<?php
if (session_status() === PHP_SESSION_NONE) session_start();

include __DIR__ . "/header.php";
require_once __DIR__ . "/../config/ket_noi_csdl.php";

$cart = $_SESSION["cart"] ?? [];
$items = [];
$tong = 0;

if (!empty($cart)) {
  $ids = array_map("intval", array_keys($cart));
  $ids = array_filter($ids);

  if (!empty($ids)) {
    $in = implode(",", $ids);

    $rs = $conn->query("
      SELECT id, ten_san_pham, gia_ban, hinh_anh, ton_kho
      FROM san_pham
      WHERE id IN ($in)
    ");

    if ($rs) {
      while ($sp = $rs->fetch_assoc()) {
        $qty = (int)($cart[$sp["id"]] ?? 1);
        $sp["qty"] = $qty;
        $sp["thanh_tien"] = $qty * (int)$sp["gia_ban"];
        $tong += $sp["thanh_tien"];
        $items[] = $sp;
      }
    }
  }
}

function img_cart($img) {
  if (!$img) return "/petshop/petshop/assets/img/no-image.jpg";
  if (preg_match("#^https?://#i", $img)) return $img;
  if (str_starts_with($img, "/")) return $img;
  return "/petshop/petshop/assets/uploads/products/" . rawurlencode($img);
}
?>

<style>
.cartWrap{max-width:1200px;margin:40px auto;padding:0 20px}
.cartTitle{font-size:38px;font-weight:900;margin:0 0 24px;color:#0f172a}
.cartGrid{display:grid;grid-template-columns:1.4fr .6fr;gap:24px}
.cartBox,.checkoutBox,.orderBox{background:white;border-radius:28px;padding:26px;box-shadow:0 18px 45px rgba(15,23,42,.08);border:1px solid #eef2f7}
.cartItem{display:grid;grid-template-columns:90px 1fr 120px 150px 90px;gap:16px;align-items:center;padding:16px 0;border-bottom:1px solid #e5e7eb}
.cartItem img{width:90px;height:90px;object-fit:cover;border-radius:18px;background:#f1f5f9}
.cartName{font-weight:900;color:#0f172a;line-height:1.35}
.cartPrice{color:#f97316;font-weight:900;margin-top:5px}
.cartStock{color:#64748b;font-size:14px;margin-top:4px}
.qtyInput{width:86px;padding:12px;border:1px solid #dbe3ef;border-radius:14px;font-weight:800}
.btn{border:0;border-radius:999px;padding:13px 18px;font-weight:900;cursor:pointer;transition:.2s}
.btn:hover{transform:translateY(-1px)}
.btnOrange{background:#f97316;color:white}
.btnDark{background:#0f172a;color:white}
.btnGhost{background:#f1f5f9;color:#0f172a}
.btnDanger{background:#ef4444;color:white}
.checkoutBox h2{margin:0 0 18px;font-size:28px;font-weight:900}
.total{font-size:26px;font-weight:900;color:#f97316;margin-bottom:12px}
.pointText{color:#64748b;margin-bottom:18px}
.checkoutBox input,.checkoutBox select{width:100%;padding:15px 16px;border:1px solid #dbe3ef;border-radius:16px;margin-bottom:12px;font-size:15px;outline:none;background:#f8fafc}
.checkoutBox input:focus,.checkoutBox select:focus{background:white;border-color:#f97316;box-shadow:0 0 0 4px rgba(249,115,22,.12)}
.empty{padding:34px;text-align:center;color:#64748b;background:#f8fafc;border-radius:20px;font-weight:700}
.orderSection{max-width:1200px;margin:34px auto 70px;padding:0 20px}
.orderHead{display:flex;justify-content:space-between;align-items:center;gap:16px;margin-bottom:22px}
.orderHead h2{margin:0;font-size:30px;font-weight:900}
.sectionTag{display:inline-block;padding:8px 16px;border-radius:999px;background:#fff7ed;color:#f97316;font-weight:900;margin-bottom:10px}
.orderSearch{display:flex;gap:10px}
.orderSearch input{width:260px;padding:14px 16px;border-radius:999px;border:1px solid #dbe3ef;outline:none}
.orderSearch button{border:0;border-radius:999px;padding:14px 24px;background:#f97316;color:white;font-weight:900;cursor:pointer}
.orderCard{border:1px solid #fed7aa;border-radius:22px;padding:18px;margin-bottom:16px;background:#fffaf5}
.orderTop{display:flex;justify-content:space-between;gap:14px;align-items:center}
.orderCode{font-size:20px;font-weight:900}
.orderDate{color:#64748b;margin-top:5px}
.orderMoney{color:#f97316;font-size:22px;font-weight:900}
.orderBtn{border:0;border-radius:999px;padding:12px 18px;background:#0f172a;color:white;font-weight:900;cursor:pointer}
.orderDetail{display:none;margin-top:16px;padding-top:16px;border-top:1px dashed #f97316}
.orderProduct{display:flex;justify-content:space-between;gap:16px;padding:10px 0;color:#334155}
.orderEmpty{padding:26px;text-align:center;color:#64748b;background:#f8fafc;border-radius:18px;font-weight:700}
@media(max-width:900px){
  .cartGrid{grid-template-columns:1fr}
  .cartItem{grid-template-columns:80px 1fr}
  .hideMobile{display:none}
  .orderHead{flex-direction:column;align-items:flex-start}
  .orderSearch{width:100%}
  .orderSearch input{width:100%}
  .orderTop{flex-direction:column;align-items:flex-start}
}
</style>

<section class="cartWrap">
  <h1 class="cartTitle">🛒 Giỏ hàng của bạn</h1>

  <div class="cartGrid">
    <div class="cartBox">
      <?php if (empty($items)): ?>
        <div class="empty">Giỏ hàng đang trống.</div>
      <?php else: ?>
        <?php foreach ($items as $it): ?>
          <div class="cartItem">
            <img
              src="<?= htmlspecialchars(img_cart($it["hinh_anh"])) ?>"
              onerror="this.src='/petshop/petshop/assets/img/no-image.jpg'">

            <div>
              <div class="cartName"><?= htmlspecialchars($it["ten_san_pham"]) ?></div>
              <div class="cartPrice"><?= number_format((int)$it["gia_ban"],0,",",".") ?>đ</div>
              <div class="cartStock">
                Tồn kho:
                <?= (int)$it["ton_kho"] > 0 ? (int)$it["ton_kho"] : "Tạm hết hàng" ?>
              </div>
            </div>

            <div>
              <input
                class="qtyInput"
                type="number"
                min="1"
                max="<?= max(1, (int)$it["ton_kho"]) ?>"
                value="<?= (int)$it["qty"] ?>"
                onchange="updateCart(<?= (int)$it['id'] ?>, this.value)">
            </div>

            <div class="hideMobile">
              <b><?= number_format((int)$it["thanh_tien"],0,",",".") ?>đ</b>
            </div>

            <button class="btn btnDanger" onclick="deleteCart(<?= (int)$it['id'] ?>)">
              Xóa
            </button>
          </div>
        <?php endforeach; ?>

        <div style="margin-top:18px;text-align:right">
          <button class="btn btnGhost" onclick="clearCart()">
            Xóa toàn bộ giỏ
          </button>
        </div>
      <?php endif; ?>
    </div>

    <div class="checkoutBox">
      <h2>Thanh toán</h2>

      <div class="total">
        Tổng: <?= number_format($tong,0,",",".") ?>đ
      </div>

      <div class="pointText">
        Điểm nhận được:
        <b><?= floor($tong / 10000) ?></b> điểm
      </div>

      <input id="ho_ten" placeholder="Họ tên người nhận">
      <input id="so_dien_thoai" placeholder="Số điện thoại">
      <input id="email" placeholder="Email">
      <input id="dia_chi" placeholder="Địa chỉ giao hàng">

      <select id="phuong_thuc_tt">
        <option value="COD">Thanh toán COD</option>
        <option value="TIEN_MAT">Tiền mặt</option>
        <option value="CHUYEN_KHOAN">Chuyển khoản</option>
      </select>

      <button class="btn btnOrange" style="width:100%" onclick="checkout()">
        Thanh toán
      </button>
    </div>
  </div>
</section>

<section class="orderSection">
  <div class="orderBox">
    <div class="orderHead">
      <div>
        <span class="sectionTag">Đơn hàng</span>
        <h2>🧾 Đơn hàng đã đặt</h2>
      </div>

      <div class="orderSearch">
        <input id="sdt_check" placeholder="Nhập số điện thoại">
        <button onclick="loadDonHang()">Xem đơn</button>
      </div>
    </div>

    <div id="donHangList">
      <div class="orderEmpty">Nhập số điện thoại để xem lịch sử đơn hàng.</div>
    </div>
  </div>
</section>

<script>
const API_CART = "/petshop/petshop/api/api_gio_hang.php";
const API_DH = "/petshop/petshop/api/api_don_hang.php";

async function updateCart(id, qty){
  const fd = new FormData();
  fd.append("action", "update");
  fd.append("id_san_pham", id);
  fd.append("so_luong", qty);

  const r = await fetch(API_CART, {
    method:"POST",
    body:fd,
    credentials:"same-origin"
  });

  const d = await r.json();

  if (!d.ok) {
    alert(d.msg || "Lỗi cập nhật giỏ hàng");
    return;
  }

  location.reload();
}

async function deleteCart(id){
  const fd = new FormData();
  fd.append("action", "delete");
  fd.append("id_san_pham", id);

  const r = await fetch(API_CART, {
    method:"POST",
    body:fd,
    credentials:"same-origin"
  });

  const d = await r.json();

  if (!d.ok) {
    alert(d.msg || "Lỗi xóa sản phẩm");
    return;
  }

  location.reload();
}

async function clearCart(){
  if (!confirm("Xóa toàn bộ giỏ hàng?")) return;

  const fd = new FormData();
  fd.append("action", "clear");

  const r = await fetch(API_CART, {
    method:"POST",
    body:fd,
    credentials:"same-origin"
  });

  const d = await r.json();

  if (!d.ok) {
    alert(d.msg || "Lỗi xóa giỏ hàng");
    return;
  }

  location.reload();
}

async function checkout(){
  const fd = new FormData();
  fd.append("action", "checkout");
  fd.append("ho_ten", document.getElementById("ho_ten").value.trim());
  fd.append("so_dien_thoai", document.getElementById("so_dien_thoai").value.trim());
  fd.append("email", document.getElementById("email").value.trim());
  fd.append("dia_chi", document.getElementById("dia_chi").value.trim());
  fd.append("phuong_thuc_tt", document.getElementById("phuong_thuc_tt").value);

  const r = await fetch(API_CART, {
    method:"POST",
    body:fd,
    credentials:"same-origin"
  });

  const d = await r.json();

  if (!d.ok){
    alert(d.msg || "Thanh toán thất bại");
    return;
  }

  alert(d.msg || "Thanh toán thành công");
  location.reload();
}

async function loadDonHang(){
  const sdt = document.getElementById("sdt_check").value.trim();
  const box = document.getElementById("donHangList");

  if(!sdt){
    alert("Nhập số điện thoại để xem đơn hàng");
    return;
  }

  const res = await fetch(API_DH + "?action=list&so_dien_thoai=" + encodeURIComponent(sdt), {
    credentials:"same-origin",
    cache:"no-store"
  });

  const d = await res.json();

  if(!d.ok){
    box.innerHTML = `<div class="orderEmpty">${d.msg || "Không tải được đơn hàng"}</div>`;
    return;
  }

  if(!d.data || d.data.length === 0){
    box.innerHTML = `<div class="orderEmpty">Chưa có đơn hàng nào.</div>`;
    return;
  }

  let html = "";

  d.data.forEach(dh => {
    html += `
      <div class="orderCard">
        <div class="orderTop">
          <div>
            <div class="orderCode">Đơn hàng #${dh.id}</div>
            <div class="orderDate">Ngày đặt: ${dh.ngay_tao || "-"}</div>
          </div>

          <div style="text-align:right">
            <div class="orderMoney">${Number(dh.tong_tien || 0).toLocaleString("vi-VN")}đ</div>
            <button class="orderBtn" onclick="xemChiTiet(${dh.id})">Xem chi tiết</button>
          </div>
        </div>

        <div class="orderDetail" id="ct_${dh.id}">
          Đang tải chi tiết...
        </div>
      </div>
    `;
  });

  box.innerHTML = html;
}

async function xemChiTiet(id){
  const box = document.getElementById("ct_" + id);

  if(box.style.display === "block"){
    box.style.display = "none";
    return;
  }

  box.style.display = "block";
  box.innerHTML = "Đang tải chi tiết...";

  const res = await fetch(API_DH + "?action=detail&id=" + id, {
    credentials:"same-origin",
    cache:"no-store"
  });

  const d = await res.json();

  if(!d.ok || !d.data || d.data.length === 0){
    box.innerHTML = `<div class="orderEmpty">Không có chi tiết đơn hàng.</div>`;
    return;
  }

  let html = "";

  d.data.forEach(sp => {
    const thanhTien = Number(sp.so_luong || 0) * Number(sp.don_gia || 0);

    html += `
      <div class="orderProduct">
        <div>
          <b>${sp.ten_san_pham}</b>
          <div style="color:#64748b;font-size:14px">
            Số lượng: ${sp.so_luong} × ${Number(sp.don_gia || 0).toLocaleString("vi-VN")}đ
          </div>
        </div>
        <b>${thanhTien.toLocaleString("vi-VN")}đ</b>
      </div>
    `;
  });

  box.innerHTML = html;
}
</script>

</main>
</body>
</html>