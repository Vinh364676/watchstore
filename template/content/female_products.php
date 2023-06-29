<div class="c-3">
    <!-- CATEGORY -->
    <div class="category">
        <h5>DANH MỤC SẢN PHẨM</h5>
        <div class="is-divider"></div>

        <ul class="category__list">
            <?php
            $db = new Database();
            $sql = "SELECT * FROM category";
            $data = $db->select($sql);
            foreach ($data as $rows) {
                $className = "category__item";
                echo "<li class='" . $className . "' data-id='" . $rows['id_category'] . "'>" . $rows['name'] . "</li>";
            }
            ?>
        </ul>
    </div>

    <!-- BRAND -->
    <div class="category">
        <h5>THƯƠNG HIỆU</h5>
        <div class="is-divider"></div>
        <ul class="category__list scrollable-list">
            <?php
            $db = new Database();
            $sql = "SELECT * FROM brand";
            $data = $db->select($sql);
            foreach ($data as $rows) {
                $className = "brand_item";
                echo "<li class='" . $className . "' data-id='" . $rows['id_band'] . "'>" . $rows['name'] . "</li>";
            }
            ?>
        </ul>
    </div>



    <!-- PRICE -->
    <div class="category">
        <form name="filter-form" id="filter-form" method="POST" action="/handle/filter_products_female.php">
            <h5>LỌC THEO GIÁ</h5>
            <div class="is-divider"></div>
            <label for="price-range">Chọn giá sản phẩm tối đa:</label>
            <?php include './handle/filter_prices.php' ?>
            <!-- <input type="range" id="category__price-range" name="price-range" min="0" max="1000" value="500" step="10" oninput="showPriceRange(this.value)"> -->
            <div id="category__range-value"></div>
            <div>
                <button type="submit" class="category__handle">LỌC</button>
            </div>
        </form>
    </div>
</div>

<div class="c-9">
    <form id="search-form" action="/handle/search_female_handle.php" method="GET">
        <div class="">
            <input class="search-form-inp" placeholder="Nhập sản phẩm muốn tìm kiếm..." name="key-search">
            <button type="submit" class="search-form-btn">Tìm kiếm</button>
        </div>
    </form>

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
                              WHERE p.category_id=2";
        $data = $db->select($sql);
        foreach ($data as $rows) { ?>
            <div class="grid__item">
                <div class="grid__item-content">
                    <a href="detail.php?id_product=<?php echo $rows['id_product']; ?>">
                        <div class="wrapper__product-img"><img src="imgsql/<?php echo $rows['img'] ?>" class="grid__item-img" alt="img error" srcset=""></div>

                        <div class="grid__item-info">
                            <label class="grid__item-title"><?php echo $rows['name_category'] ?></label>
                            <div class="grid__item-name black"><?php echo $rows['name_product'] ?></div>
                            <div class="grid__item-price"><strong class="red"><?php echo number_format($rows['price'], 0, ',', '.') ?>đ</strong></div>
                        </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<script>
    jQuery(document).ready(function() {
        jQuery('.category__item').click(function() {
            var id_category = jQuery(this).data('id');
            var url = window.location.href.split('?')[0];
            if (id_category == 1) {
                url = url + "?id=donghonam&page=1&per_page=3"
            } else if (id_category == 2) {
                url = url + "?id=donghonu&page=1&per_page=3"
            }
            window.location = url;
            jQuery.ajax({
                url: '././Function/test.php',
                type: 'POST',
                data: {
                    id_category: id_category
                },
                success: function(data) {
                    // Hiển thị sản phẩm tương ứng trong trang web
                    jQuery('.c-9').html(data);
                }
            });
        });
    });
</script>

<script>
    jQuery(document).ready(function() {
        jQuery('.brand_item').click(function() {
            var id_band = jQuery(this).data('id');

            console.log(id_band);
            jQuery.ajax({
                url: '././Function/test.php',
                type: 'POST',
                data: {
                    id_band: id_band
                },
                success: function(data) {
                    // Hiển thị sản phẩm tương ứng trong trang web
                    jQuery('.c-9').html(data);
                }
            });
        });
    });
</script>

<!--Handle filter products  -->
<script>
    jQuery(document).ready(function() {
        jQuery('#filter-form').submit(function(e) {
            e.preventDefault(); // Ngăn chặn form gửi dữ liệu đi

            // Lấy dữ liệu từ form
            var formData = jQuery(this).serialize();

            // Gửi AJAX request đến trang xử lý
            jQuery.ajax({
                url: './handle/filter_products_female.php',
                type: 'POST',
                data: formData,
                success: function(data) {
                    // Cập nhật danh sách sản phẩm trên layout
                    jQuery('.wrapper__product').html(data);

                    
                },
            });
        });
    });
</script>

<!--Handle search products  -->
<script>
    jQuery(document).ready(function() {
        jQuery('#search-form').submit(function(e) {
            e.preventDefault();

            var data = jQuery('.search-form-inp');

            jQuery.ajax({
                url: './handle/search_female_handle.php',
                type: 'GET',
                data: data,
                success: function(data) {
                    // Cập nhật danh sách sản phẩm trên layout
                    jQuery('.wrapper__product').html(data);
                },
            });
        });
    });
</script>
<script type="text/javascript">
function fetch_data(page, limit, id) {
    jQuery.ajax({
        url: '././Function/pagination_test_female.php',
        method: "POST",
        data: {
            page: page,
            limit: limit,
            id: id
        },
        success: function(data) {

            jQuery(".wrapper__product").html(data);
        }
    });
}

fetch_data();
jQuery(document).on('click', ".page-item", function() {
    var page = jQuery(this).attr('id');
    var value = jQuery('#choose').val();
    fetch_data(page, value);
})

jQuery(document).on('change', "#choose", function() {
    var value = jQuery(this).val();
    fetch_data(1, value);
})
</script>