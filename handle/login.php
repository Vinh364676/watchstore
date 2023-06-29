
<?php

// kiểm tra xem yêu cầu đăng nhập có phải là phương thức POST không

  // nhận dữ liệu đăng nhập từ client
  require_once '../db/connect.php';
  $db = new database();
  $user_name = $_POST['user_name'];
  $password = $_POST['password'];
  // kiểm tra thông tin đăng nhập
  $sql = "SELECT * FROM account, user WHERE user_name = '$user_name' AND password = '$password' AND account.user_id = user.id_user AND user.type = '1' ";
  $sql1 = "SELECT * FROM account, user WHERE user_name = '$user_name' AND password = '$password' AND account.user_id = user.id_user AND user.type = '2' ";
  $result = $db->select($sql);
  $result1 = $db->select($sql1);
  if ($result) {
  // thông tin đăng nhập đúng
  session_start();
  $_SESSION['user_name'] = $user_name;
  $user_id = $result[0]['user_id'];
  $_SESSION['user_id'] = $user_id;
  //$role_id = $result[0]['role_id'];
  $response = array('status' => 'nvsuccess', 'message' => 'Nhân viên đăng nhập thành công');
  //setcookie('role_id', $role_id, time() + (86400 * 30), '/');
  setcookie('role_id', $result[0]['role_id'], time() + (86400 * 30), '/');
  setcookie('user_name', $user_name, time() + (86400 * 30), '/');
} else if ($result1) {
  // thông tin đăng nhập đúng cho khách hàng
  session_start();
  $_SESSION['user_name'] = $user_name;
  $user_id = $result1[0]['user_id'];
  $_SESSION['user_id'] = $user_id;
  // $role_id = $result[0]['role_id'];
  $response = array('status' => 'khsuccess', 'message' => 'Khách hàng đăng nhập thành công');
  setcookie('role_id', $result1[0]['role_id'], time() + (86400 * 30), '/');
  setcookie('user_name', $user_name, time() + (86400 * 30), '/');
}
 else {
    // thông tin đăng nhập sai
    $response = array('status' => 'error', 'message' => 'Tên đăng nhập hoặc mật khẩu không đúng');
  }

  // trả về phản hồi JSON
  header('Content-Type: application/json');

  echo json_encode($response);

?>


