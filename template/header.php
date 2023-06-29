<header id="header">
    <!-- Nav Mobile -->
    <label class="header__col header__col-icon" for="checked-inp">
        <i class="ti-align-justify header__col-icon-list"></i>
    </label>

    <input type="checkbox" id="checked-inp">
    <label for="checked-inp" id="overlay"></label>
    <div class="nav-mobile">
        <div class="nav-close">
            <label for="checked-inp" class="ti-close"></label>
        </div>
        <ul class="list-mobile">
            <a href="index1.php?pg=trangchu" class="list-link">
                <li class="item-mobile">Trang chủ</li>
            </a>
            <a href="index1.php?pg=id=donghonam&page=1&per_page=3" class="list-link">
                <li class="item-mobile">Đồng hồ nam</li>
            </a>
            <a href="index1.php?pg=donghonu&page=1&per_page=3" class="list-link">
                <li class="item-mobile">Đồng hồ nữ</li>
            </a>
            <a href="index1.php?id=lienhe" class="list-link">
                <li class="item-mobile">Liên hệ</li>
            </a>

            <li class="header__list__item-user">
                <a style="color: inherit; text-decoration: none;" class="header__list__item item-mobile" href="../history_cart.php">Lịch sử đơn hàng</a>
            </li>
            <li class="header__list__item">
                <a style="color: inherit; text-decoration: none;" class="header__list__item a_madal item-mobile" href="./handle/logout.php">Đăng xuất</a>
            </li>
        </ul>
    </div>

    <!-- Nav PC -->
    <img src="assets./img/chulogo.png " alt="image error " class="header__logo " srcset=" ">

    <div class="header__col">
        <ul class="header__nav">
            <li class="header__nav-item" data-aos="zoom-in-down" data-aos-duration="2000"><a href="index1.php?id=gioithieu" class="header__nav-link">GIỚI THIỆU</a></li>
            <li class="header__nav-item header__nav-list" data-aos="zoom-in-down" data-aos-duration="2000"><a href="index1.php?id=dongho" class="header__nav-link header__nav-relative">ĐỒNG HỒ</a>
                <!-- <ul class="header__list">
                    <li class="header__list__item">Dây Da Hirsch</li>
                    <li class="header__list__item">Dây Da SRC</li>
                    <li class="header__list__item">Hộp Đồng Hồ</li>
                    <li class="header__list__item">D.vụ In Logo Lên Đồng Hồ</li>
                    <li class="header__list__item">Khắc Laser Lên Đồng Hồ</li>
                </ul> -->
            </li>
            <li class="header__nav-item" data-aos="zoom-in-down" data-aos-duration="2000"><a href="index1.php?id=donghonam" class="header__nav-link">ĐỒNG HỒ NAM</a></li>
            <li class="header__nav-item" data-aos="zoom-in-down" data-aos-duration="2000"><a href="index1.php?id=donghonu" class="header__nav-link dhn">ĐỒNG HỒ NỮ</a></li>
            <li class="header__nav-item " data-aos="zoom-in-down" data-aos-duration="2000"><a href="index1.php?id=lienhe" class="header__nav-link-spe">LIÊN HỆ</a></li>
        </ul>
    </div>

    <div class="header__col header__col-res">
       
        <a href="index1.php?id=tocard" style="color: white;"><i style="color: white;" class="header__icon-item ti-shopping-cart header__icon-item-cart" data-aos="zoom-in" data-aos-duration="2000"></i></a>
        <?php
    // Lấy thông tin giỏ hàng từ session và tính tổng số lượng sản phẩm
    $cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
    $cart_count = 0;
    foreach ($cart_items as $item) {
        $cart_count += $item['quantity'];
    }
    if ($cart_count !== 0) {
        echo "<span>$cart_count</span>";
    }
?>
        <div div class="header__col-item-format">
            <i id="login-icon" class="header__icon-item header__item-login ti-user header__col-res-none" data-aos="zoom-in" data-aos-duration="2000"></i>
       
            <li style="list-style-type: none;" id="username" class="header__nav-item header__nav-list " data-aos="zoom-in-down" data-aos-duration="2000">
            </li>
        </div>
    </div>
</header>


