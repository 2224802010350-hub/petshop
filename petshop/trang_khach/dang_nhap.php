<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$err = $_GET['err'] ?? '';
?>

<style>
.vpAuthWrap{
  min-height:calc(100vh - 110px);
  padding:70px 20px;
  display:flex;
  align-items:center;
  justify-content:center;
  background:
    linear-gradient(rgba(255,255,255,.72), rgba(255,255,255,.86)),
    url("https://images.unsplash.com/photo-1601758123927-1967c6a3f4fd?q=80&w=1600&auto=format&fit=crop")
    center/cover no-repeat;
}

.vpAuthCard{
  width:100%;
  max-width:470px;
  background:white;
  border-radius:28px;
  padding:34px;
  box-shadow:0 25px 70px rgba(15,23,42,.18);
  border:1px solid #f1f5f9;
  position:relative;
  overflow:hidden;
}

.vpAuthCard:before{
  content:"🐾";
  position:absolute;
  right:20px;
  top:10px;
  font-size:80px;
  opacity:.07;
}

.vpLogoMini{
  width:64px;
  height:64px;
  border-radius:22px;
  background:linear-gradient(135deg,#f97316,#fb923c);
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:32px;
  color:white;
  margin-bottom:16px;
  box-shadow:0 12px 30px rgba(249,115,22,.28);
}

.vpAuthHead h1{
  margin:0;
  font-size:32px;
  color:#0f172a;
}

.vpAuthHead p{
  margin:10px 0 24px;
  color:#64748b;
  line-height:1.5;
}

.vpAuthError{
  padding:13px 15px;
  border-radius:14px;
  margin-bottom:18px;
  background:#fee2e2;
  color:#991b1b;
  font-weight:700;
  border:1px solid #fecaca;
}

.vpField{
  margin-bottom:16px;
}

.vpField label{
  display:block;
  margin-bottom:8px;
  font-weight:800;
  color:#334155;
}

.vpField .input{
  width:100%;
  padding:15px 16px;
  border-radius:16px;
  border:1px solid #dbe3ef;
  outline:none;
  background:#f8fafc;
  font-size:15px;
  transition:.2s;
}

.vpField .input:focus{
  background:white;
  border-color:#f97316;
  box-shadow:0 0 0 4px rgba(249,115,22,.14);
}

.vpBtnSubmit{
  width:100%;
  padding:15px;
  border:0;
  border-radius:999px;
  background:linear-gradient(135deg,#f97316,#ea580c);
  color:white;
  font-size:16px;
  font-weight:900;
  cursor:pointer;
  transition:.2s;
  box-shadow:0 14px 30px rgba(249,115,22,.25);
}

.vpBtnSubmit:hover{
  transform:translateY(-2px);
  box-shadow:0 18px 36px rgba(249,115,22,.35);
}

.vpAuthNote{
  margin:18px 0 0;
  text-align:center;
  color:#64748b;
}

.vpAuthNote a{
  color:#f97316;
  font-weight:900;
  text-decoration:none;
}

.vpPets{
  margin-top:16px;
  text-align:center;
  font-size:24px;
}
</style>

<section class="vpAuthWrap">
  <div class="vpAuthCard">
    <div class="vpLogoMini">🐶</div>

    <div class="vpAuthHead">
      <h1>Đăng nhập khách hàng</h1>
      <p>Chào mừng bạn quay lại với VuiPet. Đăng nhập để mua sắm và tích điểm thân thiết.</p>
    </div>

    <?php if ($err): ?>
      <div class="vpAuthError">
        <?php echo htmlspecialchars($err); ?>
      </div>
    <?php endif; ?>

    <form method="post" action="/petshop/petshop/api/api_dang_nhap.php" class="vpAuthForm">
      <input type="hidden" name="src" value="khach">

      <div class="vpField">
        <label for="ten_dang_nhap">Tên đăng nhập</label>
        <input id="ten_dang_nhap" class="input" name="ten_dang_nhap" placeholder="Nhập tên đăng nhập" required>
      </div>

      <div class="vpField">
        <label for="mat_khau">Mật khẩu</label>
        <input id="mat_khau" class="input" type="password" name="mat_khau" placeholder="Nhập mật khẩu" required>
      </div>

      <button class="vpBtnSubmit" type="submit">Đăng nhập</button>
    </form>

    <div class="vpPets">🐶 🐱 🐰 🐾</div>

    <p class="vpAuthNote">
  Chưa có tài khoản?
  <a href="/petshop/petshop/trang_khach/dang_ky.php">Đăng ký ngay</a>
</p>

<p class="vpAuthNote" style="margin-top:8px">
  Admin/nhân viên đăng nhập tại:
  <a href="/petshop/petshop/admin/dang_nhap.php">Admin Login</a>
</p>
  </div>
</section>

</main>
</body>
</html>