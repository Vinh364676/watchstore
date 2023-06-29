<?php
require_once '../db/connect.php';
include ("function_code.php");
$db = new Database();
if (isset($_POST['register'])) {
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

    $result = $db->select($sql);

    if ($result) {
        echo '<script>';
        echo 'alert("Tài khoản đã tồn tại.");';
        echo '</script>';
        exit("Tài khoản đã tồn tại");
    } else {
        $dataUser = [
            'name' => $full_name,
            'address' => $address,
            'phone' => $phone_numbers,
            'email' => $email,
            'type' => 2,
            'role_id' => 4,
            'birthday' => $date,
            'gender' => $gender
        ];
        $db->insert('user', $dataUser);

        $user_id = $db->conn->insert_id;
        $dataAccount = [
            'user_name' => $username,
            'password' => $password,
            'create_date' => $current_date,
            'status' => 1,
            'user_id' => $user_id,
            'verification' => $verificationCode
        ];
        $db->insert('account', $dataAccount);
        
        
        $response = [
            'status' => 'success',
            'message' => 'Register successfully'
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    $db->close();
}
?>