<?php
$id = intval($_GET["id"] ?? 0);
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Mock Payment Gateway</title>
  <style>
    body{font-family:system-ui;padding:24px;background:#f6f7fb}
    .card{max-width:560px;margin:0 auto;background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:18px}
    button{padding:10px 14px;border-radius:12px;border:none;cursor:pointer;font-weight:800}
    .ok{background:#111827;color:#fff}
  </style>
</head>
<body>
  <div class="card">
    <h2>Thanh toán Online (Mô phỏng)</h2>
    <p>Đơn hàng: <b>#<?= $id ?></b></p>
    <p>Nhấn nút bên dưới để mô phỏng “thanh toán thành công”.</p>

    <button class="ok" id="btnPay">Thanh toán thành công</button>
    <p id="msg"></p>
  </div>

<script>
document.getElementById("btnPay").onclick = async () => {
  const fd = new FormData();
  fd.append("action","online_success");
  fd.append("id_don_hang","<?= $id ?>");

  const r = await fetch("/petshop/petshop/admin/api/api_thanh_toan.php", { method:"POST", body:fd, credentials:"same-origin" });
  const d = await r.json();
  document.getElementById("msg").innerText = d.ok ? "✅ Đã thanh toán! Bạn có thể đóng trang này." : ("❌ " + (d.msg||"Lỗi"));
};
</script>
</body>
</html>
