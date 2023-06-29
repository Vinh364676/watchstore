<?php
  // Bắt đầu session
  session_start();
  $user_id = $_SESSION["user_id"];
 // Lấy thông tin sản phẩm từ biến POST
$id_product = $_POST["id_product"];
$quantity = $_POST["quantity"];
$price = $_POST["price"];
$name = $_POST["name"];
$img = $_POST["img"];

// Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
if (!isset($_SESSION["cart"])) {
  $_SESSION["cart"] = array();
}

$productExists = false;
foreach ($_SESSION["cart"] as &$product) {
  if ($product["id_product"] == $id_product && $product["user_id"] == $user_id) {
    $product["quantity"] += $quantity;
    $productExists = true;
    break;
  }
}

if (!$productExists) {
  $_SESSION["cart"][] = array(
    "id_product" => $id_product,
    "name" => $name,
    "price" => $price,
    "quantity" => $quantity,
    "img" => $img,
    "user_id" => $user_id
  );
}

  // Trả về thông báo thành công cho phía client
  echo "Sản phẩm đã được thêm vào giỏ hàng thành công!";
?>