<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . "/../config/ket_noi_csdl.php";

if (!isset($_SESSION["cart"])) $_SESSION["cart"] = []; // cart[id] = qty

$action = $_POST["action"] ?? $_GET["action"] ?? "view";

function back($url="/petshop/petshop/trang_khach/gio_hang.php"){
  header("Location: ".$url);
  exit;
}

if ($action === "add") {
  $id  = (int)($_POST["id"] ?? 0);
  $qty = (int)($_POST["qty"] ?? 1);
  if ($id <= 0) back();

  // kiểm tra tồn
  $stmt = $conn->prepare("SELECT ton_kho, trang_thai FROM san_pham WHERE id=? LIMIT 1");
  $stmt->bind_param("i",$id);
  $stmt->execute();
  $sp = $stmt->get_result()->fetch_assoc();
  $stmt->close();
  if (!$sp || (int)$sp["trang_thai"] !== 1) back();

  $ton = (int)$sp["ton_kho"];
  $qty = max(1, $qty);
  $old = (int)($_SESSION["cart"][$id] ?? 0);
  $new = min($ton, $old + $qty);
  $_SESSION["cart"][$id] = $new;

  back("/petshop/petshop/trang_khach/gio_hang.php");
}

if ($action === "update") {
  // nhận mảng qty[id] => số lượng
  $qtys = $_POST["qty"] ?? [];
  foreach ($qtys as $id => $q) {
    $id = (int)$id;
    $q  = (int)$q;
    if ($id <= 0) continue;
    if ($q <= 0) { unset($_SESSION["cart"][$id]); continue; }

    $stmt = $conn->prepare("SELECT ton_kho, trang_thai FROM san_pham WHERE id=? LIMIT 1");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $sp = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$sp || (int)$sp["trang_thai"] !== 1) { unset($_SESSION["cart"][$id]); continue; }

    $_SESSION["cart"][$id] = min((int)$sp["ton_kho"], max(1,$q));
  }
  back("/petshop/petshop/trang_khach/gio_hang.php");
}

if ($action === "remove") {
  $id = (int)($_POST["id"] ?? $_GET["id"] ?? 0);
  if ($id > 0) unset($_SESSION["cart"][$id]);
  back("/petshop/petshop/trang_khach/gio_hang.php");
}

if ($action === "clear") {
  $_SESSION["cart"] = [];
  back("/petshop/petshop/trang_khach/gio_hang.php");
}

back("/petshop/petshop/trang_khach/gio_hang.php");
