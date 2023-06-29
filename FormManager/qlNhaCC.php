<div id="qlncc" class="content">

    <div class="content-header">

        <div id="clock"></div>
        
    </div>
    
    <div class="content-mid">
        
        <a href="Index.php?id=form_addncc" class="add" type="button" title="Thêm" id=""><i class="icon1 ti-plus"></i>Nhà cung cấp</a>
        <!-- <a href="" class="print" type="button" title="Xuất" id=""><i class="icon1 ti-printer"></i>Xuất file Excel</a> -->
        <label class="form-timkiem" for="">Tìm kiếm: 
            <input type="search" id="search_ncc" class="search"><button class="ti-search" type="button" title="Tìm kiếm" id="" ></button>
        </label>

    </div>

    <div class="form-dsnguoidung">
        
        <h1>Danh sách nhà cung cấp</h1>

        <div class="form1 formchonloc">
            <label class="labelnhanvien">Lọc: </label>
            <select class="cbo chonloc" name="type" id="">
                <option>Theo thứ tự từ a -> z</option>
                <option>Theo thứ tự từ z -> a</option>
            </select>
        </div>

        <table id="table_data_ncc" width="100%" border="3" cellspacing="2px" align="center" bordercolor = "aquamarine">
            <thead >
                <tr style="height: 60px;">
                    <th width="5%">ID</th>
                    <th width="20%">Tên nhà cung cấp</th>
                    <th width="30%">Địa chỉ</th>
                    <th width="20%">Email</th>
                    <th width="15%">Số điện thoại</th>
                    <th width="10%">Tính năng</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <?php
                // $db = new Database();
                $sql = "SELECT ncc.id_supplier, ncc.name, ncc.address, ncc.phone_number, ncc.email
                FROM supplier as ncc ";
                $result = $db->query($sql);

                while($rows = mysqli_fetch_array($result)){
            ?>
                    <tr>
    
                        <td><?php echo $rows["id_supplier"];?></td>
                        <td><?php echo $rows["name"];?></td>
                        <td><?php echo $rows["address"];?></td>
                        <td><?php echo $rows["email"];?></td>
                        <td><?php echo $rows["phone_number"];?></td>
                        <td align="center"><button data-id="<?php echo $rows["id_supplier"];?>" href="" class="tinhnang1" type="button" title="Xóa" id=""><i class="icon1 ti-trash"></i></button>  <button href="" class="tinhnang2 js-change-nhacungcap" type="button" title="Sửa" id=""><i class="icon1 ti-marker-alt"></i></button></td>
                    </tr>

                <?php }?>
                </tr>
                
                
               
            </tbody>
        </table>

    </div>


    <div class="footer">
        <a href="Index.php?id=qldh" class="add" type="button" title="Quản lý đơn hàng" id=""><i class="icon1 ti-hand-point-left"></i>Quản lý đơn hàng</a>
    </div>


</div>


<script>
    $(document).ready(function(){
        $("#search_ncc").keyup(function(){
            var input_ncc = $(this).val();
           if(input_ncc != ""){
            $.ajax({
                url: "Function/search.php",
                method: "post",
                data:{input_ncc:input_ncc},
                success:function(data){
                    $("#table_data_ncc").html(data);
                }
            });
           } else{
          $("#table_data_ncc").css("display","none");
           }
        })
    })
</script>


<!-- xoa don hang -->
<script>
$(document).on('click', '.tinhnang1', function() {
    var id_supplier = $(this).data('id');
    var tr = $(this).closest('tr');
    if(confirm("Bạn muốn xóa nhà cung cấp "+id_supplier+"?")){

    
    $.ajax({
        url: 'Function/delete.php',
        type: 'POST',
        data: {id_supplier: id_supplier},
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