<?php
require "db/connect.php";
$db = new Database();
require("PHPMailer/src/PHPMailer.php");
require("PHPMailer/src/SMTP.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets./css./bootstrap./bootstrap-5.2.2-dist./css/bootstrap.css">
    <link rel="stylesheet" href="./assets./css./Roboto/Roboto-Medium.ttf">
    <link rel="stylesheet" href="./assets./css./themify-icons-font/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="./assets./css/index.css">
    <link rel="stylesheet" href="./assets./css/modal.css">
    <link rel="stylesheet" href="./assets./css/product.css">
    <link rel="stylesheet" href="./assets./css/card.css">
    <link rel="stylesheet" href="./assets./css/order.css">
    <link href="./assets./css./aos-master/aos-master./dist/aos.css" rel="stylesheet">
    <script src="./assets./css./aos-master/aos-master./dist/aos.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

</head>

<body>
    <?php include 'template/header.php' ?>
    <form method="post" action="">
        <div id="wrapper">
            <div class="wrapper_child order-flex">
                <!-- Content -->
                <div class="info">
                    <h2 class="info__title">Thông tin thanh toán</h2>
                    <?php
                $user_id = $_SESSION["user_id"];
                $data = $db->select("SELECT * FROM user WHERE user.id_user = '$user_id' ");
                // $lastCode = null;
                
                foreach ($data as $rows) {
                ?>
                    <div class="info__rows">
                        <label for="" class="info__rows-label">Họ tên *</label><br>
                        <input class="info__rows-input" name="fullname" value="<?php echo $rows['name'] ?>" type="text"
                            required oninvalid="this.setCustomValidity('Vui lòng nhập họ tên của bạn')"
                            oninput="setCustomValidity('')">
                    </div>

                    <div class="info__rows">
                        <label for="" class="info__rows-label">Địa chỉ *</label>
                        <input class="info__rows-input" value="<?php echo $rows['address'] ?>" name="deliver_address"
                            type="text" required oninvalid="this.setCustomValidity('Vui lòng nhập địa chỉ của bạn')"
                            oninput="setCustomValidity('')">
                    </div>

                    <div class="info__rows">
                        <label for="" class="info__rows-label">Số điện thoại *</label>
                        <input class="info__rows-input" value="<?php echo $rows['phone'] ?>" name="dienthoai" type="tel"
                            pattern="^0[0-9]{9,10}" required
                            oninvalid="this.setCustomValidity('Vui lòng nhập số điện thoại của bạn! Số điện thoại phải đủ 10 số và bắt đầu bằng 0')"
                            oninput="setCustomValidity('')">
                    </div>

                    <div class="info__rows">
                        <label for="" class="info__rows-label">Email *</label>
                        <input class="info__rows-input" value="<?php echo $rows['email'] ?>" name="email" type="email"
                            required
                            oninvalid="this.setCustomValidity('Vui lòng nhập email của bạn! Email phải đúng định dang. Vd abc@abc.com')"
                            oninput="setCustomValidity('')">
                    </div>

                    <div class="info__rows">
                        <label for="" class="info__rows-label">Ghi chú đơn hàng *</label>
                        <input name="description_bill" class="info__rows-input info__rows-input-more" type="text"
                            placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn."
                            autofocus>
                    </div>
                    <?php } ?>
                </div>
                <div class="bill">
                    <div class="bill-detail">
                        <h4 class="bill-title">Tổng số lượng</h4>
                        <div class="bill__rows">
                            <p class="bill__rows-name">SẢN PHẨM</p>
                            <b class="bill__rows-price">TỔNG CỘNG</b>
                        </div>
                        <?php
      $total = 0; // Khởi tạo biến tổng tiền bằng 0
      $user_id = $_SESSION["user_id"];
      if(isset($_SESSION["cart"])) {
        foreach($_SESSION["cart"] as $item) {
            if($item["user_id"] == $user_id){
          $subtotal = $item["price"] * $item["quantity"]; // Tính tổng tiền cho từng sản phẩm
          $total += $subtotal; // Cộng tổng tiền của từng sản phẩm vào biến tổng tiền
          if ($total > 3000000) {
            $shippingFee = 0; // miễn phí vận chuyển
        } else {
            $shippingFee = 30000; // tính phí vận chuyển 50.000 đồng
        }
        $totalWithShipping = $total + $shippingFee;
    ?>

                        <div class="bill__rows">
                            <p class="bill__rows-name"><?php echo $item["name"]; ?> x <?php echo $item["quantity"]; ?>
                            </p>
                            <b class="bill__rows-price"><?php echo number_format($subtotal, 0, ',', '.') ?>đ</b>
                        </div>
                        <?php
    }}}
    ?>
                        <div class="bill__rows">
                            <p class="bill__rows-name">Phí vận chuyển</p>
                            <b class="bill__rows-price"><?php echo number_format($shippingFee, 0, ',', '.'); ?>đ</b>
                        </div>

                        <p class="bill__rows-name">Mã giảm giá</p>
                        <input value="" id="promocode">
                        <input type="button" id="promotion" value="Áp dụng" />
                        <div id="result"></div>

                        <div class="bill__rows row-affect">
                            <p class="bill__rows-name">Tổng cộng</p>
                            <b
                                class="bill__rows-price-total"><?php echo number_format($totalWithShipping, 0, ',', '.'); ?>đ</b>
                            <input type="hidden" name="totalAfterDiscount" id="totalAfterDiscount"
                                value="<?php echo $totalWithShipping; ?>">
                        </div>

                        <div>
                            <input type="checkbox" class="">
                            <span>Thanh toán khi nhận hàng</span>
                        </div>

                        <input type="hidden" id="voucher_id" name="voucher_id">
                        <button type="submit" id="order_product_detail" name="order_product_detail"
                            class="bill-title bill-btn">Đặt hàng</button>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <?php include 'template/footer.php' ?>
        </div>
    </form>
    <!-- Modal -->
    <?php include 'template/modal.php' ?>

    <script src="assets/css/bootstrap/bootstrap-5.2.2-dist/js/bootstrap.js"></script>
    <script>
    AOS.init();
    </script>
    <script src="assets/js/index.js"></script>
</body>

</html>
<script>
jQuery(document).ready(function() {
    jQuery("#promotion").click(function() {
        var promocode = jQuery("#promocode").val();
        jQuery.ajax({
            type: "POST",
            url: "check_promocode.php",
            data: {
                promocode: promocode
            },
            success: function(data) {
                var parsedData = JSON.parse(data); //chuyen doi json
                if (parsedData.value) {
                    var discountAmount = parsedData.value;
                    var voucher_id = parsedData.voucher_id;
                    console.log(voucher_id);
                    jQuery("#voucher_id").val(voucher_id);
                    jQuery("#result").html("Bạn đã được giảm giá " + discountAmount + "%");
                    var totalBeforeDiscount = <?php echo $total; ?>;
                    var totalWithShipping = <?php echo $totalWithShipping; ?>;
                    if (totalBeforeDiscount > 3000000) {
                        shippingFee = 0; // miễn phí vận chuyển
                    } else {
                        shippingFee = 30000; // tính phí vận chuyển 50.000 đồng
                    }
                    if (discountAmount) {
                        discountAmount = totalBeforeDiscount * discountAmount / 100;
                        totalAfterDiscount = totalBeforeDiscount - discountAmount +
                            shippingFee;
                        jQuery(".bill__rows-price-total").html(totalAfterDiscount
                            .toLocaleString('vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            }));
                    } else {
                        totalAfterDiscount = totalWithShipping;
                        // Nếu không có giảm giá, sử dụng tổng tiền đã tính từ trước
                        jQuery(".bill__rows-price-total").html((totalAfterDiscount)
                            .toLocaleString('vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            }));
                    }
                    jQuery("#totalAfterDiscount").val(totalAfterDiscount);
                } else {
                    var voucher_id = parsedData.voucher_id;
                    console.log(voucher_id);
                    jQuery("#voucher_id").val(voucher_id);
                    jQuery("#result").html("Mã giảm giá không hợp lệ hoặc hết hạn!");
                }
            }
        });
    });
});
</script>

<?php
$db = new Database();
    if(isset($_POST['order_product_detail'])){
        if(isset($_COOKIE['user_name'])) {
        $cartData = $_SESSION["cart"];
        $email = $_POST['email'];
        $fullname = $_POST['fullname'];
        //tồn tại thì giá trị của $totalAfterDiscount được gán bằng giá trị của $_POST['totalAfterDiscount'],
        // ngược lại nó sẽ được gán bằng giá trị của $totalWithShipping.
        $totalAfterDiscount = isset($_POST['totalAfterDiscount']) ? $_POST['totalAfterDiscount'] : $totalWithShipping;
        if(isset($_POST['voucher_id'])){
            $voucher_id  = $_POST['voucher_id'];
            foreach ($cartData as $item){
                $data = array(
                "fullname" => $fullname,
                "deliver_address" => $_POST['deliver_address'],
                "dienthoai" => $_POST['dienthoai'],
                "email" => $email,
                "description_bill" => $_POST['description_bill'],
                "voucher_id" => isset($_POST['voucher_id']),
                "user_id"=> $item['user_id'],
                "total_price" => $totalAfterDiscount,
                "status_bill" => 1
            );    }
        } else{
            foreach ($cartData as $item){
                $data = array(
                "fullname" => $fullname,
                "deliver_address" => $_POST['deliver_address'],
                "dienthoai" => $_POST['dienthoai'],
                "email" => $email,
                "description_bill" => $_POST['description_bill'],
                "user_id"=> $item['user_id'],
                "total_price" => $totalAfterDiscount,
                "status_bill" => 1
            );    }
        }
        
        
         
    // Print other fields as needed
        $sql = "SELECT * FROM bill as b join bill_detail as bd on b.id_bill = bd.id_bill
        JOIN product AS p on bd.id_product = p.id_product
        JOIN user as u ON b.user_id = u.id_user
        LEFT JOIN voucher as v ON b.voucher_id = v.id_voucher";
       // $result = $db->query($sql);
       $success =  $db->insert('bill', $data);
       $id_bill = $db->conn->insert_id; 
       $order_content = '';
       foreach ($cartData as $item) {
        $id_product = $item['id_product'];
        // Truy vấn SQL để lấy thông tin name_product từ bảng product
    $sql = "SELECT name FROM product WHERE id_product = $id_product";
    $result = $db->query($sql);
    
    if ($result) {
        // Lấy dòng dữ liệu kết quả từ truy vấn
        $row = $result->fetch_assoc();
        $product_name = $row['name'];
        $quantity = $item['quantity'];
          // Tạo thông tin sản phẩm gồm tên và số lượng
          $product_info = $product_name . ' - Số lượng: ' . $quantity;

          // Thêm thông tin sản phẩm vào chuỗi $order_content và xuống dòng
          $order_content .= $product_info . '<br>';
    }   
    $name_product = rtrim($name_product, ', ');
        $data_bill_detail = array(
               "id_bill" => $id_bill,
               "id_product" => $id_product,
               "unit_price" => $item['price'],
               "quantity" => $quantity,
           );
          $db->insert('bill_detail', $data_bill_detail);
        }
        unset($_SESSION['cart']); 
        $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsSMTP(); // enable SMTP

    $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465; // or 587
    $mail->IsHTML(true);
    $mail->Username = "mailer.watchstore@gmail.com";
    $mail->Password = "rdhpbkugvhrnhuha";
    $mail->SetFrom("mailer.watchstore@gmail.com","Watch Store");
    $mail->CharSet = 'UTF-8'; // Thiết lập mã hóa UTF-8
    $mail->Encoding = 'base64'; // Thiết lập phương thức mã hóa
    $mail->Subject = '=?UTF-8?B?' . base64_encode('Xác nhận đặt hàng') . '?=';
    $mail->Body = '<html><head><style>* {font-family: Arial, sans-serif;}</style></head><body>Xin chào ' . $fullname . ',<br><br>Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn đã được ghi nhận.<br><br>Thông tin đơn hàng:<br>Tên: ' . $fullname . '<br>Email: ' . $email . '<br>Nội dung đặt hàng:<br>' . $order_content . '</body></html>'; 
       $mail->IsHTML(true); // Thiết lập email dạng HTML
  $mail->AddAddress($email);

     if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
     } else {
        echo "Message has been sent";
     } 
        ?>
<script>
window.location.href = "camon.php";
</script>
<?php
    } else{
        echo '<script>';
        echo 'alert("Bạn cần đăng nhập để truy cập nội dung này.");';
        echo '</script>';        
    }
} 
   
?>
<!-- <script>
function validateForm() {
    var fullname = $("input[name='fullname']").val();
    var deliver_address = $("input[name='deliver_address']").val();
    var dienthoai = $("input[name='dienthoai']").val();
    var email = $("input[name='email']").val();

    // Kiểm tra không được để rỗng
    if (fullname == "" || deliver_address == "" || dienthoai == "" || email == "") {
        alert("Vui lòng điền đầy đủ thông tin!");
        if (fullname == "") {
            $("input[name='fullname']").focus();
        } else if (deliver_address == "") {
            $("input[name='deliver_address']").focus();
        } else if (dienthoai == "") {
            $("input[name='dienthoai']").focus();
        } else {
            $("input[name='email']").focus();
        }
        return false;
    }

}
</script> -->