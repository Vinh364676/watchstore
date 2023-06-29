
<div id="qlvc" class="content">

    <div class="content-header">

        <div id="clock"></div>
        
    </div>
    
    <div class="content-mid">
        
        <a href="Index.php?id=form_addvc" class="add" type="button" title="Thêm" id=""><i class="icon1 ti-plus"></i>Voucher</a>
        <!-- <a href="" class="print" type="button" title="Xuất" id=""><i class="icon1 ti-printer"></i>Xuất file Excel</a> -->
        <label class="form-timkiem" for="">Tìm kiếm: 
            <input type="search" id="search_voucher" class="search"><button class="ti-search" type="button" title="Tìm kiếm" id="" ></button>
        </label>

    </div>

    <div class="form-dsnguoidung">
        
        <h1>Danh sách voucher</h1>

        <div class="form1 formchonloc">
            <label class="labelnhanvien">Lọc: </label>
            <select class="cbo chonloc" name="type" id="">
                <option>Theo thứ tự từ a -> z</option>
                <option>Theo thứ tự từ z -> a</option>
            </select>
        </div>

        <table id="table_data_vc"  width="100%" border="3" cellspacing="2px" align="center" bordercolor = "aquamarine">
            <thead >
                <tr style="height: 60px;">
                    <th width="5%">ID</th>
                    <th width="20%">Mã giảm giá</th>
                    <th width="10%">Giá trị</th>
                    <th width="25%">Ngày bắt đầu</th>
                    <th width="25%">Ngày kết thúc</th>
                    <th width="15%">Tính năng</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <?php
                // $db = new Database();
                $sql = "SELECT vc.id_voucher, vc.code, vc.value, vc.start_date, vc.end_date
                FROM voucher as vc ";
                $result = $db->query($sql);

                while($rows = mysqli_fetch_array($result)){
            ?>
                    <tr>
                        <td><?php echo $rows["id_voucher"];?></td>
                        <td><?php echo $rows["code"];?></td>
                        <td><?php echo $rows["value"];?>%</td>
                        <td><?php echo $rows["start_date"];?></td>
                        <td><?php echo $rows["end_date"];?></td>
                        <td align="center"><button data-id="<?php echo $rows["id_voucher"];?>" href="" class="tinhnang1" type="button" title="Xóa" id=""><i class="icon1 ti-trash"></i></button>  <button href="" class="tinhnang2 js-change-voucher" type="button" title="Sửa" id=""><i class="icon1 ti-marker-alt"></i></button></td>
                    </tr>

                <?php }?>
            </tr>
                
                
               
            </tbody>
        </table>

    </div>


    <div class="footer">
        <a href="Index.php?id=qlhd" class="add" type="button" title="Quản lý hóa đơn" id=""><i class="icon1 ti-hand-point-left"></i>Quản lý hóa đơn</a>
    </div>

</div>

<!-- tim kiem voucher -->
<script>
    $(document).ready(function(){
        $("#search_voucher").keyup(function(){
            var input_vc = $(this).val();
           if(input_vc != ""){
            $.ajax({
                url: "Function/search.php",
                method: "post",
                data:{input_vc:input_vc},
                success:function(data){
                    $("#table_data_vc").html(data);
                }
            });
           } else{
          $("#table_data_vc").css("display","none");
           }
        })
    })
</script>


<!-- xoa voucher -->
<script>
$(document).on('click', '.tinhnang1', function() {
    var id_voucher = $(this).data('id');
    var tr = $(this).closest('tr');
    if(confirm("Bạn muốn xóa voucher "+id_voucher+"?")){

    
    $.ajax({
        url: 'Function/delete.php',
        type: 'POST',
        data: {id_voucher: id_voucher},
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