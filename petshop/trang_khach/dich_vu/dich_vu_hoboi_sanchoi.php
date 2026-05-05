<?php
include dirname(__DIR__) . "/header.php";
include dirname(dirname(__DIR__)) . "/config/ket_noi_csdl.php";

/* LẤY BẢNG GIÁ */
$sql = "SELECT * FROM dich_vu_ho_boi ORDER BY id ASC";
$result = $conn->query($sql);
?>
<section class="vpPageWrap">
  <div class="vpIntroHead">
    <h2>
      <span>TRẢI NGHIỆM DỊCH VỤ TỔ HỢP SÂN CHƠI,</span><br>
      <span>HỒ BƠI CHO CHÓ NĂNG ĐỘNG TẠI TP.HCM</span>
    </h2>
  </div>

  <div class="vpSpaBanner">
    <img src="https://vuipet.com/wp-content/uploads/2024/06/ho-boi-cho-cho-quan-2-vuipet-20.jpg">
  </div>

  <div class="vpIntroContent center">
    <p><strong>Các Boss cưng nhà bạn có thiếu một nơi để chạy nhảy, vận động?</strong></p>

    <ul class="vpWhyList">
      <li>Tổ hợp sân chơi cỏ – chướng ngại vật – hồ bơi sạch, lọc nước khử khuẩn liên tục.</li>
      <li>Không gian vận động thân thiện, an toàn cho các bé chạy nhảy thoải mái.</li>
      <li>Phù hợp từ các bé nhỏ như Poodle, Pom đến các bé năng động như Husky, Golden.</li>
    </ul>
  </div>
</section>

<section class="vpSpaBanner">
  <img src="https://vuipet.com/wp-content/uploads/2023/04/vuipet-khu-vui-choi-cho-cho-2-1200x800.png">
</section>

<blockquote class="vpQuote">
  <p>VuiPet tin rằng vận động giúp nâng cao sức khỏe thể chất và tinh thần cho các bé.</p>
</blockquote>

<section class="vpPoolPriceWrap">
  <div class="vpPoolPriceBox">
    <h2 class="vpPoolPriceTitle">Bảng giá áp dụng chính thức từ 1/2/2026</h2>

    <div class="vpPoolPriceTableWrap">
      <table class="vpPoolPriceTable">
        <thead>
          <tr>
            <th>Hồ bơi</th>
            <th>1 lần</th>
            <th>Gói 5 lần</th>
            <th>Gói 10 lần</th>
            <th>Ưu đãi</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td>&lt; 5kg</td>
            <td>280</td>
            <td>1.110</td>
            <td>2.000</td>
            <td rowspan="6" class="vpDiscountCell">
              Giảm <strong>50</strong><br>
              <span>Khi dùng kèm Spa Full hoặc Grooming</span>
            </td>
          </tr>
          <tr>
            <td>5 - 10kg</td>
            <td>330</td>
            <td>1.300</td>
            <td>2.400</td>
          </tr>
          <tr>
            <td>10 - 15kg</td>
            <td>380</td>
            <td>1.500</td>
            <td>2.800</td>
          </tr>
          <tr>
            <td>15 - 20kg</td>
            <td>430</td>
            <td>1.700</td>
            <td>3.200</td>
          </tr>
          <tr>
            <td>20 - 25kg</td>
            <td>540</td>
            <td>2.100</td>
            <td>4.000</td>
          </tr>
          <tr>
            <td>25 - 30kg</td>
            <td>600</td>
            <td>2.240</td>
            <td>4.600</td>
          </tr>
        </tbody>
      </table>
    </div>

    <p class="vpPoolPriceNote">Đơn vị: nghìn đồng. Ví dụ 280 = 280.000 VNĐ.</p>
  </div>
</section>

<section class="vpBookingWrap" id="dat-lich-ho-boi">
  <div class="vpBookingBox">
    <h2 class="vpBookingTitle">Đặt lịch hồ bơi - sân chơi thú cưng</h2>
    <p class="vpBookingDesc">Vui lòng nhập thông tin, yêu cầu đặt lịch sẽ gửi đến Admin để xác nhận.</p>

    <form method="POST" action="../../Admin/xu_ly_dat_dich_vu.php" class="vpBookingForm">
      <input type="hidden" name="loai_dich_vu" value="Hồ bơi - Sân chơi">

      <div class="vpFormGrid">
        <div class="vpFormGroup">
          <label>Họ tên khách hàng</label>
          <input type="text" name="ho_ten" required placeholder="Nhập họ tên của bạn">
        </div>

        <div class="vpFormGroup">
          <label>Số điện thoại</label>
          <input type="text" name="so_dien_thoai" required placeholder="Nhập số điện thoại">
        </div>

        <div class="vpFormGroup">
          <label>Tên thú cưng</label>
          <input type="text" name="ten_thu_cung" required placeholder="Ví dụ: Miu, Lu, Bông">
        </div>

        <div class="vpFormGroup">
          <label>Cân nặng</label>
          <select name="can_nang" required>
            <option value="">-- Chọn cân nặng --</option>
            <option value="< 5kg">&lt; 5kg</option>
            <option value="5 - 10kg">5 - 10kg</option>
            <option value="10 - 15kg">10 - 15kg</option>
            <option value="15 - 20kg">15 - 20kg</option>
            <option value="20 - 25kg">20 - 25kg</option>
            <option value="25 - 30kg">25 - 30kg</option>
          </select>
        </div>

        <div class="vpFormGroup">
          <label>Dịch vụ chính</label>
          <select name="dich_vu_chinh" required>
            <option value="">-- Chọn dịch vụ --</option>
            <option value="Hồ bơi thú cưng - 1 lần">Hồ bơi thú cưng - 1 lần</option>
            <option value="Hồ bơi thú cưng - Gói 5 lần">Hồ bơi thú cưng - Gói 5 lần</option>
            <option value="Hồ bơi thú cưng - Gói 10 lần">Hồ bơi thú cưng - Gói 10 lần</option>
            <option value="Sân chơi thú cưng">Sân chơi thú cưng</option>
            <option value="Combo hồ bơi + sân chơi">Combo hồ bơi + sân chơi</option>
          </select>
        </div>

        <div class="vpFormGroup">
          <label>Ngày đặt lịch</label>
          <input type="date" name="ngay_dat" required>
        </div>

        <div class="vpFormGroup">
          <label>Giờ đặt lịch</label>
          <input type="time" name="gio_dat" required>
        </div>
      </div>

      <div class="vpCheckboxBox">
        <label class="vpCheckTitle">Dịch vụ thêm:</label>

        <label class="vpCheckItem">
          <input type="checkbox" name="dich_vu_them[]" value="Tắm sấy sau khi bơi">
          <span>Tắm sấy sau khi bơi</span>
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
          <input type="checkbox" name="dich_vu_them[]" value="Trông giữ trong ngày">
          <span>Trông giữ trong ngày</span>
        </label>
      </div>

      <div class="vpFormGroup vpNoteFull">
        <label>Ghi chú</label>
        <textarea name="ghi_chu" placeholder="Ví dụ: Bé chưa biết bơi, cần nhân viên hỗ trợ..."></textarea>
      </div>

      <button type="submit" class="vpBookingBtn">Đặt lịch ngay</button>

      <a href="tra_cuu_lich_hen.php" class="vpBookingBtn vpStatusBtn">
        Xem trạng thái lịch hẹn
      </a>
    </form>
  </div>
</section>

<section class="vpSectionTitle">
  <h2>Sân chơi cỏ tự nhiên</h2>
</section>

<section class="vpSpaGallery">
  <div class="vpSpaGrid vpSpaGrid--4">
    <img src="https://vuipet.com/wp-content/uploads/2024/06/ho-boi-cho-cho-quan-2-vuipet-2-600x400.jpg">
    <img src="https://vuipet.com/wp-content/uploads/2024/06/ho-boi-cho-cho-quan-2-vuipet-4-600x400.jpg">
    <img src="https://vuipet.com/wp-content/uploads/2024/06/ho-boi-cho-cho-quan-2-vuipet-6-600x400.jpg">
    <img src="https://vuipet.com/wp-content/uploads/2024/06/ho-boi-cho-cho-quan-2-vuipet-15-600x400.jpg">
  </div>
</section>

<blockquote class="vpQuote">
  <p>Rộng rãi, an toàn cho Cún chạy nhảy tẹt ga</p>
</blockquote>

<section class="vpSpaGallery">
  <div class="vpSpaGrid vpSpaGrid--4">
    <img src="https://vuipet.com/wp-content/uploads/2024/06/ho-boi-cho-cho-quan-2-vuipet-5-600x400.jpg">
    <img src="https://vuipet.com/wp-content/uploads/2024/06/ho-boi-cho-cho-quan-2-vuipet-7-600x400.jpg">
    <img src="https://vuipet.com/wp-content/uploads/2023/04/san-choi-cho-cho-600x400.png">
    <img src="https://vuipet.com/wp-content/uploads/2024/06/ho-boi-cho-cho-quan-2-vuipet-17-600x400.jpg">
  </div>
</section>

<blockquote class="vpQuote">
  <p>Thử thách với các chướng ngại vật phù hợp</p>
</blockquote>

<section class="vpSpaGallery">
  <div class="vpSpaGrid vpSpaGrid--4">
    <img src="https://vuipet.com/wp-content/uploads/2023/04/khu-vui-choi-cho-cho-vuipet-12-600x400.png">
    <img src="https://vuipet.com/wp-content/uploads/2024/06/ho-boi-cho-cho-quan-2-vuipet-1-600x400.jpg">
    <img src="https://vuipet.com/wp-content/uploads/2023/04/vuipet-khu-vui-choi-cho-cho-5-600x400.png">
    <img src="https://vuipet.com/wp-content/uploads/2024/06/ho-boi-cho-cho-quan-2-vuipet-18-600x400.jpg">
  </div>
</section>

<section class="vpSectionTitle">
  <h2>Hồ bơi thú cưng</h2>
</section>

<blockquote class="vpQuote">
  <p>Bơi giúp giải nhiệt, giảm stress và tăng cường sức khỏe xương – cơ cho các bé.</p>
</blockquote>

<section class="vpSpaBanner">
  <img src="https://vuipet.com/wp-content/uploads/2024/06/ho-boi-cho-cho-quan-2-vuipet-16-1201x800.jpg">
</section>

<blockquote class="vpQuote">
  <p>Một chiếc Gi rất hưởng thụ dưới nước mát</p>
</blockquote>

<section class="vpSpaBanner">
  <img src="https://vuipet.com/wp-content/uploads/2023/04/ho-boi-cho-cho-vuipet-9-1201x800.png">
</section>

<style>
  .vpPoolPriceWrap,
  .vpBookingWrap {
    padding: 40px 20px;
    background: #fff8e8;
  }

  .vpPoolPriceBox,
  .vpBookingBox {
    max-width: 1150px;
    margin: 0 auto;
    background: #fffdf3;
    border-radius: 24px;
    padding: 30px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
  }

  .vpPoolPriceTitle,
  .vpBookingTitle {
    color: #f58220;
    font-size: 28px;
    font-weight: 900;
    text-align: center;
    margin-bottom: 25px;
  }

  .vpPoolPriceTableWrap {
    width: 100%;
    overflow-x: auto;
  }

  .vpPoolPriceTable {
    width: 100%;
    border-collapse: collapse;
    background: #fffdf3;
  }

  .vpPoolPriceTable th {
    color: #00a6a6;
    font-size: 22px;
    font-weight: 900;
    text-transform: uppercase;
    text-align: center;
    padding: 18px 12px;
    border-bottom: 4px solid #00a6a6;
  }

  .vpPoolPriceTable td {
    color: #f58220;
    font-size: 23px;
    font-weight: 900;
    text-align: center;
    padding: 18px 12px;
    border-bottom: 1px solid #efe4c8;
  }

  .vpPoolPriceTable td:first-child {
    color: #7a4b24;
  }

  .vpPoolPriceTable th:not(:last-child),
  .vpPoolPriceTable td:not(:last-child) {
    border-right: 4px solid #00a6a6;
  }

  .vpDiscountCell {
    color: #f58220 !important;
    font-size: 28px !important;
    vertical-align: middle;
  }

  .vpDiscountCell strong {
    display: block;
    font-size: 56px;
    line-height: 1.1;
  }

  .vpDiscountCell span {
    display: block;
    color: #00a6a6;
    font-size: 15px;
    font-weight: 800;
    margin-top: 6px;
  }

  .vpPoolPriceNote {
    margin-top: 16px;
    text-align: center;
    color: #777;
    font-size: 14px;
  }

  .vpBookingDesc {
    text-align: center;
    color: #666;
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
    background: #ffffff;
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

  .vpNoteFull {
    margin-top: 18px;
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
    .vpFormGrid {
      grid-template-columns: repeat(2, 1fr);
    }

    .vpPoolPriceTable th,
    .vpPoolPriceTable td {
      font-size: 16px;
      padding: 12px;
    }

    .vpDiscountCell strong {
      font-size: 34px;
    }
  }

  @media (max-width: 576px) {
    .vpFormGrid {
      grid-template-columns: 1fr;
    }

    .vpPoolPriceTitle,
    .vpBookingTitle {
      font-size: 22px;
    }
  }
</style>

<?php include dirname(__DIR__) . "/footer_contact.php"; ?>

</main>
</body>
</html>