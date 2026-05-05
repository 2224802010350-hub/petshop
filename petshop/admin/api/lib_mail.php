<?php
// PETSHOP/admin/api/lib_mail.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . "/../../vendor/autoload.php";

function send_mail($to, $subject, $html){
  $mail = new PHPMailer(true);

  // ====== cấu hình SMTP (bạn thay theo email của bạn) ======
  $SMTP_HOST = "smtp.gmail.com";
  $SMTP_USER = "YOUR_GMAIL@gmail.com";
  $SMTP_PASS = "YOUR_APP_PASSWORD"; // Gmail App Password
  $SMTP_PORT = 587;

  try {
    $mail->isSMTP();
    $mail->Host = $SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = $SMTP_USER;
    $mail->Password = $SMTP_PASS;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = $SMTP_PORT;

    $mail->setFrom($SMTP_USER, "PETSHOP");
    $mail->addAddress($to);

    $mail->isHTML(true);
    $mail->CharSet = "UTF-8";
    $mail->Subject = $subject;
    $mail->Body = $html;

    $mail->send();
    return true;
  } catch (Exception $e) {
    // demo: không chặn luồng nếu email lỗi
    return false;
  }
}
