<?php
   // Lấy giá trị của input từ form
   $price_range = !empty($_POST['price-range']) ? $_POST['price-range'] : 1000;

   // Kết nối đến cơ sở dữ liệu
   require_once '../db/connect.php';
   $db = new Database();

   // Truy vấn để lấy danh sách sản phẩm thỏa mãn yêu cầu
   $sql = "SELECT p.id_product, p.name AS name_product, p.img, p.price, p.quantity, mw.name AS name_wire, mg.name AS name_glass, pi.name AS name_pin, b.name AS name_brand, pd.color, pd.size, pd.origin, ca.name As name_category
           FROM product AS p JOIN material_wire mw ON p.material_wire_id = mw.id_material_wire
           join product_detail as pd on p.id_product = pd.id_product
           JOIN material_glass AS mg on p.material_glass_id = mg.id_material_glass
           JOIN pin as pi ON p.pin_id = pi.id_pin
           JOIN brand as b ON p.brand_id = b.id_band
           JOIN category as ca on p.category_id = ca.id_category
           WHERE p.category_id=2 AND p.price <= $price_range ORDER BY p.id_product ASC";
   $result = $db->select($sql);

   // Hiển thị danh sách sản phẩm
   if ($result) {
        echo '<div class="wrapper__product" id="product-list">';
      foreach ($result as $row) {
         echo '<div class="grid__item">';
         echo '<div class="grid__item-content">';
         echo '<a href="detail.php?id_product=' . $row['id_product'] . '">';
         echo '<div class="wrapper__product-img"><img src="imgsql/' . $row['img'] . '" class="grid__item-img" alt="img error" srcset=""></div>';
         echo '<div class="grid__item-info">';
         echo '<label class="grid__item-title">' . $row['name_category'] . '</label>';
         echo '<div class="grid__item-name black">' . $row['name_product'] . '</div>';
         echo '<div class="grid__item-price"><strong class="red">' . number_format($row['price'], 0, ',', '.') . 'đ</strong></div>';
         echo '</div>';
         echo '</a>';
         echo '</div>';
         echo '</div>';
      }
      echo '</div>';

   } else {
      echo 'Không tìm thấy sản phẩm nào!';
   }

   // Đóng kết nối cơ sở dữ liệu
   $db->close();
?>