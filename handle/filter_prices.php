<?php
   // Kết nối đến cơ sở dữ liệu
   require_once "./db/connect.php";
   $db = new Database();

   // Truy vấn để lấy giá trị min/max từ cơ sở dữ liệu
   $sql = "SELECT MIN(price) AS min_price, MAX(price) AS max_price FROM product WHERE category_id = 1";
   $result = $db->select($sql);
   foreach($result as $row) {
       $min_price = $row['min_price'];
       $max_price = $row['max_price'];
   }

   // Hiển thị input type range và giá trị min/max
   echo '<input type="range" name="price-range" min="' . $min_price . '" max="' . $max_price . '" step="10" value="' . $max_price . '" oninput="showPriceRange(this.value)">';
   /* echo '<div id="price_range_value">' . $max_price . ' đ</div>'; */

   // Đóng kết nối cơ sở dữ liệu
   $db->close();
?>