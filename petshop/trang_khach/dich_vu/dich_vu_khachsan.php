<?php
include dirname(__DIR__) . "/header.php";
include dirname(dirname(__DIR__)) . "/config/ket_noi_csdl.php";

$sql_khach_san = "SELECT * FROM dich_vu_khachsan ORDER BY id ASC";
$result_khach_san = $conn->query($sql_khach_san);
?>

<section class="vpPageWrap">
  <div class="vpIntroHead">
    <h2><span>KHÁCH SẠN CHÓ MÈO UY TÍN, CHẤT LƯỢNG CHUẨN 5* TP. HCM</span></h2>
  </div>

  <div class="vpIntroContent">
    <p>
      <strong>
        Khách sạn chó mèo VuiPet với không gian siêu rộng, thoáng, đẹp,
        tiện nghi cho các Boss Cún và Hoàng thượng Mèo có kỳ nghỉ dưỡng tuyệt vời.
      </strong>
    </p>
  </div>
</section>

<section class="vpSpaBanner">
  <img src="https://vuipet.com/wp-content/uploads/2024/08/hotel-thu-cung-vuipet-uy-tin-chat-luong-quan-2-14.jpg" alt="Khách sạn thú cưng">
</section>

<section class="vpHotelPriceWrap">
  <div class="vpHotelPriceBox">

    <div class="vpHotelLogo">
      <h1>VuiPet</h1>
      <p>Muốn VUI - Nuôi PET</p>
    </div>

    <h2 class="vpHotelPriceTitle">NHÀ TRẺ THÚ CƯNG</h2>
    <p class="vpHotelSubTitle">Bảng giá áp dụng chính thức từ 1/2/2026.</p>

    <div class="vpHotelPriceTableWrap">
      <table class="vpHotelPriceTable">
        <thead>
          <tr>
            <th>Chó</th>
            <th>Qua đêm<br><small>Check out trước 12h</small></th>
            <th>Trong ngày<br><small>9h - 17h30</small></th>
            <th>Nửa ngày<br><small>&lt; 6 tiếng</small></th>
            <th>1 - 3 tiếng</th>
          </tr>
        </thead>

        <tbody>
          <?php if ($result_khach_san && $result_khach_san->num_rows > 0) { ?>
            <?php while ($row = $result_khach_san->fetch_assoc()) { ?>
              <tr>
                <td><?php echo htmlspecialchars($row['can_nang']); ?></td>
                <td><?php echo number_format($row['qua_dem'] / 1000); ?></td>
                <td><?php echo number_format($row['trong_ngay'] / 1000); ?></td>
                <td><?php echo number_format($row['nua_ngay'] / 1000); ?></td>
                <td><?php echo number_format($row['mot_den_ba_tieng'] / 1000); ?></td>
              </tr>
            <?php } ?>
          <?php } else { ?>
            <tr>
              <td colspan="5">Chưa có dữ liệu bảng giá khách sạn.</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <p class="vpHotelNote">Bảng giá trọn gói, không phát sinh phụ phí.</p>
    <p class="vpHotelNote">Phụ thu chỉ áp dụng trong các dịp Lễ/Tết theo thông báo trước.</p>

    <div class="vpHotelBottom">
      <div class="vpHotelText">
        <h3>ƯU ĐÃI CHO GÓI LƯU TRÚ DÀI NGÀY</h3>

        <div class="vpHotelLine">
          <span>1 tuần</span>
          <strong>Tặng 1 gói Spa cơ bản</strong>
        </div>

        <div class="vpHotelLine">
          <span>10 ngày</span>
          <strong>Tặng 1 gói Spa cơ bản + Giảm 5%</strong>
        </div><div class="vpHotelLine">
          <span>2 tuần</span>
          <strong>Tặng 2 gói Spa cơ bản + Giảm 7%</strong>
        </div>

        <div class="vpHotelLine">
          <span>3 tuần</span>
          <strong>Tặng 3 gói Spa cơ bản + Giảm 8%</strong>
        </div>

        <div class="vpHotelLine">
          <span>1 tháng</span>
          <strong>Tặng 4 gói Spa cơ bản + Giảm 10%</strong>
        </div>

        <h3 class="vpScheduleTitle">LỊCH TRÌNH NGHỈ DƯỠNG HẰNG NGÀY</h3>

        <div class="vpHotelLine">
          <span>9:00 - 10:00</span>
          <strong>Ăn sáng</strong>
        </div>

        <div class="vpHotelLine">
          <span>10:00 - 17:00</span>
          <strong>Vui chơi với các bạn - chạy nhảy - đi dạo</strong>
        </div>

        <div class="vpHotelLine">
          <span>Sau 17:00</span>
          <strong>Ăn tối</strong>
        </div>

        <div class="vpHotelLine">
          <span>17:30</span>
          <strong>Nghỉ ngơi tự do trong phòng riêng</strong>
        </div>

        <p class="vpFoodNote">
          *Khẩu phần ăn: Hạt khô + thịt heo xay + rau củ<br>
          Nếu bé có thức ăn riêng, ba mẹ đem theo và ghi chú kỹ các phần ăn cho bé.
        </p>
      </div>

      <div class="vpHotelImages">
        <img src="https://vuipet.com/wp-content/uploads/2024/08/hotel-thu-cung-vuipet-uy-tin-chat-luong-quan-2-5.jpg" alt="">
        <img src="https://vuipet.com/wp-content/uploads/2024/08/hotel-thu-cung-vuipet-uy-tin-chat-luong-quan-2-8.jpg" alt="">
        <img src="https://vuipet.com/wp-content/uploads/2023/04/khach-san-cho-meo-vuipet-1-1284x800.png" alt="">
        <img src="https://vuipet.com/wp-content/uploads/2024/08/hotel-thu-cung-vuipet-uy-tin-chat-luong-quan-2-3.jpg" alt="">
        <img src="https://vuipet.com/wp-content/uploads/2023/06/khach-san-cho-cho-vuipet-8-1.jpg" alt="">
        <img src="https://vuipet.com/wp-content/uploads/2024/08/hotel-thu-cung-vuipet-uy-tin-chat-luong-quan-2-10.jpg" alt="">
      </div>
    </div>
  </div>
</section>

<section class="vpBookingWrap" id="dat-lich-khach-san">
  <div class="vpBookingBox">
    <h2 class="vpBookingTitle">Đặt lịch khách sạn thú cưng</h2>
    <p class="vpBookingDesc">Vui lòng nhập thông tin, yêu cầu đặt lịch sẽ gửi đến Admin để xác nhận.</p>

    <form method="POST" action="../../Admin/xu_ly_dat_dich_vu.php" class="vpBookingForm">
      <input type="hidden" name="loai_dich_vu" value="Khách sạn thú cưng">

      <div class="vpFormGrid">
        <div class="vpFormGroup">
          <label>Họ tên khách hàng</label>
          <input type="text" name="ho_ten" required placeholder="Nhập họ tên">
        </div>

        <div class="vpFormGroup">
          <label>Số điện thoại</label>
          <input type="text" name="so_dien_thoai" required placeholder="Nhập số điện thoại">
        </div>

        <div class="vpFormGroup"><label>Tên thú cưng</label>
          <input type="text" name="ten_thu_cung" required placeholder="Ví dụ: Miu, Lu, Bông">
        </div>

        <div class="vpFormGroup">
          <label>Cân nặng</label>
          <select name="can_nang" required>
            <option value="">-- Chọn cân nặng --</option>
            <?php
            $sql_can_nang = "SELECT can_nang FROM dich_vu_khachsan ORDER BY id ASC";
            $result_can_nang = $conn->query($sql_can_nang);

            if ($result_can_nang && $result_can_nang->num_rows > 0) {
              while ($row_cn = $result_can_nang->fetch_assoc()) {
            ?>
                <option value="<?php echo htmlspecialchars($row_cn['can_nang']); ?>">
                  <?php echo htmlspecialchars($row_cn['can_nang']); ?>
                </option>
            <?php
              }
            } else {
            ?>
              <option value="< 3kg">&lt; 3kg</option>
              <option value="3 - 7kg">3 - 7kg</option>
              <option value="7 - 12kg">7 - 12kg</option>
              <option value="12 - 18kg">12 - 18kg</option>
              <option value="18 - 25kg">18 - 25kg</option>
              <option value="25 - 30kg">25 - 30kg</option>
            <?php } ?>
          </select>
        </div>

        <div class="vpFormGroup">
          <label>Dịch vụ chính</label>
          <select name="dich_vu_chinh" required>
            <option value="">-- Chọn dịch vụ --</option>
            <option value="Khách sạn thú cưng - Qua đêm">Qua đêm</option>
            <option value="Khách sạn thú cưng - Trong ngày">Trong ngày</option>
            <option value="Khách sạn thú cưng - Nửa ngày">Nửa ngày</option>
            <option value="Khách sạn thú cưng - 1 đến 3 tiếng">1 - 3 tiếng</option>
            <option value="Khách sạn thú cưng - Gói lưu trú dài ngày">Gói lưu trú dài ngày</option>
          </select>
        </div>

        <div class="vpFormGroup">
          <label>Ngày đặt</label>
          <input type="date" name="ngay_dat" required>
        </div>

        <div class="vpFormGroup">
          <label>Giờ đặt</label>
          <input type="time" name="gio_dat" required>
        </div>
      </div>

      <div class="vpCheckboxBox">
        <label class="vpCheckTitle">Dịch vụ thêm:</label>

        <label class="vpCheckItem">
          <input type="checkbox" name="dich_vu_them[]" value="Spa cơ bản">
          <span>Spa cơ bản</span>
        </label>

        <label class="vpCheckItem">
          <input type="checkbox" name="dich_vu_them[]" value="Spa Full">
          <span>Spa Full</span>
        </label>

        <label class="vpCheckItem">
          <input type="checkbox" name="dich_vu_them[]" value="Grooming">
          <span>Grooming</span>
        </label>

        <label class="vpCheckItem">
          <input type="checkbox" name="dich_vu_them[]" value="Hồ bơi - sân chơi"><span>Hồ bơi - sân chơi</span>
        </label>
      </div>

      <div class="vpFormGroup vpNoteFull">
        <label>Ghi chú</label>
        <textarea name="ghi_chu" placeholder="Ví dụ: Bé ăn thức ăn riêng, bé nhút nhát, cần phòng riêng..."></textarea>
      </div>

      <button type="submit" class="vpBookingBtn">Đặt lịch ngay</button>

      <a href="tra_cuu_lich_hen.php" class="vpBookingBtn vpStatusBtn">
        Xem trạng thái lịch hẹn
      </a>
    </form>
  </div>
</section>

<section class="vpIntroContent">
  <p>
    Khi đi công tác hay có chuyến du lịch nghỉ ngơi, ba mẹ cần tìm
    <strong>khách sạn thú cưng, khách sạn chó mèo, dịch vụ trông giữ chó mèo</strong>
    để gửi gắm, chăm sóc các bé Cún cưng, Mèo cưng.
  </p>
</section>

<blockquote class="vpQuote">
  <p><strong>Vậy, những điều gì thường làm ba mẹ lo lắng nhất?</strong></p>
</blockquote>

<section class="vpIntroContent">
  <ul class="vpWhyList">
    <li>Phòng ngủ của bé có rộng rãi, thoáng mát và sạch sẽ không?</li>
    <li>Chế độ ăn uống hàng ngày của bé như thế nào?</li>
    <li>Bé có vui, có thoải mái khi đến chỗ mới không?</li>
    <li>Có các bạn khác chơi cùng hay nhân viên chăm sóc chu đáo không?</li>
    <li>Ba mẹ có được xem camera hay được gửi hình ảnh, video của các bé thường xuyên không?</li>
  </ul>
</section>

<section class="vpHotelGrid2">
  <div class="vpHotelItem">
    <img src="https://vuipet.com/wp-content/uploads/2024/08/hotel-thu-cung-vuipet-uy-tin-chat-luong-quan-2-5.jpg" alt="">
  </div>
  <div class="vpHotelItem">
    <img src="https://vuipet.com/wp-content/uploads/2024/08/hotel-thu-cung-vuipet-uy-tin-chat-luong-quan-2-8.jpg" alt="">
  </div>
  <div class="vpHotelItem">
    <img src="https://vuipet.com/wp-content/uploads/2024/08/hotel-thu-cung-vuipet-uy-tin-chat-luong-quan-2-3.jpg" alt="">
  </div>
  <div class="vpHotelItem">
    <img src="https://vuipet.com/wp-content/uploads/2024/08/hotel-thu-cung-vuipet-uy-tin-chat-luong-quan-2-10.jpg" alt="">
  </div>
</section>

<style>
  .vpHotelPriceWrap,
  .vpBookingWrap {
    padding: 40px 20px;
    background: #fff8e8;
  }

  .vpHotelPriceBox,
  .vpBookingBox {
    max-width: 1150px;
    margin: 0 auto;
    background: #fffdf3;
    border-radius: 24px;
    padding: 30px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
  }

  .vpHotelLogo {
    text-align: center;
    margin-bottom: 10px;
  }

  .vpHotelLogo h1 {
    margin: 0;
    color: #f58220;
    font-size: 54px;
    font-weight: 900;
  }

  .vpHotelLogo p {
    color: #00a6a6;
    font-size: 28px;
    font-weight: 900;
    margin: 0;
  }

  .vpHotelPriceTitle,
  .vpBookingTitle {
    color: #00a6a6;
    font-size: 32px;
    font-weight: 900;
    text-align: left;
    margin-bottom: 5px;
    text-transform: uppercase;
  }

  .vpBookingTitle {
    text-align: center;
  }

  .vpHotelSubTitle {
    color: #00a6a6;
    font-size: 22px;
    font-weight: 800;
    margin-bottom: 25px;
  }.vpHotelPriceTableWrap {
    overflow-x: auto;
  }

  .vpHotelPriceTable {
    width: 100%;
    border-collapse: collapse;
    background: #fffdf3;
  }

  .vpHotelPriceTable th {
    color: #00a6a6;
    font-size: 20px;
    font-weight: 900;
    text-align: center;
    padding: 16px 10px;
    border-bottom: 4px solid #00a6a6;
  }

  .vpHotelPriceTable th small {
    display: block;
    font-size: 13px;
    margin-top: 5px;
  }

  .vpHotelPriceTable td {
    color: #f58220;
    font-size: 23px;
    font-weight: 900;
    text-align: center;
    padding: 16px 10px;
    border-bottom: 1px solid #efe4c8;
  }

  .vpHotelPriceTable td:first-child {
    color: #7a4b24;
  }

  .vpHotelPriceTable th:not(:last-child),
  .vpHotelPriceTable td:not(:last-child) {
    border-right: 4px solid #00a6a6;
  }

  .vpHotelNote {
    color: #f58220;
    font-size: 18px;
    font-weight: 800;
    margin: 10px 0;
  }

  .vpHotelBottom {
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    gap: 30px;
    margin-top: 35px;
    align-items: start;
  }

  .vpHotelText h3 {
    color: #00a6a6;
    font-size: 24px;
    font-weight: 900;
    margin: 25px 0 15px;
  }

  .vpHotelLine {
    display: grid;
    grid-template-columns: 160px 1fr;
    gap: 15px;
    margin: 10px 0;
    font-size: 19px;
    font-weight: 800;
  }

  .vpHotelLine span {
    color: #7a4b24;
    text-align: right;
    border-right: 4px solid #00a6a6;
    padding-right: 15px;
  }

  .vpHotelLine strong {
    color: #f58220;
  }

  .vpScheduleTitle {
    margin-top: 38px !important;
  }

  .vpFoodNote {
    color: #f58220;
    font-size: 16px;
    font-style: italic;
    margin-top: 28px;
    line-height: 1.6;
  }

  .vpHotelImages {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 18px;
  }

  .vpHotelImages img {
    width: 100%;
    aspect-ratio: 1 / 1;
    object-fit: cover;
    border: 4px solid #00a6a6;
    border-radius: 28px;
  }

  .vpBookingDesc {
    text-align: center;
    color: #8a572e;
    font-weight: 700;
    margin-bottom: 25px;
  }

  .vpFormGrid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
  }

  .vpFormGroup label,
  .vpCheckTitle {
    display: block;
    font-weight: 800;
    margin-bottom: 8px;
    color: #333;
  }

  .vpFormGroup input,
  .vpFormGroup select,
  .vpFormGroup textarea {
    width: 100%;
    border: 1px solid #ddd;
    border-radius: 12px;
    padding: 0 14px;
    font-size: 15px;
    outline: none;
    background: #fff;
  }

  .vpFormGroup input,
  .vpFormGroup select {
    height: 46px;
  }

  .vpFormGroup textarea {
    min-height: 100px;
    padding-top: 12px;
    resize: vertical;
  }

  .vpCheckboxBox {
    margin-top: 20px;
    background: white;
    border-radius: 16px;
    padding: 20px;
  }

  .vpCheckItem {
    display: block;
    font-weight: 700;
    margin: 14px 0;
    color: #111;
  }

  .vpCheckItem input {
    margin-right: 10px;
    transform: scale(1.2);
  }

  .vpNoteFull {margin-top: 18px;
  }

  .vpBookingBtn {
    margin: 25px auto 0;
    display: block;
    border: none;
    background: #f58220;
    color: white;
    padding: 13px 38px;
    border-radius: 999px;
    font-size: 17px;
    font-weight: 800;
    cursor: pointer;
    max-width: 280px;
    text-align: center;
    text-decoration: none;
  }

  .vpBookingBtn:hover {
    background: #df6f12;
    color: white;
    text-decoration: none;
  }

  .vpStatusBtn {
    background: #00a6a6;
  }

  .vpStatusBtn:hover {
    background: #008f8f;
  }

  @media (max-width: 900px) {
    .vpHotelBottom,
    .vpFormGrid {
      grid-template-columns: repeat(2, 1fr);
    }

    .vpHotelPriceTable th,
    .vpHotelPriceTable td {
      font-size: 15px;
      padding: 12px 8px;
    }
  }

  @media (max-width: 576px) {
    .vpHotelBottom,
    .vpHotelImages,
    .vpFormGrid {
      grid-template-columns: 1fr;
    }

    .vpHotelLogo h1 {
      font-size: 38px;
    }

    .vpHotelLogo p {
      font-size: 22px;
    }

    .vpHotelPriceTitle,
    .vpBookingTitle {
      font-size: 24px;
      text-align: center;
    }

    .vpHotelLine {
      grid-template-columns: 1fr;
    }

    .vpHotelLine span {
      text-align: left;
      border-right: none;
      border-bottom: 3px solid #00a6a6;
      padding-bottom: 5px;
    }
  }
</style>

<?php include dirname(__DIR__) . "/footer_contact.php"; ?>

</main>
</body>
</html>