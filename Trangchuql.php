<?php
    session_start();
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<div id="trangchuql" class="sidebar">

    <div class="header">
        <p class="chaomung">Welcome to the admin page. Good luck to you ^^</p>
        <a class="a" id="back-button" type="button"><i class="logout1 ti-shift-right"></i></a>
    </div>

    <div class="sidebar-user">
        <img class="anh-user" src="./assets./css./Image./user1.png" alt="" width="140px">
        <p id="username" class="user"></p>
        <hr>
    </div>

    <script>
    if (document.cookie.indexOf('user_name=') !== -1) {
        // Nếu cookie có tồn tại, thực hiện các hành động tương ứng ở đây
        var user_name = document.cookie.split(';')
            .map(c => c.trim())
            .find(c => c.startsWith('user_name='))
            .split('=')[1];
        document.getElementById('username').innerHTML = '<p>' + user_name + '</p>';

        // Tạo thẻ đăng xuất và ẩn đi
        // Lấy thẻ a đã có sẵn
        var logoutLink = document.getElementById('back-button');

        // Gán đường dẫn đến trang xử lý đăng xuất cho thẻ a
        logoutLink.href = 'handle/logout.php';

        // Thêm sự kiện click để xác nhận việc đăng xuất
        logoutLink.addEventListener('click', function() {
            if (confirm('Bạn có chắc chắn muốn đăng xuất?')) {
                window.location.href = logoutLink.href;
            } else {

            }
        });

    } else {
        /* alert('Bạn chưa đăng nhập'); */
    }
    </script>
    <div class="sidebar-menu">
        <ul class="menu">
            <?php
    
    $role_id = $_COOKIE['role_id'];
    $sql = ("SELECT * FROM role_action as ra JOIN action as a on ra.id_action = a.id_action WHERE id_role = $role_id;");
    $result = $db->query($sql);
                while($rows = mysqli_fetch_array($result)){
                    ?>

            <a class="a" href="Index.php?id=<?php echo $rows['code'];?>">
                <li><i class="<?php echo $rows['icon'];?>"></i>Quản lý <?php echo $rows['name'];?></li>
            </a>

            <?php } ?>
        </ul>
    </div>

    <script>
    const menuLinks = document.querySelectorAll('.menu a');

    // Lấy thông tin về thẻ <a> đang được chọn từ localStorage
    const selectedLink = localStorage.getItem('selectedLink');

    menuLinks.forEach(link => {
        link.addEventListener('click', event => {
            // Xóa lớp 'active' khỏi tất cả các thẻ <a>
            menuLinks.forEach(link => {
                link.classList.remove('active');
            });

            // Thêm lớp 'active' vào thẻ <a> được nhấp vào
            link.classList.add('active');

            // Lưu thông tin về thẻ <a> đang được chọn vào localStorage
            localStorage.setItem('selectedLink', link.href);
        });

        // Kiểm tra nếu đây là thẻ <a> đang được chọn
        if (selectedLink === link.href) {
            // Thêm lớp 'active' vào thẻ <a> đang được chọn
            link.classList.add('active');
        }
    });
    </script>


    <!-- CHỈNH SỬA THÔNG TIN  -->
    <form class="my-table" id="form_update_product" method="post" enctype="multipart/form-data">
        <div class="modal js-modalTT">
            <div class="modal-container js-container">

                <header class="modal-header">
                    Chỉnh sửa thông tin cá nhân
                </header>

                <div class="modal-body">
                    <div class="form2">
                        <label class="labelnhanvien">Họ và tên: </label>
                        <input class="form-control" type="text">
                    </div>

                    <div class="form2">
                        <label class="labelnhanvien">Địa chỉ: </label>
                        <input class="form-control" type="text">
                    </div>

                    <div class="form2">
                        <label class="labelnhanvien">Email: </label>
                        <input class="form-control" type="text">
                    </div>

                    <div class="day-sex-chucvu">

                        <div class="form2">
                            <label class="labelnhanvien">Số điện thoại: </label>
                            <input class="form-control" type="text">
                        </div>

                        <div class="form2">
                            <label class="labelnhanvien">Giới tính: </label>
                            <div class="chon">
                                <input value="1" id="gtnam" type="radio" name="gioitinh" class="check-type"><label
                                    class="labeldonhang" for="">Nam</label>
                                <input value="2" id="gtnu" type="radio" name="gioitinh" class="check-type"><label
                                    class="labeldonhang" for="">Nữ</label>
                            </div>
                        </div>

                        <div class="form2">
                            <label class="labelnhanvien">Ngày sinh: </label>
                            <input class="form-control" type="date">
                        </div>
                    </div>

                    <div class="form2">
                        <label class="labelnhanvien">Phân loại: </label>
                        <select class="cbo" name="" id="">
                            <option value="">Nhân viên</option>
                            <option value="">Khách hàng</option>
                        </select>
                    </div>

                    <div class="form2">
                        <label class="labelnhanvien">Phân quyền : </label>
                        <select class="cbo" name="" id="">
                            <option value="">Admin</option>
                            <option value="">Quản lý</option>
                            <option value="">Nhân viên</option>
                            <option value="">Khách hàng</option>
                        </select>
                    </div>


                    <footer class="modal-footer">
                        <button id="btn-save" class="btn_save">Lưu lại</button>
                        <button id="btn-save" class="btn_close js-close">Hủy bỏ</button>
                    </footer>
                </div>
            </div>
        </div>

    </form>

    <!-- CHỈNH SỬA TÀI KHOẢN -->
    <form class="my-table" id="form_update_account" method="post" enctype="multipart/form-data">
        <div style="display: none" class="modalTK js-modalTK">
            <div class="modal-containerTK js-containerTK">

                <header class="modal-header">
                    Chỉnh sửa tài khoản
                </header>

                <div class="modal-body">
                    <div class="form2">
                        <label class="labelnhanvien">Tên đăng nhập: </label>
                        <input class="form-control" id="user_name" type="text">
                    </div>

                    <div class="form2">
                        <label class="labelnhanvien">Mật khẩu: </label>
                        <input class="form-control" id="password" type="text">
                    </div>

                    <!-- <div class="form2">
                    <label class="labelnhanvien">Nhập lại mật khẩu: </label>
                    <input class="form-control" type="text">
                </div>

                <div class="form2">
                    <label class="labelnhanvien">Ngày tạo tài khoản: </label>
                    <input class="form-control" type="date">
                </div> -->


                </div>


                <footer class="modal-footer">
                    <button id="btn-save" class="btn_save">Lưu lại</button>
                    <button id="btn-save" class="btn_close js-close-TK">Hủy bỏ</button>
                </footer>
            </div>
        </div>
    </form>

    <!-- CHỈNH SỬA THÔNG TIN ĐƠN HÀNG -->

    <div class="modalDH js-modalDH">
        <div class="modal-containerDH js-containerDH">

            <header class="modal-header">
                Chỉnh sửa thông tin đơn hàng
            </header>

            <div class="modal-bodyDH1">
                <div class="form3">
                    <label class="labelnhanvien">Nhà cung cấp: </label>
                    <select style="width: 400px; display:block;" class="cbo" name="" id="">

                    </select>
                </div>

                <div class="form3">
                    <label class="labelnhanvien">Nhân viên: </label>
                    <select style="width: 400px; display:block;" class="cbo" name="" id="">

                    </select>
                </div>
            </div>

            <div class="modal-bodyDH3">
                <div class="form3">
                    <label class="labelnhanvien">Sản phẩm: </label>
                    <select style="width: 200px; display:block;" class="cbo" name="" id="">

                    </select>
                </div>

                <div class="form3">
                    <label class="labelnhanvien">Giá gốc: </label>
                    <input style="width: 200px; display:block;" class="form-control" type="text">
                </div>

                <div class="form3">
                    <label class="labelnhanvien">Số lượng: </label>
                    <input style="width: 150px; display:block;" class="form-control" type="number" min="1">
                </div>

                <div class="form3">
                    <label class="labelnhanvien">Phần trăm: </label>
                    <input style="width: 150px; display:block;" class="form-control" type="text">
                </div>

            </div>

            <div class="modal-bodyDH4">

                <div class="form3">
                    <label class="labelnhanvien">Ngày tạo đơn hàng: </label>
                    <input style="width: 400px; display:block;" class="form-control" type="date">
                </div>

                <div class="form3">
                    <label class="labelnhanvien">Tổng tiền: </label>
                    <input style="width: 400px; display:block;" class="form-control" type="text">
                </div>
            </div>


            <footer class="modal-footer">
                <button id="btn-save" class="btn_save">Lưu lại</button>
                <button id="btn-save" class="btn_close js-close-DH">Hủy bỏ</button>
            </footer>


        </div>
    </div>




    <!-- CHỈNH SỬA THÔNG TIN SẢN PHẨM -->
    <form class="my-table" id="form_update_product" method="post" enctype="multipart/form-data">
        <div style="display: none" id="my-form" class="modalSP js-modalSP">
            <div class="modal-containerSP js-containerSP">

                <header class="modal-header">
                    Chỉnh sửa thông tin sản phẩm
                </header>

                <div class="modal-bodySP1">

                    <div class="form3">
                        <label class="labelnhanvien">Tên sản phẩm: </label>
                        <input class="form-control" type="text" id="name">
                    </div>

                    <div class="form3">
                        <label class="labelnhanvien">Mã sản phẩm: </label>
                        <input class="form-control" type="text" id="code">
                    </div>

                </div>

                <div class="modal-bodySP3">
                    <div class="form3">
                        <label class="labelnhanvien">Chất liệu dây: </label>
                        <select class="cbo" name="name_wire" id="name_wire">
                            <?php
               
               $sql = "SELECT * FROM material_wire";
               $result = $db->query($sql);
               while($rows = mysqli_fetch_array($result)){
           ?>

                            <option value="<?php echo $rows["id_material_wire"]; ?>"><?php echo $rows["name"];?>
                            </option>
                            <?php }?>
                        </select>

                    </div>

                    <div class="form3">
                        <label class="labelnhanvien">Chất liệu kính: </label>
                        <select class="cbo" name="name_glass" id="name_glass">
                            <?php
               
               $sql = "SELECT * FROM material_glass";
               $result = $db->query($sql);
               while($rows = mysqli_fetch_array($result)){
           ?>

                            <option value="<?php echo $rows["id_material_glass"]; ?>"><?php echo $rows["name"];?>
                            </option>
                            <?php }?>
                        </select>
                    </div>

                    <div class="form3">
                        <label class="labelnhanvien">Bộ máy và năng lượng: </label>
                        <select class="cbo" name="name_pin" id="name_pin">
                            <?php
               
               $sql = "SELECT * FROM pin";
               $result = $db->query($sql);
               while($rows = mysqli_fetch_array($result)){
           ?>

                            <option value="<?php echo $rows["id_pin"]; ?>"><?php echo $rows["name"];?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>

                <div class="modal-bodySP6">
                    <div class="form1">
                        <label class="labelnhanvien">Thương hiệu: </label>
                        <select class="cbo" name="name_brand" id="name_brand">
                            <?php
               
               $sql = "SELECT * FROM brand";
               $result = $db->query($sql);
               while($rows = mysqli_fetch_array($result)){
           ?>

                            <option value="<?php echo $rows["id_band"]; ?>"><?php echo $rows["name"];?></option>
                            <?php }?>
                        </select>
                    </div>

                    <div class="form1">
                        <label class="labelnhanvien">Danh mục: </label>
                        <select class="cbo" name="name_category" id="name_category">
                            <?php
               
               $sql = "SELECT * FROM category";
               $result = $db->query($sql);
               while($rows = mysqli_fetch_array($result)){
           ?>

                            <option value="<?php echo $rows["id_category"]; ?>"><?php echo $rows["name"];?></option>
                            <?php }?>
                        </select>
                    </div>


                    <div class="form1">
                        <label class="labelnhanvien">Số lượng: </label>
                        <input class="form-control" type="text" id="quantity">
                    </div>

                    <div class="form1">
                        <label class="labelnhanvien">Giới tính: </label>
                        <div class="chon">
                            <input value="1" id="gtnam" type="radio" name="gioitinh" class="check-type"><label
                                class="labeldonhang" for="">Nam</label>
                            <input value="2" id="gtnu" type="radio" name="gioitinh" class="check-type"><label
                                class="labeldonhang" for="">Nữ</label>
                        </div>
                    </div>
                </div>

                <div class="modal-bodySP4">
                    <div class="form1">
                        <label class="labelnhanvien">Xuất xứ: </label>
                        <input class="form-control" name="origin" type="text" id="origin">
                    </div>

                    <div class="form1">
                        <label class="labelnhanvien">Hình dáng: </label>
                        <input class="form-control" name="shape" type="text" id="shape">
                    </div>


                    <div class="form1">
                        <label class="labelnhanvien">Màu: </label>
                        <input class="form-control" type="text" id="color">
                    </div>

                    <div class="form1">
                        <label class="labelnhanvien">Size mặt kính: </label>
                        <input class="form-control" name="size" type="text" id="size">
                    </div>
                </div>

                <div class="modal-bodySP5">
                    <div class="form3">
                        <div>
                            <label class="labelnhanvien">Avatar:</label> <br>
                            <img id="img" src="" alt="avatar preview"> <br>
                            <input type="file" id="avatar" name="avatar">

                        </div>
                        <div>
                            <label for="removeAvatar">Remove avatar?</label>
                            <input type="checkbox" id="removeAvatar" name="removeAvatar" value="1">
                        </div>

                    </div>
                    <div class="form3">
                        <label class="labelnhanvien">Miêu tả sản phẩm: </label>
                        <p><textarea name="description" id="description" cols="40" rows="5"></textarea></p>
                    </div>

                </div>

                <footer class="modal-footer">
                    <button id="btn_save_product" class="btn_save">Lưu lại</button>
                    <button id="btn-delete" class="btn_close js-close-SP">Hủy bỏ</button>
                </footer>

            </div>
        </div>



    </form>

    <!-- CHỈNH SỬA THÔNG TIN HÓA ĐƠN -->
    <form class="my-table" id="form_update_bill" method="post" enctype="multipart/form-data">
        <div style="display: none" class="modalHD js-modalHD">
            <div class="modal-containerHD js-containerHD">

                <header class="modal-header">
                    Chỉnh sửa thông tin đơn hàng
                </header>

                <div class="modal-bodyHD1">
                    <div class="form3">
                        <label class="labelnhanvien">Tên khách hàng: </label> <br>
                        <input style="width: 200px;" class="form-control" type="text" id="fullname">
                    </div>

                    <!-- <div class="form3">
                    <label class="labelnhanvien">Tình trạng: </label>
                    <select style="width: 250px; display:block;" class="cbo" name="" id="">
                        <option value="">Đang xử lý</option>
                        <option value="">Đã hoàn thành</option>
                    </select>
                </div> -->

                    <div class="form3" style="padding-left: 20px;">
                        <label class="labelnhanvien">Tình trạng: </label>
                        <div class="chon">
                        
                            <input value="1" id="dangxuly" type="radio" name="status" class="check-type" checked>
                            <label class="labeldonhang" for="">Đang xử lý</label>
                            <input value="2" id="dahoanthanh" type="radio" name="status" class="check-type">
                            <label class="labeldonhang" for="">Đã hoàn thành</label>

                        </div>
                    </div>


                    <div class="form3">
                        <label class="labelnhanvien">Ngày tạo : </label>
                        <input id="create_date" style="display: block; width: 250px;" class="form-control" type="date">
                    </div>
                </div>

                <div class="modal-bodyHD2">
                    <div class="form3">
                        <label class="labelnhanvien">Địa chỉ giao hàng: </label>
                        <input id="deliver_address" class="form-control" type="text">
                    </div>
                </div>

                <div class="modal-bodyHD3">
                    <div class="form3">
                        <label class="labelnhanvien">Sản phẩm: </label>
                        <select style="width: 930px; display:block;" class="cbo" name="name_product_phat"
                            id="name_product_phat">
                            <?php
               
               $sql = "SELECT * FROM product";
               $result = $db->query($sql);
               while($rows = mysqli_fetch_array($result)){
           ?>
                            <option value="<?php echo $rows["id_product"]; ?>"><?php echo $rows["name"];?>
                            </option>
                            <?php }?>
                        </select>
                    </div>


                </div>

                <div class="modal-bodyHD4">
                    <div class="form3">
                        <label class="labelnhanvien">Giá bán: </label>
                        <input id="unit_price" class="form-control" type="text">
                    </div>
                    <div class="form3">
                        <label class="labelnhanvien">Số lượng: </label>
                        <input type="number" id="quantity_bill" class="form-control">
                    </div>

                    <div class="form3">
                        <label class="labelnhanvien">Voucher: </label>
                        <input id="code_bill" class="form-control" type="text">
                    </div>


                </div>


                <footer class="modal-footer">
                    <button id="btn-save" class="btn_save">Lưu lại</button>
                    <button id="btn-save" class="btn_close js-close-HD">Hủy bỏ</button>
                </footer>


            </div>
        </div>
    </form>

    <!-- CHỈNH SỬA VOUCHER -->
    <div class="modalVC js-modalVC">
        <div class="modal-containerVC js-containerVC">

            <header class="modal-header">
                Chỉnh sửa voucher
            </header>

            <div class="modal-body">
                <div class="form2">
                    <label class="labelnhanvien">Mã giảm giá: </label>
                    <input class="form-control" type="text">
                </div>

                <div class="form2">
                    <label class="labelnhanvien">Giá trị: </label>
                    <input class="form-control" type="text">
                </div>


                <div class="form2">
                    <label class="labelnhanvien">Ngày bắt đầu: </label>
                    <input class="form-control" type="date">
                </div>

                <div class="form2">
                    <label class="labelnhanvien">Ngày kết thúc: </label>
                    <input class="form-control" type="date">
                </div>


            </div>


            <footer class="modal-footer">
                <button id="btn-save" class="btn_save">Lưu lại</button>
                <button id="btn-save" class="btn_close js-close-VC">Hủy bỏ</button>
            </footer>
        </div>
    </div>


    <!-- cHỈNH SỬA THÔNG TIN NHÀ CUNG CẤP -->
    <div class="modalNCC js-modalNCC">
        <div class="modal-containerNCC js-containerNCC">

            <header class="modal-header">
                Chỉnh sửa thông tin nhà cung cấp
            </header>

            <div class="modal-body">
                <div class="form2">
                    <label class="labelnhanvien">Tên nhà cung cấp: </label>
                    <input class="form-control" type="text">
                </div>

                <div class="form2">
                    <label class="labelnhanvien">Địa chỉ: </label>
                    <input class="form-control" type="text">
                </div>

                <div class="form2">
                    <label class="labelnhanvien">Email: </label>
                    <input class="form-control" type="text">
                </div>

                <div class="form2">
                    <label class="labelnhanvien">Số điện thoại: </label>
                    <input class="form-control" type="text">
                </div>

                <div class="form2">
                    <label class="labelnhanvien">Ngày tạo: </label>
                    <input class="form-control" type="date">
                </div>


            </div>


            <footer class="modal-footer">
                <button id="btn-save" class="btn_save">Lưu lại</button>
                <button id="btn-save" class="btn_close js-close-NCC">Hủy bỏ</button>
            </footer>
        </div>
    </div>

    <div class="modalQuyen js-modalQuyen">
        <div class="modal-containerQuyen js-containerQuyen">

            <header class="modal-header">
                Chỉnh sửa thông tin Quyền
            </header>

            <div class="modal-body">
                <div class="form2">
                    <label class="labelnhanvien">Tên quyền: </label>
                    <input class="form-control" type="text">
                </div>


            </div>


            <footer class="modal-footer">
                <button id="btn-save" class="btn_save">Lưu lại</button>
                <button id="btn-save" class="btn_close js-close-Quyen">Hủy bỏ</button>
            </footer>
        </div>
    </div>



</div>
<script>
$(document).ready(function() {
    $('.check-type').change(function() {
        var status = $('input[name="status"]:checked').val();
        $.ajax({
            type: "POST",
            url: "qlHoadon.php",
            data: {
                status: status
            },
            success: function(result) {
                console.log(result);
            }
        });
    });
});
</script>