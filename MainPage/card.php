<?php
require "db/connect.php";
session_start();
$db = new Database();
?>

<div id="tocard">
    <div id="wrapper">
        <div class="wrapper_child">
            <h2 class="title">Giỏ hàng</h2>
            <div class="no_cart"></div>
            <div class="grid">
                <!-- Content -->
                <div class="card">
                    <form method="post">
                        <table class="card__table">
                            <tr class="card__table-rows">
                                <th class="card__table-title"></th>
                                <th class="card__table-title">Tên sản phẩm</th>
                                <th class="card__table-title">Đơn giá</th>
                                <th class="card__table-title">Số lượng</th>
                                <th class="card__table-title">Thành tiền</th>
                                <th class="card__table-title"></th>
                            </tr>
                            <?php
      $total = 0; // Khởi tạo biến tổng tiền bằng 0
      $user_id = $_SESSION["user_id"];
      if(isset($_SESSION["cart"])) {
        foreach($_SESSION["cart"] as $item) {
            if($item["user_id"] == $user_id){

             $subtotal = $item["price"] * $item["quantity"]; // Tính tổng tiền cho từng sản phẩm
          $total += $subtotal; // Cộng tổng tiền của từng sản phẩm vào biến tổng tiền
          if(isset($total)){
            if ($total > 3000000) {
                $shippingFee = 0; // miễn phí vận chuyển
            } else {
                $shippingFee = 30000; // tính phí vận chuyển 50.000 đồng
            }
            $totalWithShipping = $total + $shippingFee;
          } else{
            $shippingFee = 0;
             $totalWithShipping = $total + $shippingFee;
          }
          
       
    ?>
                            <tr>
                                <td>
                                    <img class="img_cart" src="imgsql/<?php echo $item['img']; ?>"
                                        alt="<?php echo $item['name']; ?>">
                                </td>
                                <td><?php echo $item["name"]; ?></td>
                                <td><?php echo number_format($item["price"], 0, ",", "."); ?>đ</td>
                                <td>
                                    <input type="number" min="1" name="quantity" value="<?php echo $item['quantity']; ?>">
                                </td>

                                <td><?php echo number_format($subtotal, 0, ",", "."); ?>đ</td>
                                <td>
                                    <button type="submit"
                                        onclick="return confirm('Bạn có muốn xóa sản phẩm này ra khỏi giỏ hàng không?')"
                                        name="delete_item" value="<?php echo $item['id_product']; ?>"
                                        class="btn btn-danger btn-sm"><i class="ti-close"></i></button>
                                        <button type="submit"
                                        name="update_cart" value="<?php echo $item['id_product']; ?>"
                                        class="btn btn-danger btn-sm"><i class="ti-save"></i></button>
                                </td>
                            </tr>
                            <?php
        }
      } 
    }
    else {
        echo " <p>Giỏ hàng bạn đang trống</p>";
        
      }
    ?>
                            <?php if($total === 0): ?>

                            <style>
                            .card,
                            .bill {
                                display: none;
                            }
                            </style>

                            <?php endif; ?>

                        </table>
                    </form>
                </div>

                <div class="bill" style="margin-bottom: 40px;">
                    <div class="bill-detail">
                        <h4 class="bill-title">Tổng số lượng</h4>

                        <div class="bill__rows">
                            <p class="bill__rows-name">Tiền sản phẩm</p>
                            <b style="color: red;"
                                class="bill__rows-price"><?php echo number_format($total, 0, ',', '.'); ?>đ</b>
                        </div>
                        <div class="bill__rows">
                            <p class="bill__rows-name_">Phí vận chuyển</p>
                            <b
                                class="bill__rows-price-ship"><?php echo number_format($shippingFee, 0, ',', '.'); ?>đ</b>
                        </div>
                        <div class="bill__rows row-affect">
                            <p class="bill__rows-name">Tổng cộng</p>
                            <b
                                class="bill__rows-price totalAmount"><?php echo number_format($totalWithShipping, 0, ',', '.'); ?>đ</b>
                        </div>
                        <a href="order_from_cart.php">
                            <?php
                            if(isset($_COOKIE['user_name'])) {
                            ?>
                            <input type="button" value="ĐẶT HÀNG" class="bill-title bill-btn" />
                            <?php } else{
                                echo '<script>';
                                echo 'alert("Bạn cần đăng nhập để truy cập nội dung này.");';
                                echo '</script>'; 
                            }
                                ?>
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <?php include 'template/modal.php' ?>

</div>


<script src="assets/css/bootstrap/bootstrap-5.2.2-dist/js/bootstrap.js"></script>
<script>
AOS.init();
</script>
<script src="assets/js/index.js"></script>

<?php
if (isset($_POST["delete_item"])) {
    $item_id = $_POST["delete_item"];
    // Loop through the cart items and remove the item with the matching ID
    foreach ($_SESSION["cart"] as $index => $item) {
        if ($item["id_product"] == $item_id) {
            unset($_SESSION["cart"][$index]);
        }
    }
    ?>
<script>
window.location.href = "index1.php?id=tocard";
</script>
<?php
}
?>

<?php
   if(isset($_POST["update_cart"])) {

    $product_id = $_POST["update_cart"];
    $quantity = intval($_POST['quantity']);
    $cart_items = $_SESSION["cart"];
    $sql = "SELECT quantity FROM product WHERE id_product = $product_id";
    $result = $db->query($sql);
    $row = mysqli_fetch_assoc($result);
    $stock = $row['quantity'];
    if($quantity > $stock){
        echo "<script>alert('Số lượng sản phẩm không đủ! Chỉ còn ".$stock." sản phẩm.')</script>";
    } else {
        foreach($cart_items as &$item) {
            if($item["id_product"] == $product_id) {
                // Cập nhật số lượng sản phẩm trong giỏ hàng
                $item["quantity"] = $quantity;
                break;
            }
        }
        $_SESSION["cart"] = $cart_items;
        ?>
        <script>
            window.location.href = "index1.php?id=tocard";
        </script>
        <?php
    }
}
?>

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