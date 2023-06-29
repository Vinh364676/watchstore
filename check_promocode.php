<?php
require "db/connect.php";
$promocode = $_POST['promocode'];

// Kết nối tới CSDL
$db = new Database();

// Kiểm tra xem mã giảm giá có tồn tại và còn hiệu lực hay không
$sql = "SELECT * FROM voucher WHERE code = '$promocode' AND start_date <= NOW() AND end_date >= NOW();";
$result = $db->query($sql);
if ($result->num_rows > 0) {
  // Mã giảm giá hợp lệ, lấy giá trị giảm giá từ cơ sở dữ liệu
  $row = $result->fetch_assoc();

  $discountPercent = $row['value'];
  $voucher_id = $row['id_voucher'];
  // Trả về giá trị giảm giá dưới dạng JSON
  $response = array('value' => $discountPercent, 'voucher_id' => $voucher_id);
  echo json_encode($response);
} else {
  // Mã giảm giá không hợp lệ
  $response = array('voucher_id' => null);
  echo json_encode($response);
}

// Đóng kết nối tới CSDL
$db->close();
?>
