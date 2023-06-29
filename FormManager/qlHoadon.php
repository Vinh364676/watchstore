<div id="qlhd" class="content">

    <div class="content-header">

        <div id="clock">
        </div>

    </div>

    <div class="content-mid">

        <a href="Index.php?id=form_addhd" class="add" type="button" title="Thêm" id="add_sp"><i
                class="icon1 ti-plus"></i>Thêm hóa đơn</a>
        <!-- <a href="" class="print" type="button" title="Xuất" id=""><i class="icon1 ti-printer"></i>Xuất file Excel</a> -->
        <label class="form-timkiem" for="">Tìm kiếm:
            <input type="search" class="search"><button class="ti-search" type="button" title="Tìm kiếm" id=""></button>
        </label>

    </div>

    <div class="form-dssanpham">
        <h1>Danh sách hóa đơn</h1>
        <form method="post">
            <div class="form1 formchonloc">
                <label class="labelnhanvien">Lọc: </label>
                <select class="cbo chonloc" name="type_hd" id="type_hd" onchange="filterData()">
                    <option value=1>Đang xử lý</option>
                    <option value=2>Đã hoàn thành</option>
                </select>

            </div>
        </form>

        <table width="100%" border="3" cellspacing="2px" align="center" bordercolor="aquamarine">
            <thead>
                <tr style="height: 60px;">
                    <th width="2%">ID</th>
                    <th width="10%">Tên khách hàng</th>
                    <th width="9%">Tình trạng</th>
                    <th width="12%">Địa chỉ giao hàng</th>
                    <th width="7%">Ngày tạo</th>
                    <th width="14%">Sản phẩm</th>
                    <th width="7%">Giá bán</th>
                    <th width="6%">Số lượng</th>
                    <th width="6%">Voucher</th>
                    <th width="14%">Tổng tiền sau khi giảm</th>
                    <th width="8%">Tính năng</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <tr>
                    <?php
                    $data = $db->select("SELECT b.id_bill, b.fullname,b.total_price, b.deliver_address, b.create_date, b.user_id, bd.unit_price, p.name, bd.quantity, p.img, p.id_product, v.value, CASE WHEN b.status_bill = 2 THEN 'Đã hoàn thành' 
                     WHEN b.status_bill = 1 THEN 'Đang xử lý' 
                     ELSE 'Không rõ' END as status_display
                     FROM bill AS b 
                     JOIN bill_detail as bd ON b.id_bill = bd.id_bill
                     JOIN product as p on bd.id_product = p.id_product
                     JOIN voucher as v on b.voucher_id = v.id_voucher
                     ORDER BY id_bill ASC");
                     $db->close();
                    // $lastCode = null;
                    
                    foreach ($data as $rows){
                        ?>
                <tr data-id="<?php echo $rows["id_bill"];?>">
                    <td><?php echo $rows["id_bill"];?></td>
                    <td><?php echo $rows["fullname"];?></td>
                    <td><?php echo $rows["status_display"];?></td>
                    <td><?php echo $rows["deliver_address"];?></td>
                    <td><?php echo $rows["create_date"];?></td>
                    <td><?php echo $rows["name"];?></td>
                    <td><?php echo number_format($rows["unit_price"], 0, ',', '.'); ?>đ</td>
                    <td><?php echo $rows["quantity"];?></td>
                    <td><?php echo $rows["value"];?>%</td>
                    <td><?php echo number_format($rows["total_price"], 0, ',', '.'); ?>đ</td>
                    <td align="center">
                        <?php if ($rows['status_display'] == "Đã hoàn thành"): ?>
                        <button style="display: none;" type="button" name="btn_delete"
                            data-id="<?php echo $rows['id_bill'];?>" class="tinhnang1 js-change-sanpham-delete"
                            title="Xóa" id="btn_delete">
                            <i class="icon1 ti-trash"></i>
                        </button>
                        <button style="display: none;" value="<?php echo $rows['id_bill'];?>"
                            class="tinhnang2 js-change-hoadon" name="submit_edit" type="submit" title="Sửa"
                            id="btn_update">
                            <i class="icon1 ti-marker-alt"></i>
                        </button>
                        <?php else: ?>
                        <button style="display: none;" type="button" name="btn_delete"
                            data-id="<?php echo $rows['id_bill'];?>" class="tinhnang1 js-change-sanpham-delete"
                            title="Xóa" id="btn_delete">
                            <i class="icon1 ti-trash"></i>
                        </button>
                        <button value="<?php echo $rows['id_bill'];?>" class="tinhnang2 js-change-hoadon"
                            name="submit_edit" type="submit" title="Sửa" id="btn_update">
                            <i class="icon1 ti-marker-alt"></i>
                        </button>
                        <?php endif; ?>
                    </td>


                </tr>

                <?php }
                         ?>

                </tr>



            </tbody>
        </table>

    </div>

    <div class="footer">
        <a href="Index.php?id=qlvc" class="add" type="button" title="Voucher" id="">Quản lý voucher <i
                class="icon1 ti-hand-point-right"></i></a>
    </div>

</div>



<script>
$(document).ready(function() {
    $('.tinhnang2').click(function() {
        $('.js-modalHD').css('display', 'flex').show();
        var id_bill = $(this).val();
        console.log(id_bill);
        $.ajax({
            url: 'Function/get_data.php',
            type: 'GET',
            data: {
                id_bill: id_bill
            },
            success: function(data) {
                var createDate = data.create_date.split(" ")[0]; // tach lay ngay
                // Gán giá trị dữ liệu cho các trường trong form cập nhật
                $('#fullname').val(data.fullname);
                $('#create_date').val(createDate);
                $('#deliver_address').val(data.deliver_address);
                $('#unit_price').val(data.unit_price);
                $('#quantity_bill').val(data.quantity);
                $('#code_bill').val(data.code);
                $('#form_update_bill').data('id',
                    id_bill); // Định nghĩa giá trị id_product trong form
                console.log(data);
            }
        });
    });
    $('.btn_save').click(function(event) {

        var fullname = $('#fullname').val();
        var create_date = $('#create_date').val();
        var deliver_address = $('#deliver_address').val();
        var unit_price = $('#unit_price').val();
        var quantity = $('#quantity_bill').val();
        var code = $('#code_bill').val();
        var status = $('input[name=status]:checked').val();

        event.preventDefault();
        var id_bill = $('#form_update_bill').data('id'); // Lấy giá trị id_product từ form

        var tr = $('tr[data-id="' + id_bill + '"]');
        console.log(tr);
        $.ajax({
            url: 'Function/save_data.php',
            type: 'POST',
            dataType: 'json',
            data: {
                id_bill: id_bill,
                fullname: fullname,
                create_date: create_date,
                deliver_address: deliver_address,
                unit_price: unit_price,
                quantity: quantity,
                code: code,
                status_bill: status
            },
            success: function(data) {
                console.log(data);
                // window.location.href = 'Index.php?id=qlsp';
                $('#form_update_bill').hide();
                var updatedData = data;
                var statusText;
                if (updatedData.status_bill === '1') {
                    statusText = "Đang xử lý";
                } else if (updatedData.status_bill === '2') {
                    statusText = "Đã hoàn thành";
                } else {
                    statusText = "";
                }

                tr.find('td').eq(2).text(statusText);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error: ' + errorThrown);
            }
        });

    });
});
</script>

<script>
function filterData() {
    var value = $('#type_hd').val(); // lấy giá trị của thẻ select
    console.log(value);
    $.ajax({
        type: "POST", // phương thức gửi dữ liệu
        url: "filter.php", // đường dẫn xử lý dữ liệu
        data: {
            type_hd: value
        }, // dữ liệu gửi đi (giá trị của thẻ select)
        success: function(data) {
            console.log(data);
            $('#table-body').html(data);
        }
    });
}
</script>