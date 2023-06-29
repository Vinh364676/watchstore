<?php
require 'db/connect.php';
$db = new Database();
$email = $_GET['email'];
$token = $_GET['token'];

$result = $db->query("SELECT * FROM user WHERE email = '$email' AND reset_token = '$token'");
if ($result) {
    if (isset($_POST['submit'])) {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        if ($new_password === $confirm_password) {
            // Cập nhật mật khẩu mới trong cơ sở dữ liệu
            $query = "UPDATE account 
            INNER JOIN user ON account.user_id = user.id_user
            SET account.password = '$new_password'
            WHERE user.email = '$email'";
            $db->query($query);

            // Hiển thị thông báo thành công và điều hướng người dùng
            echo "Thay đổi mật khẩu thành công!";
            header("Location: index1.php");
            exit();
        } else {
            // Hiển thị thông báo lỗi khi mật khẩu không khớp
            echo "Mật khẩu không khớp. Vui lòng nhập lại.";
        }
    }
} else {
    // Hiển thị thông báo yêu cầu không hợp lệ
    echo "Yêu cầu không hợp lệ.";
}

// Hiển thị biểu mẫu thay đổi mật khẩu
echo '
<form method="POST" action="" style="max-width: 400px; margin: 40px auto; background-color: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
    <label for="new_password" style="display: block; margin-bottom: 10px;">Tạo mật khẩu mới cho</label>
    <label for="new_password" style="display: block; margin-bottom: 10px;">' . $email . '</label>

    <label for="new_password" style="display: block; margin-bottom: 10px;">Mật khẩu mới:</label>
    <input type="password" id="new_password" name="new_password" required oninput="validatePassword()" style="width: 100%; padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #ccc;"><br>

    <label for="confirm_password" style="display: block; margin-bottom: 10px;">Xác nhận mật khẩu:</label>
    <input type="password" id="confirm_password" name="confirm_password" required oninput="validatePassword()" style="width: 100%; padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #ccc;"><br>

    <span id="lowercase" style="display: block; margin-bottom: 5px; font-size: 14px; color: #f44336;">Ít nhất một kí tự viết thường.</span>
    <span id="uppercase" style="display: block; margin-bottom: 5px; font-size: 14px; color: #f44336;">Ít nhất một kí tự viết hoa.</span>
    <span id="length" style="display: block; margin-bottom: 5px; font-size: 14px; color: #f44336;">8-16 kí tự.</span>

    <input type="submit" name="submit" value="Đổi mật khẩu" style="width: 100%; padding: 10px; font-size: 16px; background-color: #4caf50; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
</form>
';

echo '
<script>
    function validatePassword() {
        var password = document.getElementById("new_password").value;

        var lowercaseLabel = document.getElementById("lowercase");
        var uppercaseLabel = document.getElementById("uppercase");
        var lengthLabel = document.getElementById("length");
        var charactersLabel = document.getElementById("characters");

        var lowercaseRegex = /[a-z]/;
        var uppercaseRegex = /[A-Z]/;
        var lengthRegex = /^.{8,16}$/;

        lowercaseLabel.style.color = lowercaseRegex.test(password) ? "#4CAF50" : "#f44336";
        uppercaseLabel.style.color = uppercaseRegex.test(password) ? "#4CAF50" : "#f44336";
        lengthLabel.style.color = lengthRegex.test(password) ? "#4CAF50" : "#f44336";
        charactersLabel.style.color = charactersRegex.test(password) ? "#4CAF50" : "#f44336";
    }
</script>
';

?>
