<?php
// admin/tao_hash.php
$pw = $_GET['pw'] ?? '123456';
echo "<h3>Password: {$pw}</h3>";
echo "<pre>" . password_hash($pw, PASSWORD_BCRYPT) . "</pre>";
