<?php
include("../config/ket_noi_csdl.php");

$id = $_GET['id'] ?? 0;

if($id){
    $sql = "DELETE FROM dich_vu_spa WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: spa.php");
exit;
