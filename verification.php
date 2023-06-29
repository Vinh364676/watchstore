<?php
    session_start();
    require "db/connect.php";
    $db = new Database();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Nhập mã xác nhận</title>
    <style>
    body {
        background-color: #f2f2f2;
        font-family: Arial, sans-serif;
    }

    .container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: 400px;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    .form-group {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 20px;
    }

    .verification-code-input {
        display: inline-block;
        width: 40px;
        height: 40px;
        padding: 0;
        margin: 0 5px;
        font-size: 20px;
        text-align: center;
        border: 2px solid #ccc;
        border-radius: 3px;
    }

    .verification-code-input:focus {
        outline: none;
        border-color: #4caf50;
    }

    input[type="text"][name="otp"] {
        display: block;
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 2px solid #ccc;
        border-radius: 3px;
        margin-bottom: 10px;
    }

    input[type="submit"] {
        display: block;
        width: 100%;
        padding: 10px;
        font-size: 16px;
        background-color: #4caf50;
        color: #fff;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }

    p {
        margin-bottom: 10px;
    }

    p a {
        color: #4caf50;
        text-decoration: underline;
        cursor: pointer;
    }
    </style>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var verificationCodeInputs = document.getElementsByClassName('verification-code-input');
        var submitButton = document.querySelector('input[type="submit"]');

        submitButton.addEventListener('click', function() {
            var isNotEmpty = true;

            for (var i = 0; i < verificationCodeInputs.length; i++) {
                if (verificationCodeInputs[i].value === '') {
                    isNotEmpty = false;
                    break;
                }
            }

            if (!isNotEmpty) {
                alert('Vui lòng nhập vào tất cả các ô mã!');
            }
        });

        var currentInputIndex = 0;

        for (var i = 0; i < verificationCodeInputs.length; i++) {
            verificationCodeInputs[i].addEventListener('click', function() {
                currentInputIndex = Array.prototype.indexOf.call(verificationCodeInputs, this);
            });
        }

        document.addEventListener('keydown', function(event) {
            var keyCode = event.keyCode || event.which;
            var input = verificationCodeInputs[currentInputIndex];

            if (keyCode >= 48 && keyCode <= 57) {
                input.value = String.fromCharCode(keyCode);

                if (currentInputIndex < verificationCodeInputs.length - 1) {
                    currentInputIndex++;
                }
            } else if (keyCode === 8) {
                input.value = '';

                if (currentInputIndex > 0) {
                    currentInputIndex--;
                }
            }
        });
    });
    </script>
</head>

<body>
    <form method="post">
        <div class="container">
            <p style="font-weight: bold; text-align: center; font-size: 24px; margin-bottom: 20px;">Xác thực mã OTP</p>

            <?php
        if(isset($_SESSION["user_new"])){
            $userData = $_SESSION["user_new"];
            ?>

            <p style="text-align: center; font-size: 16px; margin-bottom: 20px">Mã xác nhận được gửi qua email</p>
            <p style="text-align: center; font-size: 16px;color: #333333;"><?php echo $userData["email"]; ?></p>
            <p style="font-weight: bold; text-align: center; font-size: 20px; margin-bottom: 20px">Vui lòng nhập mã OTP:
            </p>
            <div class="form-group">
                <input type="text" class="verification-code-input" id="input1" name="input1" readonly>
                <input type="text" class="verification-code-input" id="input2" name="input2" readonly>
                <input type="text" class="verification-code-input" id="input3" name="input3" readonly>
                <input type="text" class="verification-code-input" id="input4" name="input4" readonly>
                <input type="text" class="verification-code-input" id="input5" name="input5" readonly>
                <input type="text" class="verification-code-input" id="input6" name="input6" readonly>
            </div>

            <?php }
         ?>

            <p style="text-align: center; font-size: 16px; margin-bottom: 20px">Bạn chưa nhận được mã? <a>Gửi lại
                    OTP</a></p>
            <input type="submit" name="submit" onclick="combineVerificationCode()" value="Xác nhận">
        </div>
    </form>

</body>


</html>
<?php
    if(isset($_POST['submit'])){
        $verificationCode = $_POST['input1'] . $_POST['input2'] . $_POST['input3'] . $_POST['input4'] . $_POST['input5'] . $_POST['input6'];

        if(isset($_SESSION["user_new"])){
            $userData = $_SESSION["user_new"];
        
            $code = $userData["verificationCode"];

            // So sánh mã OTP nhập vào với mã OTP trong session
            if($verificationCode === $code){
                // Tiến hành xử lý tiếp theo sau khi mã OTP hợp lệ
                    $dataUser = [
                        "name"=> $userData['full_name'],
                        "address"=> $userData['address'],
                        "phone"=> $userData['phone_numbers'],
                        "email"=> $userData['email'],
                        "type"=> 2,
                        "role_id"=> 4,
                        "birthday"=> $userData['date'],
                        "gender"=> $userData['gender'],
                    ];
                    $db->insert('user', $dataUser);
                    $user_id = $db->conn->insert_id;
                    $dataAccount = [
                        "user_name"=> $userData['username'],
                        "password"=> $userData['password'],
                        "create_date"=> $userData['current_date'],
                        "status"=> 1,
                        "user_id" => $user_id,
                        'verification' => $code
                    ];
                    $db->insert('account', $dataAccount);
                    unset($_SESSION['user_new']);
                    ?>
                    <script>
                        window.location.href = "index1.php";
                        alert("Tạo tài khoản thành công");
                    </script>
                    <?php
                }
            } else {
                echo "Mã OTP không hợp lệ. Vui lòng thử lại.";
                // Hiển thị thông báo lỗi cho người dùng
            }
        }
    
?>
<script>
function combineVerificationCode() {
    var code = '';
    for (var i = 1; i <= 6; i++) {
        var input = document.getElementById('input' + i);
        code += input.value;
    }
    console.log(code); // In giá trị gộp thành chuỗi
}
</script>