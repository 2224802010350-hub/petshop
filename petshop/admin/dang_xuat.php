<?php
if (session_status() === PHP_SESSION_NONE) session_start();
session_destroy();
header("Location: /petshop/petshop/admin/dang_nhap.php");
exit;
