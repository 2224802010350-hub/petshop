<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!empty($_SESSION["user"])) {
  header("Location: /petshop/petshop/admin/dashboard.php");
  exit;
}

$err = $_GET["err"] ?? "";
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Đăng nhập Admin - PetShop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <style>
    *{box-sizing:border-box}
    body{
      margin:0;
      min-height:100vh;
      font-family:Arial, sans-serif;
      background:
        radial-gradient(circle at top left, rgba(249,115,22,.22), transparent 35%),
        radial-gradient(circle at bottom right, rgba(37,99,235,.22), transparent 35%),
        #f4f7fb;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:24px;
      color:#0f172a;
    }

    .login-wrap{
      width:100%;
      max-width:1050px;
      display:grid;
      grid-template-columns:1.1fr .9fr;
      background:white;
      border-radius:30px;
      overflow:hidden;
      box-shadow:0 25px 70px rgba(15,23,42,.18);
    }

    .hero{
      padding:46px;
      background:linear-gradient(135deg,#0f172a,#1d4ed8);
      color:white;
      position:relative;
      overflow:hidden;
    }

    .hero:before{
      content:"";
      position:absolute;
      width:260px;
      height:260px;
      border-radius:50%;
      background:rgba(249,115,22,.35);
      right:-80px;
      top:-80px;
    }

    .hero:after{
      content:"🐾";
      position:absolute;
      font-size:170px;
      opacity:.08;
      right:50px;
      bottom:10px;
    }

    .brand{
      display:flex;
      align-items:center;
      gap:14px;
      margin-bottom:42px;
      position:relative;
      z-index:1;
    }

    .logo{
      width:58px;
      height:58px;
      border-radius:18px;
      background:linear-gradient(135deg,#f97316,#22c55e);
      display:flex;
      align-items:center;
      justify-content:center;
      font-size:30px;
      box-shadow:0 12px 30px rgba(0,0,0,.25);
    }

    .brand-title{
      font-size:24px;
      font-weight:900;
    }

    .brand-sub{
      color:#bfdbfe;
      font-size:14px;
      margin-top:3px;
    }

    .hero h1{
      font-size:42px;
      line-height:1.15;
      margin:0 0 14px;
      position:relative;
      z-index:1;
    }

    .hero p{
      font-size:17px;
      color:#dbeafe;
      line-height:1.7;
      margin:0 0 28px;
      position:relative;
      z-index:1;
    }

    .features{
      display:grid;
      gap:12px;
      position:relative;
      z-index:1;
    }

    .feature{
      background:rgba(255,255,255,.12);
      padding:13px 15px;
      border-radius:16px;
      backdrop-filter:blur(8px);
      display:flex;
      gap:10px;
      align-items:center;
      font-weight:700;
    }

    .form-side{
      padding:46px;
      display:flex;
      flex-direction:column;
      justify-content:center;
    }

    .badge{
      display:inline-block;
      width:max-content;
      padding:8px 12px;
      border-radius:999px;
      background:#fff7ed;
      color:#ea580c;
      font-weight:900;
      font-size:13px;
      margin-bottom:16px;
    }

    .form-side h2{
      margin:0;
      font-size:32px;
    }

    .desc{
      color:#64748b;
      margin:8px 0 24px;
      line-height:1.5;
    }

    .notice{
      background:#fee2e2;
      color:#991b1b;
      padding:13px 14px;
      border-radius:14px;
      margin-bottom:16px;
      font-weight:700;
      border:1px solid #fecaca;
    }

    label{
      display:block;
      font-weight:800;
      margin-bottom:7px;
    }

    .input{
      width:100%;
      padding:14px 15px;
      border-radius:15px;
      border:1px solid #dbe3ef;
      font-size:15px;
      outline:none;
      transition:.2s;
      background:#f8fafc;
    }

    .input:focus{
      border-color:#2563eb;
      background:white;
      box-shadow:0 0 0 4px rgba(37,99,235,.12);
    }

    .field{
      margin-bottom:16px;
    }

    .btn{
      width:100%;
      border:none;
      border-radius:16px;
      padding:15px;
      font-size:16px;
      font-weight:900;
      color:white;
      background:linear-gradient(135deg,#f97316,#2563eb);
      cursor:pointer;
      transition:.2s;
      box-shadow:0 12px 28px rgba(37,99,235,.25);
    }

    .btn:hover{
      transform:translateY(-2px);
      box-shadow:0 16px 35px rgba(37,99,235,.34);
    }

    .hint{
      margin-top:18px;
      text-align:center;
      color:#64748b;
      font-size:14px;
    }

    .pets{
      margin-top:22px;
      display:flex;
      justify-content:center;
      gap:10px;
      font-size:26px;
    }

    @media(max-width:850px){
      .login-wrap{
        grid-template-columns:1fr;
      }
      .hero{
        display:none;
      }
      .form-side{
        padding:32px;
      }
    }
  </style>
</head>

<body>
  <div class="login-wrap">

    <section class="hero">
      <div class="brand">
        <div class="logo">🐶</div>
        <div>
          <div class="brand-title">PetShop Admin</div>
          <div class="brand-sub">Hệ thống quản lý cửa hàng thú cưng</div>
        </div>
      </div>

      <h1>Quản lý cửa hàng thú cưng dễ dàng hơn</h1>
      <p>
        Theo dõi sản phẩm, đơn hàng, khách hàng thân thiết, dịch vụ spa thú cưng
        và báo cáo doanh thu trong một hệ thống quản trị.
      </p>

      <div class="features">
        <div class="feature">🐾 Quản lý sản phẩm thú cưng</div>
        <div class="feature">🧾 Theo dõi đơn hàng và thanh toán</div>
        <div class="feature">⭐ Tích điểm khách hàng thân thiết</div>
        <div class="feature">🛁 Quản lý dịch vụ spa, khách sạn thú cưng</div>
      </div>
    </section>

    <section class="form-side">
      <div class="badge">ADMIN LOGIN</div>

      <h2>Đăng nhập quản trị</h2>
      <div class="desc">
        Chào mừng bạn quay lại PetShop. Vui lòng đăng nhập để tiếp tục quản lý hệ thống.
      </div>

      <?php if ($err): ?>
        <div class="notice"><?= htmlspecialchars($err) ?></div>
      <?php endif; ?>

      <form method="post" action="/petshop/petshop/api/api_dang_nhap.php">
        <input type="hidden" name="src" value="admin">

        <div class="field">
          <label>Tên đăng nhập</label>
          <input class="input" name="ten_dang_nhap" placeholder="Nhập tài khoản admin" required>
        </div>

        <div class="field">
          <label>Mật khẩu</label>
          <input class="input" type="password" name="mat_khau" placeholder="Nhập mật khẩu" required>
        </div>

        <button class="btn" type="submit">Đăng nhập vào hệ thống</button>
      </form>

      <div class="hint">PetShop Admin Dashboard</div>
      <div class="pets">🐶 🐱 🐰 🐾</div>
    </section>

  </div>
</body>
</html>