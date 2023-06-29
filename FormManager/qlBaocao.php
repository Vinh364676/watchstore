<?php
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if(isset($_POST['locbaocao'])){
        $_SESSION['savedaystart'] = $_POST['day_start'];
        $_SESSION['savedayend'] = $_POST['day_end'];
    }
    else if(isset($_POST['locbaocao2'])){
        $_SESSION['savestart'] = $_POST['start'];
        $_SESSION['saveend'] = $_POST['end'];
    }
    else if(isset($_POST['locbaocao3'])){
        $_SESSION['savestart_day'] = $_POST['start_day'];
        $_SESSION['saveend_day'] = $_POST['end_day'];
    }
?>

<div id="qlbc" class="content">

    <div class="content-header">

        <div id="clock">
        </div>

    </div>

    <div class="content-mid">
        
        <a href="" class="print" type="button" title="Xuất" id=""><i class="icon1 ti-printer"></i>Xuất file Excel</a>


    </div>

    <div class="form-doanhthu">
        
        <h1 style="color: red;" >Báo cáo doanh thu</h1>

        <table  width="100%" border="3" cellspacing="2px" align="center" bordercolor = "blue">
            <thead>
                <tr style="height: 60px;">
                    <th width="8%">Tổng sản phẩm</th>
                    <th width="8%">Tồn hàng</th>
                    <th width="8%">Hết hàng</th>
                    <th width="8%">Tổng nhân viên</th>
                    <th width="8%">Tổng khách hàng</th>
                    <th width="8%">Tổng nhà cung cấp</th>
                    <th width="8%">Tổng đơn hàng nhập</th>
                    <th width="8%">Tổng hóa đơn</th>
                    <th width="10%">Tổng đơn đang xử lý</th>
                    <th width="10%">Tổng đơn đã hoàn thành</th>
                    <th width="8%">Tổng chi</th>
                    <th width="8%">Tổng thu</th>
            </thead>
            <tbody>
                <tr>
                <?php
              
                $sql = "SELECT 'sumsanpham' as `type`, COUNT(*) AS `count` FROM `product`
                        UNION
                        SELECT 'tonhang' as `type`, COUNT(*) AS `count` FROM `product` where `quantity` > 0
                        UNION
                        SELECT 'hethang' as `type`, COUNT(*) AS `count` FROM `product` where `quantity` = 0
                        UNION
                        SELECT 'sumnhanvien' AS `type`, COUNT(*) AS `count` FROM `user` WHERE `type` = '1'
                        UNION
                        SELECT 'sumkhachhang' AS `type`, COUNT(*) AS `count` FROM `user` WHERE `type` = '2'
                        UNION
                        SELECT 'sumncc' as `type`, COUNT(*) AS `count` FROM `supplier`
                        UNION
                        SELECT 'sumdonhang' as `type`, COUNT(*) AS `count` FROM `receipt`
                        UNION
                        SELECT 'sumhoadon' as `type`, COUNT(*) AS `count` FROM `bill`
                        UNION
                        SELECT 'sumdangxuly' as `type`, COUNT(*) AS `count` FROM `bill` where `status_bill` = '1'
                        UNION
                        SELECT 'sumdahoanthanh' as `type`, COUNT(*) AS `count` FROM `bill` where `status_bill` = '2'
                        UNION
                        SELECT 'tongchi' as `type`, sum(total) AS `count` FROM `receipt`
                        UNION
                        SELECT 'tongthu' as `type`, sum(total_price) AS `count` FROM `bill`
                        ;";
                $result = $db->query($sql);

                while($rows = mysqli_fetch_array($result)){
                ?>
              
                <tr align="center" style="height: 60px;">
                    <?php
                    foreach ($result as $row) {
                        if ($row['type'] == 'sumsanpham') {
                            echo "<td>".$row['count']."</td>";
                            $tongsp = $row['count'];
                        } elseif ($row['type'] == 'tonhang') {
                            echo "<td>".$row['count']."</td>";
                            $tonhang = $row['count'];
                        } elseif ($row['type'] == 'hethang') {
                            echo "<td>".$row['count']."</td>";
                            $hethang = $row['count'];
                        } elseif ($row['type'] == 'sumnhanvien') {
                            echo "<td>".$row['count']."</td>";
                            $tongnv = $row['count'];
                        } elseif ($row['type'] == 'sumkhachhang') {
                            echo "<td>".$row['count']."</td>";
                            $tongkh = $row['count'];
                        } elseif ($row['type'] == 'sumncc') {
                            echo "<td>".$row['count']."</td>";
                            $tongncc = $row['count'];
                        } elseif ($row['type'] == 'sumdonhang') {
                            echo "<td>".$row['count']."</td>";
                            $tongdh = $row['count'];
                        } elseif ($row['type'] == 'sumhoadon') {
                            echo "<td>".$row['count']."</td>";
                            $tonghd = $row['count'];
                        } elseif ($row['type'] == 'sumdangxuly') {
                            echo "<td>".$row['count']."</td>";
                            $tongdangxuly = $row['count'];
                        } elseif ($row['type'] == 'sumdahoanthanh') {
                            echo "<td>".$row['count']."</td>";
                            $tongdahoanthanh = $row['count'];
                        } elseif ($row['type'] == 'tongchi') {
                            // number_format($row['count'], 0, ',', '.');
                            echo "<td>".number_format($row['count'], 0, ',', '.')."</td>";
                            $tongchi = $row['count'];
                        } elseif ($row['type'] == 'tongthu') {
                            echo "<td>".number_format($row['count'], 0, ',', '.')."</td>";
                            $tongthu = $row['count'];
                        }
                        }
                    ?>
                </tr>
            
                <?php } ?>
              
                </tr>
                
            </tbody>

        </table>

    </div>

    <div class="form-baocao">
        <div class="one icon"><i class="icon2 ti-package" ></i>
            <div class="tonghop">
                <h4>Tổng sản phẩm</h4>
                <p class="chiso"><b><?php echo $tongsp; ?></b><b> Sản phẩm</b></p>
            </div>
        </div>
        <div class="one icon"><i class="icon2 ti-face-smile" ></i>
            <div class="tonghop">
                <h4>Tồn hàng</h4>
                <p class="chiso"><b><?php echo $tonhang; ?></b><b> Sản phẩm</b></p>
            </div>
        </div>

        <div class="one icon"><i class="icon2 ti-face-sad" ></i>
            <div class="tonghop">
                <h4>Hết hàng</h4>
                <p class="chiso"><b><?php echo $hethang; ?></b><b> Sản phẩm</b></p>
            </div>
        </div>

        <div class="two icon"><i class="icon2 ti-briefcase" ></i>
            <div class="tonghop">
                <h4>Tổng nhân viên</h4>
                <p class="chiso"><b><?php echo $tongnv; ?></b><b> Nhân viên</b></p>
            </div>
        </div>

        <div class="two icon"><i class="icon2 ti-user" ></i>
            <div class="tonghop">
                <h4>Tổng khách hàng</h4>
                <p class="chiso"><b><?php echo $tongkh; ?></b><b> Khách hàng</b></p>
            </div>
        </div>

        <div class="two icon"><i class="icon2 ti-crown" ></i>
            <div class="tonghop">
                <h4>Tổng nhà cung cấp</h4>
                <p class="chiso"><b><?php echo $tongncc; ?></b><b> Nhà cung cấp</b></p>
            </div>
        </div>

        <div class="four icon"><i class="icon2 ti-shopping-cart-full" ></i>
            <div class="tonghop">
                <h4>Tổng hóa đơn </h4>
                <p class="chiso"><b><?php echo $tonghd; ?></b><b> Hóa đơn</b></p>
            </div>
        </div>

        <div class="four icon"><i class="icon2 ti-package" ></i>
            <div class="tonghop">
                <h4>Tổng đơn đang xử lý</h4>
                <p class="chiso"><b><?php echo $tongdangxuly; ?></b><b> Đơn hàng</b></p>
            </div>
        </div>

        <div class="four icon"><i class="icon2 ti-check-box" ></i>
            <div class="tonghop">
                <h4>Tổng đơn đã hoàn thành</h4>
                <p class="chiso"><b><?php echo $tongdahoanthanh; ?></b><b> Đơn hàng</b></p>
            </div>
        </div>

        <div class="three icon"><i class="icon2 ti-archive" ></i>
            <div class="tonghop">
                <h4>Tổng đơn hàng nhập </h4>
                <p class="chiso"><b><?php echo $tongdh; ?></b><b> Đơn hàng</b></p>
            </div>
        </div>

        <div class="three icon"><i class="icon2 ti-wallet" ></i>
            <div class="tonghop">
                <h4>Tổng chi </h4>
                <p class="chiso"><b><?php echo number_format($tongchi, 0, ',', '.');?></b><b> đồng</b></p>
            </div>
        </div>

        <div class="three icon"><i class="icon2 ti-server" ></i>
            <div class="tonghop">
                <h4>Tổng thu nhập</h4>
                <p class="chiso"><b><?php echo number_format($tongthu, 0, ',', '.'); ?></b><b> đồng</b></p>
            </div>
        </div>

        

    </div>

<form method="post"enctype="multipart/form-data">
    <div class="spbanchay">

        <h1 class="title">Top Sản phẩm bán chạy</h1>

        <div class="day-sex-chucvu" style="margin-left: 10px">
            <div class="form2">
                <label class="labelnhanvien">Từ ngày: </label>
                <input id="day_start" name="day_start" style="border: 3px solid pink;" class="form-control" type="date"
                    value="<?php echo isset($_SESSION['savedaystart']) ? $_SESSION['savedaystart'] : ''; ?>">
            </div>
            <div class="form2">
                <label class="labelnhanvien">Đến ngày: </label>
                <input id="day_end" name="day_end" style="border: 3px solid pink;" class="form-control" type="date"
                    value="<?php echo isset($_SESSION['savedayend']) ? $_SESSION['savedayend'] : ''; ?>">
            </div>
            <div class="form2">
                <label class="labelnhanvien">Top: </label>
                <input id="top" name="top" style="border: 3px solid pink;" class="form-control" type="input">
            </div>
            <div class="form2">
                
                <button style="border-radius: 25px; background: pink; border: pink;" 
                    type="button" name="locbaocao" href="" class="add-sanpham filter_topsp" title="Lưu" value="loc_baocao1" id="btn_locbaocao1">
                    <i class="icon1 ti-reload"></i>Thống kê</button>
            </div>
        </div>

        <div class="spbanchay1">
            <table  width="100%" border="3" cellspacing="2px" align="center" bordercolor = "pink">
                <thead>
                    <tr style="height: 60px;">
                        <th width="5%">TOP</th>
                        <th width="5%">IDSP</th>
                        <th width="45%">Tên sản phẩm</th>
                        <th width="15%">Số lượng đã bán</th>
                        <th width="15%">Số lượng còn lại</th>
                        <th width="15%">Giá bán</th>
                    </tr>
                </thead>
                <tbody id="table_baocao">
                <tr>
            
              
              </tr>
                
                
            </tbody>

            </table>

        </div>

        
    </div>
</form>

<form method="post"enctype="multipart/form-data">
    
    <div class="khachhangtiemnang">
        
        <h1 class="title">Tình hình kinh doanh của sản phẩm</h1>

        <div class="day-sex-chucvu" style="margin-left: 10px">
            <div class="form2">
                <label class="labelnhanvien">Từ ngày: </label>
                <input id="start" name="start" style="border: 3px solid pink;" class="form-control" type="date"
                    value="<?php echo isset($_SESSION['savestart']) ? $_SESSION['savestart'] : ''; ?>">
            </div>
            <div class="form2">
                <label class="labelnhanvien">Đến ngày: </label>
                <input id="end" name="end" style="border: 3px solid pink;" class="form-control" type="date"
                    value="<?php echo isset($_SESSION['saveend']) ? $_SESSION['saveend'] : ''; ?>">
            </div>
            <!-- <div class="form2">
                <label class="labelnhanvien">Top: </label>
                <input name="tops" style="border: 3px solid pink;" class="form-control" type="input">
            </div> -->
            <div class="form2">
                <label class="labelnhanvien">Thương hiệu: </label>

                <select style="border: 3px solid pink;" class="cbo" name="id_band" id="brand">
                    <?php
                        $sql = "SELECT * FROM brand";
                        $result = $db->query($sql);
                        while($rows = mysqli_fetch_array($result)){
                    ?>
                        <option value="<?php echo $rows["id_band"]; ?>"><?php echo $rows["name"];?></option>
                        <?php }?>
                        <option value="all">Tất cả</option>
                </select>
            </div>
            <div class="form2">
                <button style="border-radius: 25px; background: pink; border: pink;" 
                    type="button" name="locbaocao2" href="" class="add-sanpham filter_kinhdoanh"  title="Lưu" value="loc_baocao2" id="btn_locbaocao2">
                    <i class="icon1 ti-reload"></i>Thống kê</button>
            </div>
        </div>

        <div class="spbanchay1">
            <table  width="100%" border="3" cellspacing="2px" align="center" bordercolor = "pink">
                <thead>
                    <tr style="height: 60px;">
                        <th width="5%">Thứ tự</th>
                        <th width="5%">IDSP</th>
                        <th width="30%">Tên sản phẩm</th>
                        <th width="10%">Thương hiệu</th>
                        <th width="15%">Số lượng đã bán</th>
                        <th width="10%">Ngày bán</th>
                        <th width="10%">Giá bán</th>
                        <th width="15%">Khách hàng đã mua</th>
                    </tr>
                </thead>
                <tbody id="table_baocao2">
                <tr>
            
              
              </tr>
                    
                </tbody>
            </table>

        </div>
        
    </div>
</form>

<form method="post"enctype="multipart/form-data">
    
    <div class="khachhangtiemnang">
        
        <h1 class="title">Xem đơn hàng trong khoảng thời gian</h1>

        <div class="day-sex-chucvu" style="margin-left: 10px">
            <div class="form2">
                <label class="labelnhanvien">Từ ngày: </label>
                <input id="start_day" name="start_day" style="border: 3px solid pink;" class="form-control" type="date"
                    value="<?php echo isset($_SESSION['savestart_day']) ? $_SESSION['savestart_day'] : ''; ?>">
            </div>
            <div class="form2">
                <label class="labelnhanvien">Đến ngày: </label>
                <input id="end_day" name="end_day" style="border: 3px solid pink;" class="form-control" type="date"
                    value="<?php echo isset($_SESSION['saveend_day']) ? $_SESSION['saveend_day'] : ''; ?>">
            </div>
            <div class="form2">
                <label class="labelnhanvien">Tình trạng: </label>

                <select style="border: 3px solid pink;" class="cbo" name="tinhtrang" id="tinhtrang_status">
                    <option value="2" >Đã hoàn thành</option>
                    <option value="1" >Đang xử lý</option>
                </select>
            </div>
            <!-- <div class="form2">
                <label class="labelnhanvien">Tổng đơn hàng: </label>
                <input name="tops" style="border: 3px solid pink;" class="form-control" type="input">
            </div> -->
            
            <div class="form2">
                <button style="border-radius: 25px; background: pink; border: pink;" 
                    type="button" name="locbaocao3" href="" class="add-sanpham filter_status_bill" title="Lưu" value="loc_baocao3" id="btn_locbaocao3">
                    <i class="icon1 ti-reload"></i>Thống kê</button>
            </div>
        </div>

        <div class="spbanchay1">
            <table  width="100%" border="3" cellspacing="2px" align="center" bordercolor = "pink">
                <thead>
                    <tr style="height: 60px;">
                        <th width="5%">Thứ tự</th>
                        <th width="10%">Đơn hàng</th>
                        <th width="15%">Tình trạng</th>
                        <th width="20%">Ngày tạo</th>
                        <th width="15%">Tổng tiền</th>
                        <th width="20%">Khách hàng đã mua</th>
                    </tr>
                </thead>
                <tbody id="table_baocao3">
                
                <tr>
                </tr>
                    
                </tbody>
            </table>

        </div>
        
    </div>
</form>


</div>

<script>
$(document).ready(function() {
    $('.filter_topsp').click(function() {
        var top = $('#top').val();
        var day_start = $('#day_start').val();
        var day_end = $('#day_end').val();
        var id_1 = $('#btn_locbaocao1').val();
        
        console.log(top);
        console.log(day_start);
        console.log(day_end);
        $.ajax({
            url: 'xulybaocao.php',
            type: 'POST',
            data: {
                top: top,
                day_start: day_start,
                day_end: day_end,
                id_1 : id_1
            },
            success: function(data) {
                // Gán giá trị dữ liệu cho các trường trong form cập nhật
                console.log(data);
            $('#table_baocao').html(data);
            }
        });
    });
});
</script>

<script>
$(document).ready(function() {
    $('.filter_kinhdoanh').click(function() {
        var brand = $('#brand').val();
        var start = $('#start').val();
        var end = $('#end').val();
        var id_2 = $('#btn_locbaocao2').val();
        
        console.log(brand);
        console.log(start);
        console.log(end);
        $.ajax({
            url: 'xulybaocao.php',
            type: 'POST',
            data: {
                brand: brand,
                start: start,
                end: end,
                id_2 : id_2
            },
            success: function(data) {
                // Gán giá trị dữ liệu cho các trường trong form cập nhật
                console.log(data);
            $('#table_baocao2').html(data);
            }
        });
    });
});
</script>

<script>
$(document).ready(function() {
    $('.filter_status_bill').click(function() {
        var value = $('#tinhtrang_status').val();
        var start_day = $('#start_day').val();
        var end_day = $('#end_day').val();
        var id_3 = $('#btn_locbaocao3').val();
        
        console.log(value);
        console.log(start_day);
        console.log(end_day);
        $.ajax({
            url: 'xulybaocao.php',
            type: 'POST',
            data: {
                value: value,
                start_day: start_day,
                end_day: end_day,
                id_3 : id_3

            },
            success: function(data) {
                // Gán giá trị dữ liệu cho các trường trong form cập nhật
                console.log(data);
            $('#table_baocao3').html(data);
            }
        });
    });
});
</script>
