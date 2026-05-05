<?php
require_once __DIR__ . "/../config/ket_noi_csdl.php";
require_once __DIR__ . "/../config/ham_chung.php";

$action = get("action","list");

if ($action === "list") {
  $dm = get("dm","all");
  $q  = get("q","");
  $where = " WHERE sp.trang_thai=1 ";
  if ($dm !== "all" && $dm !== "") $where .= " AND sp.id_danh_muc=" . (int)$dm . " ";
  if ($q !== "") {
    $qq = $conn->real_escape_string($q);
    $where .= " AND (sp.ten_san_pham LIKE '%$qq%' OR sp.ma_sku LIKE '%$qq%') ";
  }
  $sql = "SELECT sp.id, sp.ten_san_pham, sp.gia_ban, sp.ton_kho, sp.hinh_anh 
          FROM san_pham sp $where ORDER BY sp.ngay_tao DESC";
  $rs = $conn->query($sql);
  $items = [];
  while($row=$rs->fetch_assoc()){
    if ($row['hinh_anh']) $row['hinh_anh'] = "/uploads/".$row['hinh_anh'];
    $items[] = $row;
  }
  json_response(["ok"=>true,"items"=>$items]);
}

if ($action === "detail") {
  $id = (int)get("id",0);
  $sql = "SELECT * FROM san_pham WHERE id=$id";
  $rs = $conn->query($sql);
  $item = $rs->fetch_assoc();
  if (!$item) json_response(["ok"=>false,"message"=>"Không tìm thấy sản phẩm"],404);
  if ($item['hinh_anh']) $item['hinh_anh'] = "/uploads/".$item['hinh_anh'];
  json_response(["ok"=>true,"item"=>$item]);
}

/* ===== ADMIN CRUD ===== */
if ($action === "admin_list") {
  require_role(["admin","thukho"]);
  $rs = $conn->query("SELECT sp.*, dm.ten_danh_muc FROM san_pham sp JOIN danh_muc dm ON dm.id=sp.id_danh_muc ORDER BY sp.ngay_tao DESC");
  $items = [];
  while($row=$rs->fetch_assoc()){
    $items[] = $row;
  }
  json_response(["ok"=>true,"items"=>$items]);
}
