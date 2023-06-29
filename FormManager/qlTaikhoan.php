<div id="qltk" class="content">

    <div class="content-header">

        <div id="clock"></div>
        
    </div>
    
    <div class="content-mid">
        
        <a href="Index.php?id=form_addtk" class="add" type="button" title="Thêm" id="add_nv"><i class="icon1 ti-plus"></i>Cấp tài khoản</a>
        <label class="form-timkiem" for="">Tìm kiếm: 
            <input type="search" id="search_tk" class="search"><button class="ti-search" type="button" title="Tìm kiếm" id="" ></button>
        </label> 

    </div>

    <div class="form-dsnguoidung">
        
        <h1>Danh sách tài khoản</h1>

        <div class="form1 formchonloc">
            <label class="labelnhanvien">Lọc: </label>
            <select class="cbo chonloc" name="type" id="">
                <option>Theo thứ tự từ a -> z</option>
                <option>Theo thứ tự từ z -> a</option>
            </select>
        </div>

        <table id="table_data_tk"  width="100%" border="3" cellspacing="2px" align="center" bordercolor = "aquamarine">
            <thead >
                <tr style="height: 60px;">
                    <th width="5%">STT</th>
                    <th width="5%">ID</th>
                    <th width="10%">Phân quyền</th>
                    <th width="15%">Họ và tên</th>
                    <th width="15%">Tên đăng nhập</th>
                    <th width="15%">Mật khẩu</th>
                    <th width="15%">Ngày tạo tài khoản</th>
                    <th width="10%">Trạng thái</th>
                    <th width="10%">Tính năng</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <?php
                $sql = "SELECT tk.create_date, tk.id_account, tk.user_id, tk.user_name, tk.password, tk.status, us.name as name_display, r.name as role_display
                    FROM account as tk 
                    join user as us on tk.user_id = us.id_user 
                    join role as r on us.role_id = r.id_role";
                $result = $db->query($sql);

                while($rows = mysqli_fetch_array($result)){
                    ?>
                <tr>
                    <td><?php echo $rows["id_account"];?></td>
                    <td><?php echo $rows["user_id"];?></td>
                    <td><?php echo $rows["role_display"];?></td>
                    <td><?php echo $rows["name_display"];?></td>
                    <td><?php echo $rows["user_name"];?></td>
                    <td><?php echo $rows["password"];?></td>
                    <td><?php echo $rows["create_date"];?></td>
                    <td align="center" font-size="20px"><input type="checkbox" checked></td>
                    <td align="center"><button data-id="<?php echo $rows["id_account"];?>" href="" class="tinhnang1" type="button" title="Xóa" id=""><i class="icon1 ti-trash"></i></button> 
                     <button value="<?php echo $rows["id_account"];?>" href="" class="tinhnang2 js-change-taikhoan" type="button" title="Sửa" id=""><i class="icon1 ti-marker-alt"></i></button></td>
                </tr>
                
                <?php }?>
                </tr>
               
            </tbody>
        </table>

    </div>

    <div class="footer">
        <a href="Index.php?id=qlq" class="add" type="button" title="Quyền" id="">Quản lý quyền <i class="icon1 ti-hand-point-right"></i></a>
    </div>
    

</div>
<!-- tim kiem tai khoan -->
<script>
    $(document).ready(function(){
        $("#search_tk").keyup(function(){
            var input_tk = $(this).val();
           if(input_tk != ""){
            $.ajax({
                url: "Function/search.php",
                method: "post",
                data:{input_tk:input_tk},
                success:function(data){
                    $("#table_data_tk").html(data);
                }
            });
           } else{
          $("#table_data_tk").css("display","none");
           }
        })
    })
</script>


<!-- xoa tai khoan -->
<script>
$(document).on('click', '.tinhnang1', function() {
    var id_account = $(this).data('id');
    var tr = $(this).closest('tr');
    if(confirm("Bạn muốn xóa tài khoản "+id_account+"?")){

    
    $.ajax({
        url: 'Function/delete.php',
        type: 'POST',
        data: {id_account: id_account},
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


<script>
    $(document).ready(function() {
  $('.tinhnang2').click(function() {
    $('.js-modalTK').show();
    var id_account = $(this).val();
    console.log(id_account);
    $.ajax({
      url: 'Function/get_data.php',
      type: 'GET',
      data: {id_account:id_account},
      success: function(data) {
        // Gán giá trị dữ liệu cho các trường trong form cập nhật
        $('#user_name').val(data.user_name);
        $('#password').val(data.password);
        $('#form_update_account').data('id', id_account); // Định nghĩa giá trị id_product trong form
        console.log(data);
      }
    });
  });
  $('.btn_save').click(function(event) {
    
    var user_name = $('#user_name').val();
    var password = $('#password').val(); 
    event.preventDefault();   
    var id_account = $('#form_update_account').data('id'); // Lấy giá trị id_product từ form
    // Gửi yêu cầu Ajax để lưu cập nhật
    $.ajax({
  url: 'Function/save_data.php',
  type: 'POST',
  dataType: 'json',
  data: {   id_account:id_account,
            user_name: user_name, 
            password: password, 
          },
  success: function(data) {
    console.log(data);
   // window.location.href = 'Index.php?id=qlsp';
   $('#form_update_account').hide();
  
    // Xử lý kết quả trả về (nếu có)
  },
  error: function(jqXHR, textStatus, errorThrown) {
    console.log('Error: ' + errorThrown);
  }
});
    
  });
});

 
</script>