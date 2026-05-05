<?php
include dirname(__DIR__) . "/header.php";
include dirname(dirname(__DIR__)) . "/config/ket_noi_csdl.php";

$sql_spa = "SELECT * FROM dich_vu_spa ORDER BY id ASC";
$result_spa = $conn->query($sql_spa);
?>

<section class="vpPageWrap">
  <div class="vpIntroHead">
    <h2><span>DỊCH VỤ SPA THÚ CƯNG – CẮT TỈA LÔNG CHÓ MÈO CHUẨN 5* TP.HCM</span></h2>
  </div>

  <div class="vpIntroContent">
    <p>
      <strong>
        Không gian rộng thoáng, hiện đại, nhân viên tay nghề cao, VuiPet cung cấp dịch vụ
        Spa thú cưng, Spa chó mèo, tỉa lông chó mèo cao cấp, chuẩn 5*.
      </strong>
    </p>

    <h3 class="vpSubTitleCenter">SPA THÚ CƯNG 5* CỦA VUIPET CÓ GÌ?</h3>

    <ul class="vpWhyList">
      <li>Không gian siêu rộng, kính trong suốt, ba mẹ có thể theo dõi toàn bộ quá trình spa – cắt tỉa lông cho các bé.</li>
      <li>Nhân viên VuiPet giàu kinh nghiệm, nhẹ nhàng, cưng chiều các bé hết nấc.</li>
      <li>Sử dụng 2 loại sữa tắm cao cấp Prunus – Hàn Quốc và sữa tắm Artero – Tây Ban Nha.</li>
      <li>Groomer tư vấn, cắt tỉa tạo kiểu theo yêu cầu, phù hợp với từng bé.</li>
    </ul>
  </div>
</section>

<section class="vpSpaGallery">
  <div class="vpSpaGrid vpSpaGrid--4">
    <div class="vpSpaItem">
      <img src="https://vuipet.com/wp-content/uploads/2023/05/spa-cho-cho-vuipet-2-800x800.jpg" alt="Spa chó tại VuiPet">
    </div>
    <div class="vpSpaItem">
      <img src="https://vuipet.com/wp-content/uploads/2023/05/spa-thu-cung-vuipet-1-800x800.jpg" alt="Spa thú cưng tại VuiPet">
    </div>
    <div class="vpSpaItem">
      <img src="https://vuipet.com/wp-content/uploads/2023/05/4-800x800.jpg" alt="Spa chó mèo">
    </div>
    <div class="vpSpaItem">
      <img src="https://vuipet.com/wp-content/uploads/2023/05/spa-cho-cho-vuipet-1-800x800.jpg" alt="Dịch vụ spa chó mèo">
    </div>
  </div>

  <blockquote class="vpQuote">
    <p>Trải nghiệm dịch vụ Spa chó mèo chuẩn 5* tại VuiPet</p>
  </blockquote>
</section>

<section class="vpSpaBanner">
  <img src="https://vuipet.com/wp-content/uploads/2023/11/spa-thu-cung-tphcm-vuipet.jpg" alt="Spa thú cưng TPHCM VuiPet">
</section>

<section class="vpSpaPriceWrap">
  <div class="vpSpaPriceBox">
    <h2 class="vpSpaPriceTitle">Bảng giá áp dụng chính thức từ 1/2/2026</h2>

    <div class="vpSpaPriceTableWrap">
      <table class="vpSpaPriceTable">
        <thead>
          <tr>
            <th>Cân nặng</th>
            <th>Vệ sinh</th>
            <th>Spa cơ bản</th>
            <th>Spa Full</th>
            <th>Grooming</th>
          </tr>
        </thead>

        <tbody>
          <?php if ($result_spa && $result_spa->num_rows > 0) { ?>
            <?php while ($row = $result_spa->fetch_assoc()) { ?>
              <tr>
                <td><?php echo htmlspecialchars($row['can_nang']); ?></td>
                <td><?php echo number_format($row['ve_sinh'] / 1000); ?></td>
                <td><?php echo number_format($row['spa_co_ban'] / 1000); ?></td>
                <td><?php echo number_format($row['spa_full'] / 1000); ?></td>
                <td><?php echo number_format($row['grooming'] / 1000); ?></td>
              </tr>
            <?php } ?>
          <?php } else { ?>
            <tr>
              <td colspan="5">Chưa có dữ liệu bảng giá.</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <p class="vpSpaPriceNote">Đơn vị: nghìn đồng. Ví dụ 150 = 150.000 VNĐ</p>
  </div>
</section>

<section class="vpServiceInfoWrap">
  <div class="vpServiceInfoBox">
    <div class="vpServiceInfoLeft">
      <div class="vpServiceItem">
        <h3>VỆ SINH:</h3>
        <p>Cạo lông đệm chân, cạo lông bụng, vùng đi vệ sinh, vệ sinh tai, cắt móng.</p>
      </div>

      <div class="vpServiceItem">
        <h3>SPA CƠ BẢN:</h3>
        <p>Tắm + Vắt tuyến hôi + Sấy khô.</p>
      </div>

      <div class="vpServiceItem">
        <h3>SPA FULL:</h3>
        <p>Vệ sinh + Spa cơ bản + Đánh răng.</p>
      </div>

      <div class="vpServiceItem">
        <h3>GROOMING:</h3>
        <p>Spa Full + Cắt tỉa lông theo yêu cầu.</p>
      </div>

      <div class="vpServiceLine"></div>

      <h2 class="vpExtraTitle">DỊCH VỤ LẺ:</h2>

      <div class="vpExtraRow">
        <span>Gỡ rối lông</span>
        <strong>150 - 500</strong>
      </div>

      <div class="vpExtraRow">
        <span>Cắt tỉa cơ bản (Bo mông/Tạo tỉa mặt)</span>
        <strong>150 - 500</strong>
      </div>

      <div class="vpExtraRow">
        <span>Cạo lông</span>
        <strong>150 - 500</strong>
      </div>

      <h2 class="vpSaleText">Ưu đãi: <span>Mua 4 tặng 1</span></h2>
    </div>

    <div class="vpServiceInfoRight">
      <img src="https://vuipet.com/wp-content/uploads/2023/05/spa-thu-cung-vuipet-1-800x800.jpg" alt="Spa thú cưng">
      <img src="https://vuipet.com/wp-content/uploads/2023/05/spa-cho-cho-vuipet-1-800x800.jpg" alt="Cắt tỉa lông">
      <img src="https://vuipet.com/wp-content/uploads/2023/05/spa-cho-meo-vuipet-5-1200x800.jpg" alt="Grooming">
      <img src="https://vuipet.com/wp-content/uploads/2024/07/spa-thu-cung-quan-2-vuipet-4-800x800.jpg" alt="Dịch vụ spa">
    </div>
  </div>
</section>

<section class="vpBookingWrap">
  <div class="vpBookingBox">
    <h2 class="vpBookingTitle">Đặt lịch dịch vụ Spa</h2>
    <p class="vpBookingDesc">Vui lòng nhập thông tin, yêu cầu đặt lịch sẽ gửi đến Admin để xác nhận.</p>

   <form method="POST" action="../../Admin/xu_ly_dat_dich_vu.php" class="vpBookingForm">
  <input type="hidden" name="loai_dich_vu" value="Spa thú cưng">
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
            <?php
            $result_can_nang = $conn->query("SELECT * FROM dich_vu_spa ORDER BY id ASC");
            if ($result_can_nang && $result_can_nang->num_rows > 0) {
              while ($row_cn = $result_can_nang->fetch_assoc()) {
            ?>
                <option value="<?php echo htmlspecialchars($row_cn['can_nang']); ?>">
                  <?php echo htmlspecialchars($row_cn['can_nang']); ?>
                </option>
            <?php
              }
            }
            ?>
          </select>
        </div>

        <div class="vpFormGroup">
          <label>Dịch vụ chính</label>
          <select name="dich_vu_chinh" required>
            <option value="">-- Chọn dịch vụ chính --</option>
            <option value="Vệ sinh">Vệ sinh</option>
            <option value="Spa cơ bản">Spa cơ bản</option>
            <option value="Spa Full">Spa Full</option>
            <option value="Grooming">Grooming</option>
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
          <input type="checkbox" name="dich_vu_them[]" value="Spa 9 bước thơm tho">
          <span>Spa 9 bước thơm tho</span>
        </label>

        <label class="vpCheckItem">
          <input type="checkbox" name="dich_vu_them[]" value="Grooming tạo kiểu">
          <span>Grooming tạo kiểu</span>
        </label>

        <label class="vpCheckItem">
          <input type="checkbox" name="dich_vu_them[]" value="Hồ bơi thú cưng - sân chơi">
          <span>Hồ bơi thú cưng - sân chơi</span>
        </label>

        <label class="vpCheckItem">
          <input type="checkbox" name="dich_vu_them[]" value="Trông giữ qua đêm (Hotel)">
          <span>Trông giữ qua đêm (Hotel)</span>
        </label>

        <label class="vpCheckItem">
          <input type="checkbox" name="dich_vu_them[]" value="Trông giữ trong ngày (Daycare)">
          <span>Trông giữ trong ngày (Daycare)</span>
        </label>
      </div>

      <div class="vpFormGroup vpNoteFull">
        <label>Ghi chú</label>
        <textarea name="ghi_chu" placeholder="Ghi chú cho VuiPet..."></textarea>
      </div>

      <button type="submit" class="vpBookingBtn">
        Đặt dịch vụ ngay
      </button>

      <a href="tra_cuu_lich_hen.php" class="vpBookingBtn vpStatusBtn">
        Xem trạng thái lịch hẹn
      </a>
    </form>
  </div>
</section>

<section class="vpSpaGallery">
  <div class="vpSpaGrid vpSpaGrid--4 vpSpaGrid--rect">
    <div class="vpSpaItem">
      <img src="https://vuipet.com/wp-content/uploads/2024/07/spa-thu-cung-quan-2-vuipet-3-800x800.jpg" alt="Spa thú cưng quận 2">
    </div>
    <div class="vpSpaItem">
      <img src="https://vuipet.com/wp-content/uploads/2024/07/spa-thu-cung-quan-2-vuipet-2-800x800.jpg" alt="Spa thú cưng đẹp">
    </div>
    <div class="vpSpaItem">
      <img src="https://vuipet.com/wp-content/uploads/2024/07/spa-thu-cung-quan-2-vuipet-4-800x800.jpg" alt="Spa chó mèo quận 2">
    </div>
    <div class="vpSpaItem">
      <img src="https://vuipet.com/wp-content/uploads/2023/06/spa-thu-cung-vuipet-1.jpg" alt="Spa thú cưng VuiPet">
    </div>
  </div>

  <blockquote class="vpQuote">
    <p>Spa chó mèo chuẩn 5* ở VuiPet</p>
  </blockquote>
</section>

<style>
  .vpSpaPriceWrap,
  .vpServiceInfoWrap,
  .vpBookingWrap {
    padding: 40px 20px;
    background: #fff8e8;
  }

  .vpSpaPriceBox,
  .vpServiceInfoBox,
  .vpBookingBox {
    max-width: 1150px;
    margin: 0 auto;
    background: #fffdf3;
    border-radius: 24px;
    padding: 30px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
  }

  .vpSpaPriceTitle,
  .vpBookingTitle {
    color: #f58220;
    font-size: 28px;
    font-weight: 800;
    margin-bottom: 22px;
    text-align: center;
  }

  .vpSpaPriceTableWrap {
    width: 100%;
    overflow-x: auto;
  }

  .vpSpaPriceTable {
    width: 100%;
    border-collapse: collapse;
  }

  .vpSpaPriceTable th {
    color: #00a6a6;
    font-size: 22px;
    font-weight: 800;
    text-transform: uppercase;
    text-align: center;
    padding: 18px 12px;
    border-bottom: 4px solid #00a6a6;
  }

  .vpSpaPriceTable td {
    color: #f58220;
    font-size: 22px;
    font-weight: 800;
    text-align: center;
    padding: 18px 12px;
    border-bottom: 1px solid #efe4c8;
  }

  .vpSpaPriceTable td:first-child {
    color: #7a4b24;
  }

  .vpSpaPriceTable th:not(:last-child),
  .vpSpaPriceTable td:not(:last-child) {
    border-right: 4px solid #00a6a6;
  }

  .vpSpaPriceNote {
    margin-top: 16px;
    text-align: center;
    color: #777;
    font-size: 14px;
  }

  .vpServiceInfoBox {
    display: grid;
    grid-template-columns: 1.3fr 1fr;
    gap: 30px;
    align-items: center;
  }

  .vpServiceItem h3,
  .vpExtraTitle {
    color: #00a6a6;
    font-size: 26px;
    font-weight: 900;
    margin-bottom: 4px;
  }

  .vpServiceItem p {
    color: #8a572e;
    font-size: 22px;
    font-weight: 800;
    margin-bottom: 22px;
  }

  .vpServiceLine {
    width: 300px;
    height: 5px;
    background: #00a6a6;
    margin: 25px 0;
    border-radius: 999px;
  }

  .vpExtraRow {
    display: grid;
    grid-template-columns: 1fr 180px;
    gap: 20px;
    margin: 14px 0;
    font-size: 22px;
    font-weight: 800;
    color: #8a572e;
  }

  .vpExtraRow strong {
    color: #f58220;
    border-left: 4px solid #00a6a6;
    padding-left: 25px;
  }

  .vpSaleText {
    color: #00a6a6;
    font-size: 32px;
    font-weight: 900;
    margin-top: 28px;
  }

  .vpSaleText span {
    color: #f58220;
  }

  .vpServiceInfoRight {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 22px;
  }

  .vpServiceInfoRight img {
    width: 100%;
    aspect-ratio: 1 / 1;
    object-fit: cover;
    border-radius: 50%;
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
  }

  .vpBookingBtn:hover {
    background: #df6f12;
    color: white;
    text-decoration: none;
  }

  .vpStatusBtn {
    background: #00a6a6;
    text-decoration: none;
  }

  .vpStatusBtn:hover {
    background: #008f8f;
  }

  @media (max-width: 900px) {
    .vpServiceInfoBox {
      grid-template-columns: 1fr;
    }

    .vpFormGrid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 576px) {
    .vpFormGrid {
      grid-template-columns: 1fr;
    }

    .vpSpaPriceTable th,
    .vpSpaPriceTable td {
      font-size: 15px;
      padding: 10px;
    }

    .vpServiceItem h3,
    .vpExtraTitle {
      font-size: 22px;
    }

    .vpServiceItem p,
    .vpExtraRow {
      font-size: 17px;
    }

    .vpExtraRow {
      grid-template-columns: 1fr;
    }
  }
</style>

<?php include dirname(__DIR__) . "/footer_contact.php"; ?>

</main>
</body>
</html>