<?php
    require '../db/connect.php';
    $db = new Database(); 

?>
<div class="wrapper__product">
    <?php
    $item_per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : 3;
    $current_page = !empty($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($current_page - 1) * $item_per_page;
    if(isset($_POST['id_category'])){

        $id_category = $_POST['id_category'];
        $sql = "SELECT p.id_product, p.name AS name_product, p.img, p.price, p.quantity, mw.name AS name_wire, mg.name AS name_glass, pi.name AS name_pin, b.name AS name_brand, pd.color, pd.size, pd.origin, ca.name As name_category
                  FROM product AS p JOIN material_wire mw ON p.material_wire_id = mw.id_material_wire
                  join product_detail as pd on p.id_product = pd.id_product
                  JOIN material_glass AS mg on p.material_glass_id = mg.id_material_glass
                  JOIN pin as pi ON p.pin_id = pi.id_pin
                  JOIN brand as b ON p.brand_id = b.id_band
                  JOIN category as ca on p.category_id = ca.id_category
                  WHERE p.category_id=$id_category ORDER BY p.id_product ASC LIMIT " . $item_per_page . " OFFSET " . $offset;
        $data = $db->select($sql);
        $sql2 = "SELECT * FROM product WHERE category_id = '$id_category'";
                    $totalRecords = $db->select($sql2);
                    $totalPages = ceil(sizeof($totalRecords) / $item_per_page);
        foreach($data as $rows) { ?>

        <div class="grid__item">
            <div class="grid__item-content">
                <a href="detail.php?id_product=<?php echo $rows['id_product'];?>">
                    <div class="wrapper__product-img"><img src="imgsql/<?php echo $rows['img']?>" class="grid__item-img"
                            alt="img error" srcset=""></div>

                    <div class="grid__item-info">
                        <label class="grid__item-title"><?php echo $rows['name_category']?></label>
                        <div class="grid__item-name black"><?php echo $rows['name_product']?></div>
                        <div class="grid__item-price"><strong
                                class="red"><?php echo number_format($rows['price'],0,',','.')?>đ</strong></div>
                    </div>
            </div>
        </div>
 
    <?php } }

    else if(isset($_POST['id_band'])){

        $id_band = $_POST['id_band'];
        $sql = "SELECT p.id_product, p.name AS name_product, p.img, p.price, p.quantity, mw.name AS name_wire, mg.name AS name_glass, pi.name AS name_pin, b.name AS name_brand, pd.color, pd.size, pd.origin, ca.name As name_category
                      FROM product AS p JOIN material_wire mw ON p.material_wire_id = mw.id_material_wire
                      join product_detail as pd on p.id_product = pd.id_product
                      JOIN material_glass AS mg on p.material_glass_id = mg.id_material_glass
                      JOIN pin as pi ON p.pin_id = pi.id_pin
                      JOIN brand as b ON p.brand_id = b.id_band
                      JOIN category as ca on p.category_id = ca.id_category
                      WHERE p.brand_id=$id_band ORDER BY p.id_product ASC LIMIT " . $item_per_page . " OFFSET " . $offset;
        $data = $db->select($sql);
        $sql3 = "SELECT * FROM product WHERE product.brand_id = '$id_band'";
                $totalRecords = $db->select($sql3);
                $totalPages = ceil(sizeof($totalRecords) / $item_per_page);
        foreach($data as $rows) { ?>
    
        <div class="grid__item">
            <div class="grid__item-content">
                <a href="detail.php?id_product=<?php echo $rows['id_product'];?>">
                    <div class="wrapper__product-img"><img src="imgsql/<?php echo $rows['img']?>" class="grid__item-img"
                            alt="img error" srcset=""></div>
    
                    <div class="grid__item-info">
                        <label class="grid__item-title"><?php echo $rows['name_category']?></label>
                        <div class="grid__item-name black"><?php echo $rows['name_product']?></div>
                        <div class="grid__item-price"><strong
                                class="red"><?php echo number_format($rows['price'],0,',','.')?>đ</strong></div>
                    </div>
            </div>
        </div>
     
    <?php } }
      
    ?>
</div>
<?php
    include 'pagination.php';
    ?>