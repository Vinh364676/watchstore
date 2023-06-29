<?php
    session_start();
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<div class="wrapper_child">
    <div class="wrapper_content">
        <?php
                $db = new Database();
                $id_product = $_GET['id_product'];
                $sql = "SELECT p.id_product, p.name AS name_product, p.img, p.price, p.quantity, mw.name AS name_wire,
                                mg.name AS name_glass, pi.name AS name_pin, b.name AS name_brand, pd.code, pd.color, pd.size,pd.water_resistance, pd.origin, pd.description,
                                    ca.name As name_category 
                                    FROM product AS p JOIN material_wire mw ON p.material_wire_id = mw.id_material_wire
                                    join product_detail as pd on p.id_product = pd.id_product
                                    JOIN material_glass AS mg on p.material_glass_id = mg.id_material_glass
                                    JOIN pin as pi ON p.pin_id = pi.id_pin
                                    JOIN brand as b ON p.brand_id = b.id_band
                                    JOIN category as ca on p.category_id = ca.id_category 
                                    WHERE p.id_product = $id_product";
                $data = $db->select($sql);
                foreach($data as $rows) { ?>
        <div class="content__left">
            <img src="imgsql/<?php echo $rows['img']?>" class="content__left-img" data-image="<?php echo $rows['img']?>"
                alt="img error" srcset="">

            <div class="content__left-container">
                <p class="content__left-title">Thông số kỹ thuật</p>

                <div class="content__left-sub">
                    <div class="content__left-key">
                        <ul class="content__left-key-list">
                            <li class="content__left-key-child">Mã:</li>
                            <li class="content__left-key-child">Chất liệu dây:</li>
                            <li class="content__left-key-child">Chất liệu kính:</li>
                            <li class="content__left-key-child">Bộ máy & năng lượng:</li>
                            <li class="content__left-key-child">Độ chịu nước:</li>
                            <li class="content__left-key-child">Màu:</li>
                            <li class="content__left-key-child">Size mặt:</li>
                            <li class="content__left-key-child">Thương hiệu:</li>
                            <li class="content__left-key-child">Xuất xứ</li>
                        </ul>
                    </div>

                    <div class="content__left-value">
                        <ul class="content__left-key-list">
                            <li class="content__left-value-child"><?php echo  $rows["code"];?></li>
                            <li class="content__left-value-child"><?php echo  $rows["name_wire"];?></li>
                            <li class="content__left-value-child"><?php echo  $rows["name_glass"];?></li>
                            <li class="content__left-value-child"><?php echo  $rows["name_pin"];?></li>
                            <li class="content__left-value-child"><?php echo  $rows["water_resistance"];?></li>
                            <li class="content__left-value-child"><?php echo  $rows["color"];?></li>
                            <li class="content__left-value-child"><?php echo  $rows["size"];?></li>
                            <li class="content__left-value-child"><?php echo  $rows["name_brand"];?></li>
                            <li class="content__left-value-child"><?php echo  $rows["origin"];?></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        <div class="content__right">
            <label class="content__right-detail">Chi tiết sản phẩm</label>
            <p class="content__right-name" id="product-name" data-name="<?php echo $rows["name_product"];?>">
                <?php echo $rows["name_product"];?></p>
            <div class="is-divider"></div>
            <?php
                        if($rows["quantity"] > 0){
                            echo '<p>Số lượng còn lại: ' . $rows["quantity"] . '</p>';
                            echo '<p style="display: none;">Đã hết hàng</p>';
                        } else {
                            echo '<p style="display:none;">Số lượng còn lại: ' . $rows["quantity"] . '</p>';
                            echo '<p">Đã hết hàng</p>';
                        }
                  ?>
            <p class="content__right-price red" data-price="<?php echo $rows["price"];?>"><strong
                    class="red"><?php echo number_format($rows['price'],0,',','.')?>đ</strong></p>
            <p class="content__right-description"><?php echo  $rows["description"];?><br></p>
            <div class="content__right-btn">
                <div class="content__right-btn-quantity">
                    <input type="button" class="content__right-btn-minus" value="-" onclick="increaseQuantity()">
                    <input class="content__right-btn-num" style="text-align: center;" value="1" min="1"
                        max="<?php echo $rows["quantity"];?>" disabled>
                    <input type="button" class="content__right-btn-add" value="+" onclick="increaseQuantity()">
                </div>
                <?php
                    if(isset($_COOKIE['user_name'])) {
                         if($rows["quantity"] > 0){
                         ?>
                            <button id="add-to-cart-button" value="<?php echo $rows['id_product'];?>"
                            class="content__right-btn-buy test"><i style="font-style: normal;">Thêm vào giỏ</i></button>
                         <?php 
                            } else {
                                     ?>
                                     <button style="display: none;" id="add-to-cart-button" value="<?php echo $rows['id_product'];?>"
                                     class="content__right-btn-buy test"><i style="font-style: normal;">Thêm vào giỏ</i></button>
                                     <?php
                                    }
                    } else {
                        echo '<script>';
                        echo 'alert("Bạn cần đăng nhập để truy cập nội dung này.");';
                        echo '</script>'; 
                    }
                    ?>

            </div>
        </div>
        <?php  } ?>

    </div>
</div>

<script>
// Lấy phần tử input số lượng và các nút tăng/giảm số lượng
function increaseQuantity() {
    var quantityInput = document.querySelector('.content__right-btn-num');
    var minusButton = document.querySelector('.content__right-btn-minus');
    var currentQuantity = parseInt(quantityInput.value);
    var remainingQuantity = parseInt('<?php echo $rows["quantity"];?>');
    if (currentQuantity < remainingQuantity) {
        quantityInput.value = currentQuantity + 1;
        minusButton.addEventListener('click', function() {
            // Giảm giá trị số lượng xuống 1 (nếu giá trị số lượng > 1)
            if (quantityInput.value > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
            }
        });
    }
}
</script>

<script>
jQuery(document).ready(function() {
    // Lắng nghe sự kiện click nút "Thêm vào giỏ hàng"
    jQuery(".test").click(function() {
        // Lấy thông tin sản phẩm
        if (document.cookie.indexOf('user_name=') !== -1) {
            //             // Nếu cookie có tồn tại, thực hiện các hành động tương ứng ở đây
            var id_product = jQuery(this).val();
            var quantity = jQuery('.content__right-btn-num').val();
            var name = jQuery('#product-name').data('name');
            var price = jQuery('.content__right-price').data('price');
            var img = jQuery('.content__left-img').data('image');

            // Gửi yêu cầu AJAX để thêm sản phẩm vào giỏ hàng và lưu vào session
            jQuery.ajax({
                url: "add_to_cart.php",
                method: "POST",
                data: {
                    id_product: id_product,
                    quantity: quantity,
                    name: name,
                    price: price,
                    img: img
                },
                success: function(response) {
                    // Xử lý phản hồi từ server
                    alert(response);
                }
            });
        } else {
            alert("bạn phải đăng nhập trước khi mua hàng");
        }
    });
});
</script>