<?php
require "db/connect.php";
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

    <div id="oder">
        <form method="post" action="">


            <div id="wrapper">
                <div class="wrapper_child order-flex">
                    <!-- Content -->
                    <div class="info">
                        <h2 class="info__title">Thông tin thanh toán</h2>

                        <div class="info__rows">
                            <label for="" class="info__rows-label">Họ tên *</label><br>
                            <input class="info__rows-input" name="fullname" type="text">
                        </div>

                        <div class="info__rows">
                            <label for="" class="info__rows-label">Địa chỉ *</label>
                            <input class="info__rows-input" name="deliver_address" type="text">
                        </div>

                        <div class="info__rows">
                            <label for="" class="info__rows-label">Số điện thoại *</label>
                            <input class="info__rows-input" name ="dienthoai" type="text">
                        </div>

                        <div class="info__rows">
                            <label for="" class="info__rows-label">Email *</label>
                            <input class="info__rows-input" name="email" type="text">
                        </div>

                        <div class="info__rows">
                            <label for="" class="info__rows-label">Ghi chú đơn hàng *</label>
                            <input name="description_bill" class="info__rows-input info__rows-input-more" type="text"
                                placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn."
                                autofocus>
                        </div>

                    </div>

                    <div class="bill">
                        <div class="bill-detail">
                        </div>
                        <div>
                            <input type="checkbox" class="">
                            <span>Thanh toán khi nhận hàng</span>
                        </div>
                        <input type="hidden" id="voucher_id" name="voucher_id" value="">
                        <button type="submit" id="order_product_detail" name ="order_product_detail" class="bill-title bill-btn">Đặt hàng</button>
                    </div>
                </div>
                <!-- Footer -->
                <?php include 'template/footer.php' ?>
            </div>
        </form>
    </div>
    <!-- Modal -->
    <?php include 'template/modal.php' ?>

    <script src="assets/css/bootstrap/bootstrap-5.2.2-dist/js/bootstrap.js"></script>
    <script>
    AOS.init();
    </script>
    <script src="assets/js/index.js"></script>
    </div>
</body>

</html>

<script>
var cartData = JSON.parse(sessionStorage.getItem('cart')) || [];
console.log(cartData);
var cartHtml = `
            <h4 class="bill-title">Đơn hàng của bạn</h4>
            <div class="bill__rows">
                <p class="bill__rows-name">SẢN PHẨM</p>
                <b class="bill__rows-price">TỔNG CỘNG</b>
            </div>
        `;
var totalPrice = 0;
var totalAfterDiscount = 0;
cartData.forEach(function(item) {
    var productHtml = `
                <div class="bill__rows">
                    <p class="bill__rows-name_product">${item.name} x ${item.quantity}</p>
                    <b class="bill__rows-price_product">${(item.price * item.quantity).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })}</b>
                </div>
            `;
    cartHtml += productHtml;
    totalPrice += item.price * item.quantity;
});
if (totalPrice < 3000000) {
    shippingFee = 10000;
} else {
    shippingFee = 0;
}

cartHtml += `
            <div class="bill__rows">
                <p class="bill__rows-name">Phí vận chuyển</p>
                <b class="bill__rows-price-ship">${shippingFee.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })}</b>
            </div>
            <p class="bill__rows-name">Mã giảm giá</p>
            <input value = "" id="promocode">
            <input type="button" id="promotion" value ="Áp dụng"/>
            <div id="result"></div>
            <div class="bill__rows row-affect">
                <p class="bill__rows-name">Tổng cộng</p>
                <b name="total_price" class="bill__rows-price-total">${(totalPrice + shippingFee).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })}</b>

            </div>
            
        `;
        
jQuery('.bill-detail').append(cartHtml);
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
                jQuery("#result").html(data);
                var parsedData = JSON.parse(data); //chuyen doi json
                var discountPercent = parsedData.value;
                var voucher_id = parsedData.voucher_id;
                console.log(voucher_id);
                jQuery("#voucher_id").val(voucher_id);
                var totalBeforeDiscount = totalPrice; //gia trri ban dau
                var discountAmount = totalBeforeDiscount * discountPercent /
                100; //gia tri giam gia
                var totalAfterDiscount = totalBeforeDiscount - discountAmount +
                shippingFee; //gia tri that sau giam gia
                if (discountPercent) {
                    jQuery(".bill__rows-price-total").html(totalAfterDiscount
                        .toLocaleString('vi-VN', {
                            style: 'currency',
                            currency: 'VND'
                        }));
                } else {
                    jQuery(".bill__rows-price-total").html((totalPrice + shippingFee)
                        .toLocaleString('vi-VN', {
                            style: 'currency',
                            currency: 'VND'
                        }));
                }
                jQuery("#result").html("Bạn đã được giảm giá " + discountPercent + "%");

            }
        });
    });
    
});
</script>
