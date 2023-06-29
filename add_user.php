<?php
session_start();
require "db/connect.php";
require("PHPMailer/src/PHPMailer.php");
require("PHPMailer/src/SMTP.php");
require("PHPMailer/src/Exception.php");
require("handle/function_code.php");

$db = new Database();

$full_name = $_POST['fullname'];
$gender = $_POST['gender'];
$date = $_POST['date'];
$address = $_POST['address'];
$email = $_POST['email'];
$phone_numbers = $_POST['phone_numbers'];
$username = $_POST['username'];
$password = $_POST['pass'];
$current_date = date('Y-m-d');
$verificationCode = generateVerificationCode();

$sql = "SELECT * FROM account WHERE user_name = '$username'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    $response = array("message" => "Người dùng đã tồn tại!");
} else {
    $_SESSION["user_new"] = array(
        "full_name" => $full_name,
        "gender" => $gender,
        "date" => $date,
        "address" => $address,
        "email" => $email,
        "phone_numbers" => $phone_numbers,
        "username" => $username,
        "password" => $password,
        "current_date" => $current_date,
        "verificationCode" => $verificationCode
    );
    $response = array(
      "message" => "Thêm người dùng thành công!"
  );
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465; // or 587
    $mail->IsHTML(true);
    $mail->Username = "mailer.watchstore@gmail.com";
    $mail->Password = "rdhpbkugvhrnhuha";
    $mail->SetFrom("mailer.watchstore@gmail.com", "Watch Store");
    $mail->CharSet = 'UTF-8'; // Thiết lập mã hóa UTF-8
    $mail->Encoding = 'base64'; // Thiết lập phương thức mã hóa
    $mail->Subject = 'Mã xác nhận';
    $mail->Body = '<html><head><style>* {font-family: Arial, sans-serif;}</style></head><body>Xin chào ' . $full_name . ',<br><br>Cảm ơn bạn đã đăng ký. Mã xác nhận của bạn là: <strong>' . $verificationCode . '</strong>.<br><br>Vui lòng nhập mã này vào trang đăng ký để hoàn tất quá trình đăng ký.<br><br>Trân trọng,<br>Watch Store</body></html>';
    $mail->AddAddress($email);
    $mail->Send();
}

header('Content-Type: application/json');
echo json_encode($response);
$db->close();
?>
