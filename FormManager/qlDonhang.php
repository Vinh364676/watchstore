
<div id="qldh" class="content">

    <div class="content-header">

        <div id="clock"></div>
        
    </div>

    <div class="content-mid">
        
        <a href="Index.php?id=form_adddh" class="add" type="button" title="Thêm" id="add_dh"><i class="icon1 ti-plus"></i>Thêm đơn hàng</a>
        <!-- <a href="" class="print" type="button" title="Xuất" id=""><i class="icon1 ti-printer"></i>Xuất file Excel</a> -->
        <label class="form-timkiem" for="">Tìm kiếm: 
            <input type="search" id="search_oder" class="search"><button class="ti-search" type="button" title="Tìm kiếm" id="" ></button>
        </label>

    </div>

    <div class="form-dsdonhang">
        
        <h1>Danh sách đơn hàng nhập</h1>

        <div class="form1 formchonloc">
            <label class="labelnhanvien">Lọc: </label>
            <select class="cbo chonloc" name="type" id="">
                <option>Theo thứ tự từ a -> z</option>
                <option>Theo thứ tự từ z -> a</option>
            </select>
        </div>

        <table id="table_data_oder" width="100%" border="3" cellspacing="2px" align="center" bordercolor = "aquamarine">
            <thead>
                <tr style="height: 60px;">
                    <th width="2%">ID</th>
                    <th width="18%">Nhà cung cấp</th>
                    <th width="12%">Nhân viên</th>
                    <th width="8%">Tổng tiền</th>
                    <th width="20%">Sản phẩm</th>
                    <th width="8%">Số lượng</th>
                    <th width="8%">Giá gốc</th>
                    <th width="8%">Phần trăm</th>
                    <th width="8%">Ngày tạo</th>
                    <th width="8%">Tính năng</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <?php
                $data  = $db->select("SELECT s.name as nameNCC, us.name as nameNV, re.total, p.name as nameSP, d.quantity, d.price, d.percent, re.create_date, re.id_receipt 
                FROM receipt as re join supplier as s on s.id_supplier = re.supplier_id
                                    join user as us on us.id_user = re.user_id
                                    join receipt_detail as d on d.receipt_id = re.id_receipt
                                    join product as p on p.id_product = d.product_id"
                );
                $db->close();
                foreach ($data as $rows){
                ?>
                <tr>
                    <td><?php echo $rows["id_receipt"];?></td>
                    <td><?php echo $rows["nameNCC"];?></td>
                    <td><?php echo $rows["nameNV"];?></td>
                    <td><?php echo number_format($rows['total'],0,',','.')?></td>
                    <td><?php echo $rows["nameSP"];?></td>
                    <td><?php echo $rows["quantity"];?></td>
                    <td><?php echo number_format($rows['price'],0,',','.')?></td>
                    <td><?php echo $rows["percent"];?></td>
                    <td><?php echo $rows["create_date"];?></td>
                    <td align="center"><button data-id="<?php echo $rows['id_receipt'];?>" href="" class="tinhnang1" type="button" title="Xóa" id=""><i class="icon1 ti-trash"></i></button>  <button href="" class="tinhnang2 js-change-donhang" type="button" title="Sửa" id=""><i class="icon1 ti-marker-alt"></i></button></td>
                </tr>
                <?php }?>
                </tr>
                
               
            </tbody>
        </table>

    </div>


    <div class="footer">
        <a href="Index.php?id=qlncc" class="add" type="button" title="Nhà cung cấp" id="">Thông tin nhà cung cấp <i class="icon1 ti-hand-point-right"></i></a>
    </div>

</div>
<!-- tim kiem don hang -->
<script>
    $(document).ready(function(){
        $("#search_oder").keyup(function(){
            var input_oder = $(this).val();
           if(input_oder != ""){
            $.ajax({
                url: "Function/search.php",
                method: "post",
                data:{input_oder:input_oder},
                success:function(data){
                    $("#table_data_oder").html(data);
                }
            });
           } else{
          $("#table_data_oder").css("display","none");
           }
        })
    })
</script>


<!-- xoa don hang -->
<script>
$(document).on('click', '.tinhnang1', function() {
    var id_cereipt = $(this).data('id');
    var tr = $(this).closest('tr');
    if(confirm("Bạn muốn xóa đơn hàng "+id_cereipt+"?")){

    
    $.ajax({
        url: 'Function/delete.php',
        type: 'POST',
        data: {id_cereipt: id_cereipt},
        success: function(response) {
            // Xử lý kết quả trả về từ server nếu cần thiết
            console.log(response);
            tr.remove();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Xử lý lỗi nếu có
            console.log(textStatus, errorThrown);
        }
      
    });
  }
});

</script>