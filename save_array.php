<?php
    session_start();
    print_r($_SESSION["user_new"]);
    print_r($_SESSION["role_id"]);
    echo 'Giá trị của cookie name là: ' . $_COOKIE['name'];
?>
<?php
    // if (isset($_POST['update_cart'])) { // Kiểm tra nếu đã submit form
    //     foreach ($_SESSION["cart"] as &$item) {
    //         if ($item["user_id"] == $user_id) {
    //             $new_quantity = $_POST["quantity_{$item['id_product']}"];
    //             $item["quantity"] = $new_quantity; // Cập nhật số lượng
    //         }
    //     }
    //     print_r($_SESSION["cart"]);
    // }
    
    
        // Lưu lại mảng sản phẩm mới vào session
      
        // Chuyển hướng người dùng trở lại trang sản phẩm
        // header('Location: product.php');
        // exit;
    
?>