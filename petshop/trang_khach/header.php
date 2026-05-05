<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once __DIR__ . "/../config/ham_chung.php";

$current = basename($_SERVER['PHP_SELF']);

/*
|--------------------------------------------------------------------------
| Lấy thông tin khách hàng đang đăng nhập
|--------------------------------------------------------------------------
| Có thể project lưu session là $_SESSION['khach']
| hoặc $_SESSION['user'], nên lấy cả hai để tránh lỗi.
*/
$khachDangNhap = $_SESSION['khach'] ?? $_SESSION['user'] ?? null;

$tenKhachHang = "";

if (is_array($khachDangNhap)) {
  $tenKhachHang = trim($khachDangNhap['ho_ten'] ?? '');

  if ($tenKhachHang === '') {
    $tenKhachHang = trim($khachDangNhap['ten_dang_nhap'] ?? '');
  }
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>PetShop</title>

  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="/petshop/petshop/assets/css/vuipet/flatsome.css">
</head>

<body>

<nav class="vpTop">
  <div class="container vpTop__inner">

    <a class="vpLogo" href="/petshop/petshop/trang_khach/trang_chu.php">
      <span class="vpLogo__a">Vui</span><span class="vpLogo__b">Pet</span>
    </a>

    <ul class="vpMenu2">
      <li>
        <a class="vpTab <?= $current == 'gioi_thieu.php' ? 'vpTab--active' : '' ?>"
           href="http://localhost/petshop/petshop/trang_khach/gioi_thieu.php">
          Giới thiệu
        </a>
      </li>

      <li class="vpDrop">
        <button class="vpTab vpTab--drop" type="button">
          Dịch vụ <span class="chev">▾</span>
        </button>

        <div class="vpMega">
          <div class="vpMega__tip"></div>
          <div class="vpMega__col">
            <a class="vpMega__item" href="http://localhost/petshop/petshop/trang_khach/dich_vu/dich_vu_spa.php">Dịch vụ Spa – Cắt tỉa lông</a>
            <a class="vpMega__item" href="http://localhost/petshop/petshop/trang_khach/dich_vu/dich_vu_hoboi_sanchoi.php">Hồ bơi – sân chơi thú cưng</a>
            <a class="vpMega__item" href="http://localhost/petshop/petshop/trang_khach/dich_vu/dich_vu_khachsan.php">Khách sạn thú cưng (lưu trú)</a>
          </div>
        </div>
      </li>

      <li class="vpDrop">
        <button class="vpTab vpTab--drop" type="button">
          Kiến thức <span class="chev">▾</span>
        </button>

        <div class="vpMega vpMega--2col">
          <div class="vpMega__tip"></div>

          <div class="vpMega__col">
            <div class="vpMega__title">KIẾN THỨC NUÔI CHÓ</div>
            <a class="vpMega__item" href="/petshop/petshop/trang_khach/kien_thuc/index.php">Chọn chó cảnh đẹp</a>
            <a class="vpMega__item" href="/petshop/petshop/trang_khach/kien_thuc/cho_cho_an_gi.php">Cho chó ăn gì?</a>
            <a class="vpMega__item" href="/petshop/petshop/trang_khach/kien_thuc/cac_benh_o_cho.php">Các bệnh ở chó</a>
            <a class="vpMega__item" href="/petshop/petshop/trang_khach/kien_thuc/cach_huan_luyen_cho.php">Cách huấn luyện chó</a>
            <a class="vpMega__item" href="/petshop/petshop/trang_khach/kien_thuc/nuoi_cho_sach_thom.php">Nuôi chó sạch thơm</a>
          </div>

          <div class="vpMega__col vpMega__col--line">
            <div class="vpMega__title">KIẾN THỨC CHĂM MÈO</div>
            <a class="vpMega__item" href="/petshop/petshop/trang_khach/kien_thuc/chon_meo_canh_dep.php">Chọn mèo cảnh đẹp</a>
            <a class="vpMega__item" href="/petshop/petshop/trang_khach/kien_thuc/cho_meo_an_gi.php">Cho mèo ăn gì?</a>
            <a class="vpMega__item" href="/petshop/petshop/trang_khach/kien_thuc/cac_benh_o_meo.php">Các bệnh ở mèo</a>
            <a class="vpMega__item" href="/petshop/petshop/trang_khach/kien_thuc/cach_huan_luyen_meo.php">Cách huấn luyện mèo</a>
            <a class="vpMega__item" href="/petshop/petshop/trang_khach/kien_thuc/nuoi_meo_sach_thom.php">Nuôi mèo sạch thơm</a>
          </div>
        </div>
      </li>

      <li class="vpDrop">
        <button class="vpTab vpTab--drop" type="button">
          Chó mèo đang bán <span class="chev">▾</span>
        </button>

        <div class="vpMega vpMega--2col">
          <div class="vpMega__tip"></div>

          <div class="vpMega__col">
            <div class="vpMega__title">CHÓ CẢNH ĐANG BÁN</div>
            <a class="vpMega__item" href="http://localhost/petshop/petshop/trang_khach/cho_meo_dang_ban/cho_bichon.php">Chó Bichon cục bông đáng yêu</a>
            <a class="vpMega__item" href="http://localhost/petshop/petshop/trang_khach/cho_meo_dang_ban/cho_corgi.php">Chó Corgi mông to</a>
            <a class="vpMega__item" href="http://localhost/petshop/petshop/trang_khach/cho_meo_dang_ban/cho_pomeranian.php">Chó Phốc sóc – Pomeranian</a>
            <a class="vpMega__item" href="http://localhost/petshop/petshop/trang_khach/cho_meo_dang_ban/cho_shiba.php">Chó Shiba Inu</a>
            <a class="vpMega__item" href="http://localhost/petshop/petshop/trang_khach/cho_meo_dang_ban/index.php">Xem tất cả</a>
          </div>

          <div class="vpMega__col vpMega__col--line">
            <div class="vpMega__title">MÈO CẢNH ĐANG BÁN</div>
            <a class="vpMega__item" href="http://localhost/petshop/petshop/trang_khach/cho_meo_dang_ban/meo_mainecoon.php">Mèo Maine Coon</a>
            <a class="vpMega__item" href="http://localhost/petshop/petshop/trang_khach/cho_meo_dang_ban/meo_aln.php">Mèo Anh lông ngắn</a>
            <a class="vpMega__item" href="http://localhost/petshop/petshop/trang_khach/cho_meo_dang_ban/meo_ald.php">Mèo Anh lông dài</a>
            <a class="vpMega__item" href="http://localhost/petshop/petshop/trang_khach/cho_meo_dang_ban/meo_xiem.php">Mèo Xiêm</a>
            <a class="vpMega__item" href="http://localhost/petshop/petshop/trang_khach/cho_meo_dang_ban/index.php">Xem tất cả</a>
          </div>
        </div>
      </li>

      <li class="vpDrop">
        <button class="vpTab vpTab--drop" type="button">
          Shop thú cưng <span class="chev">▾</span>
        </button>

        <div class="vpMega vpMega--2col vpMega--wide">
          <div class="vpMega__tip"></div>

          <div class="vpMega__col">
            <div class="vpMega__title">SHOP CHÓ</div>
            <a class="vpMega__item" href="http://localhost/petshop/petshop/trang_khach/shop_thu_cung/thuc_an_cho.php">Thức ăn cho chó</a>
            <a class="vpMega__item" href="http://localhost/petshop/petshop/trang_khach/shop_thu_cung/phu_kien_cho.php">Phụ kiện cho chó</a>
            <a class="vpMega__item" href="http://localhost/petshop/petshop/trang_khach/shop_thu_cung/do_choi_cho.php">Đồ chơi cho chó</a>
            <a class="vpMega__item" href="http://localhost/petshop/petshop/trang_khach/shop_thu_cung/index.php">Xem tất cả</a>
          </div>

          <div class="vpMega__col vpMega__col--line">
            <div class="vpMega__title">SHOP MÈO</div>
            <a class="vpMega__item" href="http://localhost/petshop/petshop/trang_khach/shop_thu_cung/thuc_an_meo.php">Thức ăn cho mèo</a>
            <a class="vpMega__item" href="http://localhost/petshop/petshop/trang_khach/shop_thu_cung/phu_kien_meo.php">Phụ kiện cho mèo</a>
            <a class="vpMega__item" href="http://localhost/petshop/petshop/trang_khach/shop_thu_cung/do_choi_meo.php">Đồ chơi cho mèo</a>
            <a class="vpMega__item" href="http://localhost/petshop/petshop/trang_khach/shop_thu_cung/index.php">Xem tất cả</a>
          </div>
        </div>
      </li>

      <li>
        <a class="vpTab <?= $current == 'lien_he.php' ? 'vpTab--active' : '' ?>"
           href="http://localhost/petshop/petshop/trang_khach/lien_he.php">
          Liên hệ
        </a>
      </li>
    </ul>

    <div class="vpRight">
      <div class="vpSearch2">
        <input id="navSearch" type="text" placeholder="Tìm kiếm ...">
        <button id="navSearchBtn" type="button" aria-label="Tìm kiếm">
          <i class="fas fa-search"></i>
        </button>
      </div>

      <a class="vpCart" href="http://localhost/petshop/petshop/trang_khach/gio_hang.php" title="Giỏ hàng">
        <i class="fas fa-cart-shopping"></i>
      </a>

      <?php if (!empty($khachDangNhap)): ?>

        <div class="vpUserInfo" title="<?= htmlspecialchars($tenKhachHang) ?>">
          <i class="fas fa-user"></i>
          <span class="vpUserInfo__name">
            <?= htmlspecialchars($tenKhachHang) ?>
          </span>
        </div>

        <a class="vpLogin" href="http://localhost/petshop/petshop/api/api_dang_xuat.php?src=khach">
          Đăng xuất
        </a>

      <?php else: ?>

        <a class="vpLogin" href="http://localhost/petshop/petshop/trang_khach/dang_nhap.php">
          Đăng nhập
        </a>

      <?php endif; ?>
    </div>

  </div>
</nav>

<main class="container">

<script>
document.addEventListener("DOMContentLoaded", () => {
  const btn = document.getElementById("navSearchBtn");

  if (btn) {
    btn.addEventListener("click", () => {
      const q = document.getElementById("navSearch").value.trim();
      window.location.href = `danh_muc.php?dm=all&search=${encodeURIComponent(q)}`;
    });
  }

  document.querySelectorAll(".vpDrop > button").forEach((b) => {
    b.addEventListener("click", (e) => {
      const li = e.currentTarget.closest(".vpDrop");
      const isOpen = li.classList.contains("is-open");

      document.querySelectorAll(".vpDrop.is-open").forEach((x) => {
        x.classList.remove("is-open");
      });

      if (!isOpen) {
        li.classList.add("is-open");
      }
    });
  });

  document.addEventListener("click", (e) => {
    if (!e.target.closest(".vpDrop")) {
      document.querySelectorAll(".vpDrop.is-open").forEach((x) => {
        x.classList.remove("is-open");
      });
    }
  });
});
</script>