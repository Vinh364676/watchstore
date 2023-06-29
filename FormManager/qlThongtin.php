
<div id="qltt" class="content">

    <div class="content-header">

        <div id="clock"></div>
        
    </div>
    
    <div class="content-mid">
        
        <a href="Index.php?id=form_addnd" class="add" type="button" title="Thêm" id=""><i class="icon1 ti-plus"></i>Thêm hồ sơ</a>
        <a  class="print" type="button" title="Xuất" id=""><i class="icon1 ti-printer"></i> Xuất file Excel </a>
        <label class="form-timkiem" for="">Tìm kiếm: 
            <input type="search" id="search_infor" class="search"><button class="ti-search" type="button" title="Tìm kiếm" id="" ></button>
        </label>

    </div>

    <div class="form-dsnguoidung">
        
        <h1>Danh sách người dùng</h1>

        <table id="table_data_infor"  width="100%" border="3" cellspacing="2px" align="center" bordercolor = "aquamarine">
            <thead >
                <tr style="height: 60px;">
                    <th width="4%">ID</th>
                    <th width="16%">Họ và tên</th>
                    <th width="16%">Địa chỉ</th>
                    <th width="16%">Email</th>
                    <th width="8%">Số điện thoại</th>
                    <th width="8%">Ngày sinh</th>
                    <th width="8%">Giới tính</th>
                    <th width="8%">Phân loại</th>
                    <th width="8%">Phân quyền</th>
                    <th width="8%">Tính năng</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                
                
                // $sql = "SELECT tt.id_user, tt.name, tt.address, tt.phone, tt.email, tt.birthday, tt.role_id, type.name, gender.name
                // FROM user as tt Join type on type.id_type = tt.type 
                // Join gender on gender.id_gender = tt.gender";
                $sql = "SELECT tt.id_user, tt.name, tt.address, tt.phone, tt.email, tt.birthday, t.name as name_type, r.name as name_role,
                    CASE WHEN gender = 2 THEN 'Nữ' 
                        WHEN gender = 1 THEN 'Nam' 
                        ELSE 'Không rõ' 
                    END as gender_display 
                FROM user as tt 
                join type as t on tt.type = t.id_type 
                Join role as r on tt.role_id = r.id_role";
                $result = $db->query($sql);

                while($rows = mysqli_fetch_array($result)){
            ?>
                <tr>
                    <td><?php echo $rows["id_user"];?></td>
                    <td><?php echo $rows["name"];?></td>
                    <td><?php echo $rows["address"];?></td>
                    <td><?php echo $rows["email"];?></td>
                    <td><?php echo $rows["phone"];?></td>
                    <td><?php echo $rows["birthday"];?></td>
                    <td><?php echo $rows["gender_display"];?></td>
                    <td><?php echo $rows["name_type"];?></td>
                    <td><?php echo $rows["name_role"];?></td>
                    <td align="center"><button data-id="<?php echo $rows['id_user'];?>" href="" class="tinhnang1 infor" type="button" title="Xóa" id=""><i class="icon1 ti-trash"></i></button>
                      <button data-id="<?php echo $rows['id_user'];?>" class="tinhnang2 js-change-nhanvien btn_thongtin" type="button" title="Sửa" id=""><i class="icon1 ti-marker-alt"></i></button></td>
                </tr>
                <?php }?>
                </tr>
                
               
            </tbody>
        </table>

    </div>


    


</div>

<!-- Search Thong tin -->
<script>
    $(document).ready(function(){
        $("#search_infor").keyup(function(){
            var input_infor = $(this).val();
           if(input_infor != ""){
            $.ajax({
                url: "Function/search.php",
                method: "post",
                data:{input_infor:input_infor},
                success:function(data){
                    $("#table_data_infor").html(data);
                }
            });
           } else{
         $("#table_data_infor").css("display","none");
           }
        })
    })
</script>

<!-- xoa thong tin -->
<script>
    $(document).on('click', '.infor', function() {
    var id_user = $(this).data('id');
    var tr = $(this).closest('tr');
    if(confirm("Bạn muốn xóa thông tin user "+id_user+"?")){
    $.ajax({
        url: 'Function/delete.php',
        type: 'POST',
        data: {id_user: id_user},
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

<!-- Select form and update -->
<script>
    $(document).ready(function() {
  $('.btn_thongtin').click(function() {
    $('.js-modalTT').css('display', 'flex').show();
    var id_user = $(this).val();
    console.log(id_user);
    $.ajax({
      url: 'Function/get_data.php',
      type: 'GET',
      data: {id_user:id_user},
      success: function(data) {
        // Gán giá trị dữ liệu cho các trường trong form cập nhật
        $('#name').val(data.name);
        $('#address').val(data.address);
        $('#email').val(data.email);
        $('#phone').val(data.phone);
        $('#birthday').val(data.birthday);
        $('#gender').val(data.gender);
        $('#form_update_product').data('id', id_product); // Định nghĩa giá trị id_product trong form
        console.log(data);
      }
    });
  });
  $('.btn_save').click(function(event) {
    
    var name = $('#name').val();
    var code = $('#code').val();
    var quantity = $('#quantity').val();
    var color = $('#color').val();
    var size = $('#size').val();
    var origin = $('#origin').val();
    var description = $('#description').val();
    var material_wire_id = $('#name_wire').val();
    var material_glass_id = $('#name_glass').val();
    var pin_id = $('#name_pin').val();
    var brand_id = $('#name_brand').val();   
    event.preventDefault();   
    var id_product = $('#form_update_product').data('id'); // Lấy giá trị id_product từ form
    // Gửi yêu cầu Ajax để lưu cập nhật
    $.ajax({
  url: 'Function/save_data.php',
  type: 'POST',
  dataType: 'json',
  data: {   id_product:id_product,
            name: name, 
            code: code, 
            quantity: quantity, 
            color: color, 
            size: size, 
            origin: origin, 
            material_wire_id: material_wire_id,
            material_glass_id: material_glass_id, 
            pin_id: pin_id, 
            brand_id: brand_id 
          },
  success: function(data) {
    console.log(data);
   // window.location.href = 'Index.php?id=qlsp';
   $('#form_update_product').hide();
  
    // Xử lý kết quả trả về (nếu có)
  },
  error: function(jqXHR, textStatus, errorThrown) {
    console.log('Error: ' + errorThrown);
  }
});
    
  });
});

 
</script>