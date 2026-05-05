<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$err = $_GET['err'] ?? '';
?>

<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Đăng ký khách hàng - VuiPet</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <style>
    *{box-sizing:border-box}

    body{
      margin:0;
      min-height:100vh;
      font-family:Arial, sans-serif;
      background:
        radial-gradient(circle at top left, rgba(249,115,22,.18), transparent 34%),
        radial-gradient(circle at bottom right, rgba(34,197,94,.18), transparent 34%),
        #f8fafc;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:24px;
      color:#0f172a;
    }

    .register-card{
      width:100%;
      max-width:540px;
      background:white;
      border-radius:30px;
      padding:38px;
      box-shadow:0 25px 70px rgba(15,23,42,.15);
      position:relative;
      overflow:hidden;
      border:1px solid #eef2f7;
    }

    .register-card:before{
      content:"🐾";
      position:absolute;
      top:18px;
      right:26px;
      font-size:82px;
      opacity:.07;
    }

    .logo{
      width:68px;
      height:68px;
      border-radius:22px;
      background:linear-gradient(135deg,#f97316,#fb923c);
      display:flex;
      align-items:center;
      justify-content:center;
      font-size:34px;
      box-shadow:0 14px 32px rgba(249,115,22,.28);
      margin-bottom:18px;
    }

    h1{
      margin:0;
      font-size:34px;
      line-height:1.15;
    }

    .desc{
      margin:10px 0 24px;
      color:#64748b;
      line-height:1.5;
    }

    .err{
      background:#fee2e2;
      color:#991b1b;
      padding:13px 15px;
      border-radius:15px;
      margin-bottom:16px;
      border:1px solid #fecaca;
      font-weight:800;
    }

    .grid2{
      display:grid;
      grid-template-columns:1fr 1fr;
      gap:14px;
    }

    .field{
      margin-bottom:15px;
    }

    .field.full{
      grid-column:1/-1;
    }

    label{
      display:block;
      font-weight:900;
      margin-bottom:8px;
      color:#334155;
    }

    input{
      width:100%;
      border:1px solid #dbe3ef;
      border-radius:16px;
      padding:15px 16px;
      font-size:15px;
      outline:none;
      background:#f8fafc;
      transition:.2s;
    }

    input:focus{
      background:white;
      border-color:#f97316;
      box-shadow:0 0 0 4px rgba(249,115,22,.14);
    }

    .btn{
      width:100%;
      border:0;
      padding:16px;
      border-radius:999px;
      background:linear-gradient(135deg,#f97316,#ea580c);
      color:white;
      font-size:16px;
      font-weight:900;
      cursor:pointer;
      transition:.2s;
      box-shadow:0 14px 32px rgba(249,115,22,.28);
      margin-top:4px;
    }

    .btn:hover{
      transform:translateY(-2px);
      box-shadow:0 18px 40px rgba(249,115,22,.36);
    }

    .pets{
      text-align:center;
      margin-top:16px;
      font-size:24px;
    }

    .note{
      text-align:center;
      color:#64748b;
      margin-top:18px;
      line-height:1.6;
    }

    .note a{
      color:#f97316;
      font-weight:900;
      text-decoration:none;
    }

    .back-home{
      position:fixed;
      top:22px;
      left:22px;
      text-decoration:none;
      background:white;
      color:#0f172a;
      padding:11px 16px;
      border-radius:999px;
      font-weight:900;
      box-shadow:0 10px 28px rgba(15,23,42,.1);
    }

    @media(max-width:650px){
      .register-card{padding:28px}
      .grid2{grid-template-columns:1fr}
      h1{font-size:29px}
      .back-home{position:static;margin-bottom:14px;display:inline-block}
      body{display:block}
    }
  </style>
</head>

<body>

<a class="back-home" href="/petshop/petshop/trang_khach/dang_nhap.php">← Đăng nhập</a>

<div class="register-card">
  <div class="logo">🐶</div>

  <h1>Tạo tài khoản VuiPet</h1>
  <p class="desc">
    Đăng ký tài khoản để mua sắm, đặt dịch vụ và tích điểm thân thiết cho những lần mua sau.
  </p>

  <?php if ($err): ?>
    <div class="err"><?= htmlspecialchars($err) ?></div>
  <?php endif; ?>

  <form method="post" action="/petshop/petshop/api/api_dang_ky.php">
    <div class="grid2">
      <div class="field full">
        <label>Họ tên</label>
        <input name="ho_ten" placeholder="Ví dụ: Nguyễn Văn A" required>
      </div>

      <div class="field">
        <label>Tên đăng nhập</label>
        <input name="ten_dang_nhap" placeholder="Ví dụ: khach1" required>
      </div>

      <div class="field">
        <label>Số điện thoại</label>
        <input name="so_dien_thoai" placeholder="098xxxxxxx">
      </div>

      <div class="field">
        <label>Email</label>
        <input name="email" type="email" placeholder="email@gmail.com">
      </div>

      <div class="field">
        <label>Mật khẩu</label>
        <input name="mat_khau" type="password" placeholder="Nhập mật khẩu" required>
      </div>

      <div class="field full">
        <label>Địa chỉ</label>
        <input name="dia_chi" placeholder="Nhập địa chỉ giao hàng">
      </div>
    </div>

    <button class="btn" type="submit">Đăng ký tài khoản</button>
  </form>

  <div class="pets">🐶 🐱 🐰 🐾</div>

  <div class="note">
    Đã có tài khoản?
    <a href="/petshop/petshop/trang_khach/dang_nhap.php">Đăng nhập ngay</a>
  </div>
</div>

</body>
</html>