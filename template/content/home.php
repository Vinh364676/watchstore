<div id="content">
    <!-- Đồng hồ nam -->
    <div class="content__male format">
        <h3 class="content__title">ĐỒNG HỒ NAM</h3>
        <div class="wrapper__product">
            <?php
                $db = new Database();
                $sql = "SELECT p.id_product, p.name AS name_product, p.img, p.price, p.quantity, mw.name AS name_wire, mg.name AS name_glass, pi.name AS name_pin, b.name AS name_brand, pd.color, pd.size, pd.origin, ca.name As name_category
                              FROM product AS p JOIN material_wire mw ON p.material_wire_id = mw.id_material_wire
                              join product_detail as pd on p.id_product = pd.id_product
                              JOIN material_glass AS mg on p.material_glass_id = mg.id_material_glass
                              JOIN pin as pi ON p.pin_id = pi.id_pin
                              JOIN brand as b ON p.brand_id = b.id_band
                              JOIN category as ca on p.category_id = ca.id_category
                              WHERE p.category_id=1 LIMIT 3";
                $data = $db->select($sql);
                foreach($data as $rows) { ?>
            <div class="grid__item">
                <div class="grid__item-content">
                    <a href="detail.php?id_product=<?php echo $rows['id_product'];?>">
                        <div class="wrapper__product-img"><img src="imgsql/<?php echo $rows['img']?>"
                                class="grid__item-img" alt="img error" srcset=""></div>

                        <div class="grid__item-info">
                            <label class="grid__item-title"><?php echo $rows['name_category']?></label>
                            <div class="grid__item-name black"><?php echo $rows['name_product']?></div>
                            <div class="grid__item-price"><strong
                                    class="red"><?php echo number_format($rows['price'],0,',','.')?>đ</strong></div>
                        </div>
                    </a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <!-- Ưu đãi -->
    <div class="content__label" data-aos="fade-right" data-aos-duration="2000">
        <img src="assets/img/anhnengiua.jpg" class="content__label-img" alt="image error" srcset="">

        <div class="content__label-sub">
            <div class="content__label-flex">
                <i class="ti-truck content__label-icon"></i>
                <p class="content__label-desc">Miễn phí giao hàng</p>
            </div>
            <div class="content__label-flex">
                <i class="ti-gift content__label-icon"></i>
                <p class="content__label-desc">Nhiều quà tặng hấp dẫn</p>
            </div>
        </div>
    </div>

    <!-- Đồng hồ nữ -->
    <div class="content__male content__female format">
        <h3 class="content__title">ĐỒNG HỒ NỮ</h3>
        <div class="wrapper__product">
            <?php
                $db = new Database();
                $sql = "SELECT p.id_product, p.name AS name_product, p.img, p.price, p.quantity, mw.name AS name_wire, mg.name AS name_glass, pi.name AS name_pin, b.name AS name_brand, pd.color, pd.size, pd.origin, ca.name As name_category
                              FROM product AS p JOIN material_wire mw ON p.material_wire_id = mw.id_material_wire
                              join product_detail as pd on p.id_product = pd.id_product
                              JOIN material_glass AS mg on p.material_glass_id = mg.id_material_glass
                              JOIN pin as pi ON p.pin_id = pi.id_pin
                              JOIN brand as b ON p.brand_id = b.id_band
                              JOIN category as ca on p.category_id = ca.id_category
                              WHERE p.category_id=2 LIMIT 3";
                $data = $db->select($sql);
                foreach($data as $rows) { ?>
            <div class="grid__item">
                <div class="grid__item-content">
                    <a href="detail.php?id_product=<?php echo $rows['id_product'];?>">
                        <div class="wrapper__product-img"><img src="imgsql/<?php echo $rows['img']?>"
                                class="grid__item-img" alt="img error" srcset=""></div>

                        <div class="grid__item-info">
                            <label class="grid__item-title"><?php echo $rows['name_category']?></label>
                            <div class="grid__item-name black"><?php echo $rows['name_product']?></div>
                            <div class="grid__item-price"><strong
                                    class="red"><?php echo number_format($rows['price'],0,',','.')?>đ</strong></div>
                        </div>
                        </a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <!-- Thông tin khác-->
    <div class="content__male content__female content__info format">
        <h3 class="content__title" style="margin-top: 40px;">THÔNG TIN KHÁC</h3>
        <div class="content__row">
            <div class="content__column" data-aos="flip-down" data-aos-duration="2000"></div>
            <div class="content__column" data-aos="flip-down" data-aos-duration="2000"></div>
            <div class="content__column" data-aos="flip-down" data-aos-duration="2000"></div>
            <div class="content__column" data-aos="flip-down" data-aos-duration="2000"></div>
        </div>
    </div>
</div>