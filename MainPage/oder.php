<?php require_once "db/connect.php" ?>
div <div id="pay_cart">

    <div id="wrapper">
        <div class="wrapper_child order-flex">
            <!-- Content -->
            <div class="info">
                <h2 class="info__title">Thông tin thanh toán</h2>

                <div class="info__rows">
                    <label for="" class="info__rows-label">Họ tên *</label><br>
                    <input class="info__rows-input" type="text">
                </div>

                <div class="info__rows">
                    <label for="" class="info__rows-label">Địa chỉ *</label>
                    <input class="info__rows-input" type="text">
                </div>

                <div class="info__rows">
                    <label for="" class="info__rows-label">Số điện thoại *</label>
                    <input class="info__rows-input" type="text">
                </div>

                <div class="info__rows">
                    <label for="" class="info__rows-label">Email *</label>
                    <input class="info__rows-input" type="text">
                </div>

                <div class="info__rows">
                    <label for="" class="info__rows-label">Ghi chú đơn hàng *</label>
                    <input class="info__rows-input info__rows-input-more" type="text" placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn." autofocus>
                </div>

            </div>

            <div class="bill">
                <div class="bill-detail">
                    <h4 class="bill-title">Tổng số lượng</h4>

                    <div class="bill__rows">
                        <p class="bill__rows-name">Tiền sản phẩm</p>
                        <b class="bill__rows-price">1000000</b>
                    </div>

                    <div class="bill__rows">
                        <p class="bill__rows-name">Phí vận chuyển</p>
                        <b class="bill__rows-price">60000</b>
                    </div>

                    <p class="bill__rows-name">Mã giảm giá</p>

                    <input>

                    <div class="bill__rows row-affect">
                        <p class="bill__rows-name">Tổng cộng</p>
                        <b class="bill__rows-price">2000000</b>
                    </div>

                    <div>
                        <input type="checkbox" class="">
                        <span>Thanh toán khi nhận hàng</span>
                    </div>

                    <input type="button" value="ĐẶT HÀNG" class="bill-title bill-btn" />
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php include 'template/footer.php' ?>
    </div>
    
    </div>
    <!-- Modal -->
    <?php include 'template/modal.php' ?>

    <script src="assets/css/bootstrap/bootstrap-5.2.2-dist/js/bootstrap.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="assets/js/index.js"></script>
</body>
