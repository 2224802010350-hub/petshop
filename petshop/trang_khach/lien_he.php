<?php include __DIR__ . "/header.php"; ?>

<section class="lhWrap">
  <div class="lhCrumb">
    <a href="trang_chu.php">Trang chủ</a>
    <span>/</span>
    <span>Liên hệ</span>
  </div>

  <div class="lhGrid">
    <div class="lhInfo">
      <h2>Thông tin liên hệ</h2>

      <div class="lhBrand">VuiPet</div>

      <div class="lhLine">
        <b>Hotline:</b>
        <a href="tel:0922062144">0922 062 144</a>
      </div>

      <div class="lhLine">
        <b>Zalo:</b>
        <a href="https://zalo.me/0922062144" target="_blank" rel="noopener">0922 062 144</a>
      </div>

      <div class="lhLine">
        <b>Email:</b>
        <span>vuipet@example.com</span>
      </div>

      <div class="lhLine">
        <b>Địa chỉ:</b>
        <span>123 Nguyễn Văn A, TP.HCM</span>
      </div>

      <div class="lhNote">
        Ghi chú: form này hiện là demo UI. Bạn có thể nối DB hoặc gửi email sau.
      </div>
    </div>

    <div class="lhFormCard">
      <h3>Gửi yêu cầu liên hệ</h3>

      <form class="lhForm" action="#" method="post" onsubmit="alert('Demo UI: Chưa xử lý backend.'); return false;">
        <div class="lhRow">
          <input type="text" name="hoten" placeholder="Họ tên" required>
        </div>

        <div class="lhRow lhRow2">
          <input type="email" name="email" placeholder="Địa chỉ email" required>
          <input type="tel" name="phone" placeholder="Số điện thoại" required>
        </div>

        <div class="lhRow">
          <textarea name="noidung" rows="4" placeholder="Yêu cầu" required></textarea>
        </div>

        <div class="lhCaptcha">
          <label class="lhFakeCaptcha">
            <input type="checkbox" required>
            <span>Tôi không phải là người máy</span>
          </label>
          <div class="lhCaptchaRight">
            <div class="lhCaptchaBadge">reCAPTCHA</div>
            <small>Bảo mật - Điều khoản</small>
          </div>
        </div>

        <button class="lhBtn" type="submit">GỬI YÊU CẦU LIÊN HỆ</button>
      </form>
    </div>
  </div>

  <div class="lhMap">
    <iframe
      src="https://www.google.com/maps?q=Trường%20Đại%20học%20Thủ%20Dầu%20Một&output=embed"
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade"
      allowfullscreen>
    </iframe>
  </div>
</section>

<?php include __DIR__ . "/footer_contact.php"; ?>

</main>
</body>
</html>
