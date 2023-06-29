
<?php 
session_start();

unset($_SESSION['user_name']);
setcookie('user_name', '', time() - 3600, '/'); // Đặt thời gian sống của cookie là trước đó 1 giờ
header("Location: ../index1.php");
exit();

?>
