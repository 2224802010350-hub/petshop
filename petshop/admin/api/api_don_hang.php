<?php
require_once __DIR__ . "/../../config/ket_noi_csdl.php";
require_once __DIR__ . "/../../config/ham_chung.php";

if (session_status() === PHP_SESSION_NONE) session_start();
header("Content-Type: application/json; charset=utf-8");

function out($ok, $data = []) {
  echo json_encode(array_merge(["ok" => $ok], $data), JSON_UNESCAPED_UNICODE);
  exit;
}

if (empty($_SESSION["user"])) {
  out(false, ["msg" => "Chưa đăng nhập"]);
}

$action = $_GET["action"] ?? ($_POST["action"] ?? "list");

try {

  if ($action === "search_customers") {
    $q = trim($_GET["q"] ?? "");
    $like = "%" . $q . "%";

    $stmt = $conn->prepare("
      SELECT id, ho_ten, so_dien_thoai, email, dia_chi
      FROM khach_hang
      WHERE ho_ten LIKE ? OR so_dien_thoai LIKE ? OR email LIKE ?
      ORDER BY id DESC
      LIMIT 10
    ");

    if (!$stmt) out(false, ["msg" => "SQL lỗi tìm khách: " . $conn->error]);

    $stmt->bind_param("sss", $like, $like, $like);
    $stmt->execute();

    $rs = $stmt->get_result();
    $items = [];

    while ($row = $rs->fetch_assoc()) {
      $items[] = $row;
    }

    out(true, ["items" => $items]);
  }

  if ($action === "create_customer") {
    $ho_ten = trim($_POST["ho_ten"] ?? "");
    $so_dien_thoai = trim($_POST["so_dien_thoai"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $dia_chi = trim($_POST["dia_chi"] ?? "");

    if ($ho_ten === "" || $so_dien_thoai === "") {
      out(false, ["msg" => "Vui lòng nhập họ tên và số điện thoại"]);
    }

    $stmt = $conn->prepare("
      SELECT id, ho_ten, so_dien_thoai, email, dia_chi
      FROM khach_hang
      WHERE so_dien_thoai = ?
      LIMIT 1
    ");
    $stmt->bind_param("s", $so_dien_thoai);
    $stmt->execute();
    $old = $stmt->get_result()->fetch_assoc();

    if ($old) {
      out(true, [
        "msg" => "Khách hàng đã tồn tại",
        "customer" => $old
      ]);
    }

    $stmt = $conn->prepare("
      INSERT INTO khach_hang(ho_ten, so_dien_thoai, email, dia_chi)
      VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param("ssss", $ho_ten, $so_dien_thoai, $email, $dia_chi);

    if (!$stmt->execute()) {
      out(false, ["msg" => "Không thêm được khách hàng: " . $stmt->error]);
    }

    $id = $conn->insert_id;

    out(true, [
      "msg" => "Thêm khách hàng thành công",
      "customer" => [
        "id" => $id,
        "ho_ten" => $ho_ten,
        "so_dien_thoai" => $so_dien_thoai,
        "email" => $email,
        "dia_chi" => $dia_chi
      ]
    ]);
  }

  if ($action === "list") {
    $q = trim($_GET["q"] ?? "");

    $sql = "
      SELECT 
        dh.id,
        dh.ma_don,
        dh.ngay_tao,
        dh.trang_thai_giao_hang,
        dh.phuong_thuc_tt,
        dh.trang_thai,
        dh.tong_tien,
        dh.da_cong_diem_than_thiet,
        kh.ho_ten AS ten_khach,
        kh.so_dien_thoai AS sdt,
        COALESCE(dh.email_khach, kh.email) AS email
      FROM don_hang dh
      LEFT JOIN khach_hang kh ON kh.id = dh.id_khach_hang
    ";

    if ($q !== "") {
      $sql .= "
        WHERE dh.ma_don LIKE ? 
           OR kh.ho_ten LIKE ? 
           OR kh.so_dien_thoai LIKE ?
      ";
    }

    $sql .= " ORDER BY dh.id DESC LIMIT 200";

    if ($q !== "") {
      $like = "%" . $q . "%";
      $stmt = $conn->prepare($sql);

      if (!$stmt) out(false, ["msg" => "SQL lỗi: " . $conn->error]);

      $stmt->bind_param("sss", $like, $like, $like);
      $stmt->execute();
      $rs = $stmt->get_result();
    } else {
      $rs = $conn->query($sql);
    }

    if (!$rs) out(false, ["msg" => "SQL lỗi: " . $conn->error]);

    $items = [];

    while ($row = $rs->fetch_assoc()) {
      $items[] = $row;
    }

    out(true, ["items" => $items]);
  }

  if ($action === "create") {
    $id_khach = intval($_POST["id_khach_hang"] ?? 0);
    $email_khach = trim($_POST["email_khach"] ?? "");
    $phuong_thuc_tt = trim($_POST["phuong_thuc_tt"] ?? "COD");

    $items_json = $_POST["items"] ?? "[]";
    $items = json_decode($items_json, true);

    if (!is_array($items) || count($items) === 0) {
      out(false, ["msg" => "Giỏ hàng trống"]);
    }

    $id_nv = intval($_SESSION["user"]["id"] ?? 0);
    $tam_tinh = 0;

    $conn->begin_transaction();

    foreach ($items as $it) {
      $pid = intval($it["id"] ?? 0);
      $qty = intval($it["so_luong"] ?? 0);

      if ($pid <= 0 || $qty <= 0) {
        $conn->rollback();
        out(false, ["msg" => "Dữ liệu giỏ hàng không hợp lệ"]);
      }

      $stmt = $conn->prepare("
        SELECT gia_ban, ton_kho 
        FROM san_pham 
        WHERE id = ? 
        LIMIT 1
      ");
      $stmt->bind_param("i", $pid);
      $stmt->execute();
      $sp = $stmt->get_result()->fetch_assoc();

      if (!$sp) {
        $conn->rollback();
        out(false, ["msg" => "Sản phẩm không tồn tại ID: $pid"]);
      }

      if (intval($sp["ton_kho"]) < $qty) {
        $conn->rollback();
        out(false, ["msg" => "Không đủ tồn kho SP ID: $pid"]);
      }

      $gia = floatval($sp["gia_ban"]);
      $tam_tinh += $gia * $qty;

      $stmt = $conn->prepare("
        UPDATE san_pham 
        SET ton_kho = ton_kho - ? 
        WHERE id = ?
      ");
      $stmt->bind_param("ii", $qty, $pid);

      if (!$stmt->execute()) {
        $conn->rollback();
        out(false, ["msg" => "Không trừ được tồn kho"]);
      }
    }

    $trang_thai_giao_hang = "DA_XAC_NHAN";
    $giam_gia = 0;
    $tong_tien = $tam_tinh - $giam_gia;
    $trang_thai = "CHUA_THANH_TOAN";
    $ma_don = "DH" . date("YmdHis") . rand(10, 99);

    $stmt = $conn->prepare("
      INSERT INTO don_hang(
        ma_don,
        id_khach_hang,
        id_nhan_vien,
        ngay_tao,
        tam_tinh,
        giam_gia,
        tong_tien,
        trang_thai_giao_hang,
        phuong_thuc_tt,
        trang_thai,
        email_khach
      )
      VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
      $conn->rollback();
      out(false, ["msg" => "Prepare lỗi tạo đơn: " . $conn->error]);
    }

    $stmt->bind_param(
      "siidddssss",
      $ma_don,
      $id_khach,
      $id_nv,
      $tam_tinh,
      $giam_gia,
      $tong_tien,
      $trang_thai_giao_hang,
      $phuong_thuc_tt,
      $trang_thai,
      $email_khach
    );

    if (!$stmt->execute()) {
      $conn->rollback();
      out(false, ["msg" => "Không tạo được đơn: " . $stmt->error]);
    }

    $id_don = $conn->insert_id;

    foreach ($items as $it) {
      $pid = intval($it["id"]);
      $qty = intval($it["so_luong"]);

      $stmt = $conn->prepare("
        SELECT gia_ban 
        FROM san_pham 
        WHERE id = ? 
        LIMIT 1
      ");
      $stmt->bind_param("i", $pid);
      $stmt->execute();
      $sp = $stmt->get_result()->fetch_assoc();

      $don_gia = floatval($sp["gia_ban"]);

      $stmt = $conn->prepare("
        INSERT INTO chi_tiet_don_hang(
          id_don_hang, 
          id_san_pham, 
          so_luong, 
          don_gia
        )
        VALUES (?, ?, ?, ?)
      ");
      $stmt->bind_param("iiid", $id_don, $pid, $qty, $don_gia);

      if (!$stmt->execute()) {
        $conn->rollback();
        out(false, ["msg" => "Lỗi lưu chi tiết đơn: " . $stmt->error]);
      }
    }

    $conn->commit();

    out(true, [
      "msg" => "Đã tạo đơn",
      "id_don_hang" => $id_don,
      "ma_don" => $ma_don
    ]);
  }

  if ($action === "set_method") {
    $id_don = intval($_POST["id_don_hang"] ?? 0);
    $method = trim($_POST["phuong_thuc_tt"] ?? "COD");

    if ($id_don <= 0) {
      out(false, ["msg" => "Thiếu ID đơn hàng"]);
    }

    if (!in_array($method, ["COD", "ONLINE"], true)) {
      out(false, ["msg" => "Phương thức không hợp lệ"]);
    }

    $stmt = $conn->prepare("
      UPDATE don_hang
      SET phuong_thuc_tt = ?
      WHERE id = ? AND trang_thai <> 'DA_THANH_TOAN'
    ");

    if (!$stmt) {
      out(false, ["msg" => "Prepare lỗi phương thức: " . $conn->error]);
    }

    $stmt->bind_param("si", $method, $id_don);

    if (!$stmt->execute()) {
      out(false, ["msg" => "Không đổi được phương thức: " . $stmt->error]);
    }

    out(true, ["msg" => "Đã cập nhật phương thức thanh toán"]);
  }

  if ($action === "mark_paid") {
    $id_don = intval($_POST["id_don_hang"] ?? 0);

    if ($id_don <= 0) {
      out(false, ["msg" => "Thiếu ID đơn hàng"]);
    }

    $stmt = $conn->prepare("
      SELECT 
        id, 
        id_khach_hang, 
        tong_tien, 
        trang_thai, 
        da_cong_diem_than_thiet
      FROM don_hang
      WHERE id = ?
      LIMIT 1
    ");

    if (!$stmt) {
      out(false, ["msg" => "Prepare lỗi lấy đơn: " . $conn->error]);
    }

    $stmt->bind_param("i", $id_don);
    $stmt->execute();
    $don = $stmt->get_result()->fetch_assoc();

    if (!$don) {
      out(false, ["msg" => "Không tìm thấy đơn hàng"]);
    }

    if ($don["trang_thai"] === "DA_THANH_TOAN") {
      out(false, ["msg" => "Đơn hàng đã thanh toán trước đó"]);
    }

    $conn->begin_transaction();

    $stmt = $conn->prepare("
      UPDATE don_hang
      SET 
        trang_thai = 'DA_THANH_TOAN',
        thoi_diem_thanh_toan = NOW()
      WHERE id = ?
    ");

    if (!$stmt) {
      $conn->rollback();
      out(false, ["msg" => "Prepare lỗi thanh toán: " . $conn->error]);
    }

    $stmt->bind_param("i", $id_don);

    if (!$stmt->execute()) {
      $conn->rollback();
      out(false, ["msg" => "Không xác nhận được thanh toán: " . $stmt->error]);
    }

    $diem_cong = 0;

    if (
      intval($don["id_khach_hang"]) > 0 &&
      intval($don["da_cong_diem_than_thiet"]) === 0
    ) {
      $diem_cong = floor(floatval($don["tong_tien"]) / 10000);

      if ($diem_cong > 0) {
        cong_diem_than_thiet(
          $conn,
          intval($don["id_khach_hang"]),
          floatval($don["tong_tien"])
        );

        $stmt = $conn->prepare("
          UPDATE don_hang
          SET da_cong_diem_than_thiet = 1
          WHERE id = ?
        ");
        $stmt->bind_param("i", $id_don);
        $stmt->execute();
      }
    }

    $conn->commit();

    $msg = "Đã xác nhận thanh toán";

    if ($diem_cong > 0) {
      $msg .= ". Đã cộng {$diem_cong} điểm thân thiết.";
    }

    out(true, ["msg" => $msg]);
  }

  if ($action === "update_ship_status") {
    require_once __DIR__ . "/lib_mail.php";

    $id_don = intval($_POST["id_don_hang"] ?? 0);
    $st = trim($_POST["trang_thai_giao_hang"] ?? "");

    $allowed = ["DA_XAC_NHAN", "CHO_GIAO_HANG", "GIAO_HANG_THANH_CONG", "HUY"];

    if ($id_don <= 0) {
      out(false, ["msg" => "Thiếu id"]);
    }

    if (!in_array($st, $allowed, true)) {
      out(false, ["msg" => "Trạng thái không hợp lệ"]);
    }

    $stmt = $conn->prepare("
      SELECT 
        id,
        id_khach_hang,
        tong_tien,
        trang_thai_giao_hang,
        COALESCE(email_khach, '') AS email_khach
      FROM don_hang
      WHERE id = ?
    ");
    $stmt->bind_param("i", $id_don);
    $stmt->execute();
    $don = $stmt->get_result()->fetch_assoc();

    if (!$don) {
      out(false, ["msg" => "Không tìm thấy đơn"]);
    }

    $stmt = $conn->prepare("
      UPDATE don_hang 
      SET trang_thai_giao_hang = ? 
      WHERE id = ?
    ");
    $stmt->bind_param("si", $st, $id_don);

    if (!$stmt->execute()) {
      out(false, ["msg" => "Không cập nhật được trạng thái"]);
    }

    if (!empty($don["email_khach"])) {
      $subject = "Cập nhật đơn hàng #" . $id_don;
      $body = "
        <h3>PetShop - Cập nhật đơn hàng #{$id_don}</h3>
        <p>Trạng thái mới: <b>{$st}</b></p>
        <p>Tổng tiền: <b>" . number_format((float)$don["tong_tien"], 0, ',', '.') . " ₫</b></p>
      ";
      send_mail($don["email_khach"], $subject, $body);
    }

    out(true, ["msg" => "Đã cập nhật trạng thái"]);
  }

  if ($action === "detail") {
    $id = intval($_GET["id"] ?? 0);

    if ($id <= 0) {
      out(false, ["msg" => "Thiếu id"]);
    }

    $stmt = $conn->prepare("
      SELECT 
        dh.*,
        kh.ho_ten AS ten_khach,
        kh.so_dien_thoai AS sdt,
        COALESCE(dh.email_khach, kh.email) AS email
      FROM don_hang dh
      LEFT JOIN khach_hang kh ON kh.id = dh.id_khach_hang
      WHERE dh.id = ? 
      LIMIT 1
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $don = $stmt->get_result()->fetch_assoc();

    if (!$don) {
      out(false, ["msg" => "Không tìm thấy đơn"]);
    }

    $stmt = $conn->prepare("
      SELECT 
        ct.id_san_pham,
        ct.so_luong,
        ct.don_gia,
        sp.ten_san_pham
      FROM chi_tiet_don_hang ct
      LEFT JOIN san_pham sp ON sp.id = ct.id_san_pham
      WHERE ct.id_don_hang = ?
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $rs = $stmt->get_result();
    $items = [];

    while ($row = $rs->fetch_assoc()) {
      $items[] = $row;
    }

    out(true, ["don" => $don, "items" => $items]);
  }

  out(false, ["msg" => "Action không hỗ trợ"]);

} catch (Throwable $e) {
  if ($conn && $conn instanceof mysqli) {
    try { $conn->rollback(); } catch (Throwable $t) {}
  }

  out(false, ["msg" => "Lỗi: " . $e->getMessage()]);
}