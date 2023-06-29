<?php
    require '../db/connect.php';
    $db = new Database();
?>
<!-- Search Tai Khoan -->
<?php
    
      $output_tk = '';
        if(isset($_POST['input_tk'])){
        $input_tk = $_POST['input_tk'];
        $sql = "SELECT tk.create_date, tk.id_account, tk.user_id, tk.user_name, tk.password, tk.status, us.name as name_display, r.name as role_display
        FROM account as tk 
        join user as us on tk.user_id = us.id_user 
        join role as r on us.role_id = r.id_role WHERE tk.user_name LIKE '%{$input_tk}%' ";
        $result_tk = $db->query($sql);
        
        // $qr = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result_tk)>0){?>
          $output_tk = "  <thead >
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
            </thead>"

           
            <tbody>
            <?php
                while($rows = mysqli_fetch_array($result_tk)){
                  
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
                    <td align="center"><button href="" class="tinhnang1" type="button" title="Xóa" id=""><i class="icon1 ti-trash"></i></button>  <button href="" class="tinhnang2 js-change-taikhoan" type="button" title="Sửa" id=""><i class="icon1 ti-marker-alt"></i></button></td>
                </tr>
               
                <?php }?>
            </tbody>
            
          <?php
          echo $output_tk;
        } else{
            echo "No data";
        } 
      }
?>

<!-- Search San pham -->
<?php
      
      $output = '';
      if(isset($_POST['input'])){
        $input = $_POST['input'];
        $sql = "SELECT p.id_product, p.name AS name_product, p.img, p.price, p.quantity, mw.name AS name_wire, mg.name AS name_glass, pi.name AS name_pin, b.name AS name_brand, pd.color, pd.size, pd.origin, pd.code
        FROM product AS p JOIN material_wire mw ON p.material_wire_id = mw.id_material_wire
        join product_detail as pd on p.id_product = pd.id_product
        JOIN material_glass AS mg on p.material_glass_id = mg.id_material_glass
        JOIN pin as pi ON p.pin_id = pi.id_pin
        JOIN brand as b ON p.brand_id = b.id_band WHERE p.name LIKE '%{$input}%' ";
        $result = $db->query($sql);
        
        // $qr = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){?>
          $output = " <thead >
                <tr style="height: 60px;">
                    <th width="2%">ID</th>
                    <th width="14%">Tên sản phẩm</th>
                    <th width="14%">Code</th>
                    <th width="6%">Ảnh</th>
                    <th width="6%">Giá bán</th>
                    <th width="6%">Số lượng</th>
                    <th width="6%">Dây</th>
                    <th width="6%">Kính</th>
                    <th width="6%">Pin</th>
                    <th width="6%">Màu</th>
                    <th width="6%">Size</th>
                    <th width="8%">Thương hiệu</th>
                    <th width="6%">Xuất xứ</th>
                    <th width="8%">Tính năng</th>
                </tr>
            </thead>"

           
            <tbody>
            <?php
                while($rows = mysqli_fetch_array($result)){
                    // $id_product = $rows['id_product'];
                    // $name = $rows['name_product'];
                    // $img = $rows['img'];
                    // $price = $rows["price"];
                    // $price = $rows["price"];
                    // $quantity = $rows["quantity"];
                    // $name_wire = $rows["name_wire"];
                    // $name_glass = $rows["name_glass"];
                    // $name_pin = $rows["name_pin"];
                    // $size = $rows["size"];
                    // $name_brand = $rows["name_brand"];
                    // $origin = $rows["origin"];
            ?>
                <tr>
                    <td><?php echo $rows["id_product"];?></td>
                    <td><?php echo $rows["name_product"];?></td>
                    <td><?php echo $rows["code"];?></td>
                    <td><?php echo '<img src="./imgsql/'.$rows["img"].'" width="100%"'?></td>
                    <td><?php echo $rows["price"];?></td>
                    <td><?php echo $rows["quantity"];?></td>
                    <td><?php echo $rows["name_wire"];?></td>
                    <td><?php echo $rows["name_glass"];?></td>
                    <td><?php echo $rows["name_pin"];?></td>
                    <td><?php echo $rows["color"];?></td>
                    <td><?php echo $rows["size"];?></td>
                    <td><?php echo $rows["name_brand"];?></td>
                    <td><?php echo $rows["origin"];?></td>
                    <!-- <td align="center"><button href="" class="tinhnang1" type="button" title="Xóa" id=""><i class="icon1 ti-trash"></i></button>  <button href="" class="tinhnang2 js-change-sanpham" type="button" title="Sửa" id=""><i class="icon1 ti-marker-alt"></i></button></td> -->
                    <td align="center"><button type="button" name = "btn_delete" data-id="<?php echo $rows['id_product'];?>"  class="tinhnang1 js-change-sanpham-delete"  title="Xóa" id="btn_delete"><i class="icon1 ti-trash"></i></button>
                       <button  value="<?php echo $rows['id_product'];?>" class="tinhnang2 update_sp js-change-sanpham" name="submit_edit" type="submit" title="Sửa" id="btn_update"><i class="icon1 ti-marker-alt"></i></button></td>
                
                </tr>
               
                <?php }?>
            </tbody>
            
          <?php
          echo $output;
        } else{
            echo "No data";
        } 
      }
?>
<!-- xu ly nut luu trong tim kiem -->
<script>
    $(document).ready(function() {
  $('.update_sp').click(function() {
    $('.js-modalSP').css('display', 'flex').show();
    var id_product = $(this).val();
    console.log(id_product);
    $.ajax({
      url: 'Function/get_data.php',
      type: 'GET',
      data: {id_product:id_product},
      success: function(data) {
        // Gán giá trị dữ liệu cho các trường trong form cập nhật
        $('#name').val(data.name);
        $('#code').val(data.code);
        $('#quantity').val(data.quantity);
        $('#color').val(data.color);
        $('#size').val(data.size);
        $('#origin').val(data.origin);
        $('#img').attr('src', data.img);
        $('#description').val(data.description);

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
    var removeAvatar = $('#removeAvatar').is(":checked");
   var avatar = $('#avatar').val().split('/').pop().split('\\').pop();

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
            brand_id: brand_id, 
            removeAvatar: removeAvatar,
         avatar: avatar
          },
  success: function(data) {
    console.log(data);
    window.location.href = 'Index.php?id=qlsp';
   $('.js-modalSP').hide();
  
    // Xử lý kết quả trả về (nếu có)
  },
  error: function(jqXHR, textStatus, errorThrown) {
    console.log('Error: ' + errorThrown);
  }
});
    
  });
});

 
</script>
<!-- Search Thong tin -->
<?php
      
      $output_infor = '';
      if(isset($_POST['input_infor'])){
        $input_infor = $_POST['input_infor'];
        $sql = "SELECT tt.id_user, tt.name, tt.address, tt.phone, tt.email, tt.birthday, t.name as name_type, r.name as name_role,
        CASE WHEN gender = 2 THEN 'Nữ' 
            WHEN gender = 1 THEN 'Nam' 
            ELSE 'Không rõ' 
        END as gender_display 
    FROM user as tt 
    join type as t on tt.type = t.id_type 
    Join role as r on tt.role_id = r.id_role WHERE tt.name LIKE '%{$input_infor}%' ";
        $result_infor = $db->query($sql);
        
        // $qr = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result_infor)>0){?>
          $output = " <thead >
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
            </thead>"

           
            <tbody>
            <?php
                while($rows = mysqli_fetch_array($result_infor)){
                  
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
                    <td align="center"><button href="" class="tinhnang1" type="button" title="Xóa" id=""><i class="icon1 ti-trash"></i></button>  <button href="" class="tinhnang2 js-change-nhanvien" type="button" title="Sửa" id=""><i class="icon1 ti-marker-alt"></i></button></td>  
                </tr>
               
                <?php }?>
            </tbody>
            
          <?php
          echo $output_infor;
        } else{
            echo "No data";
        } 
      }
?>

<!-- Search Nha cung cap -->
<?php
      
      $output_ncc = '';
      if(isset($_POST['input_ncc'])){
        $input_ncc = $_POST['input_ncc'];
        $results = $db->search('supplier', 'name', $input_ncc);
        
        // $result_infor = $db->query($sql);
        
        // $qr = mysqli_query($conn,$sql);
        if ($results->num_rows > 0){?>
          $output_ncc = " <thead >
                <tr style="height: 60px;">
                    <th width="5%">ID</th>
                    <th width="20%">Tên nhà cung cấp</th>
                    <th width="30%">Địa chỉ</th>
                    <th width="20%">Email</th>
                    <th width="15%">Số điện thoại</th>
                    <th width="10%">Tính năng</th>
                </tr>
            </thead>"

           
            <tbody>
            <?php
                while($rows =$results->fetch_assoc()){
                  
            ?>
                <tr>
                    <td><?php echo $rows["id_supplier"];?></td>
                        <td><?php echo $rows["name"];?></td>
                        <td><?php echo $rows["address"];?></td>
                        <td><?php echo $rows["email"];?></td>
                        <td><?php echo $rows["phone_number"];?></td>
                        <td align="center"><button href="" class="tinhnang1" type="button" title="Xóa" id=""><i class="icon1 ti-trash"></i></button>  <button href="" class="tinhnang2 js-change-nhacungcap" type="button" title="Sửa" id=""><i class="icon1 ti-marker-alt"></i></button></td>
                </tr>
               
                <?php }?>
            </tbody>
            
          <?php
          echo $output_ncc;
        } else{
            echo "No data";
        } 
      }
?>

<!-- Search Don hang -->
<?php
      
      $output_oder = '';
      if(isset($_POST['input_oder'])){
        $input_oder = $_POST['input_oder'];
        $sql = "SELECT s.name as nameNCC, us.name as nameNV, re.total, p.name as nameSP, d.quantity, d.price, d.percent, re.create_date, re.id_receipt 
                            FROM receipt as re join supplier as s on s.id_supplier = re.supplier_id
                            join user as us on us.id_user = re.user_id
                            join receipt_detail as d on d.receipt_id = re.id_receipt
                            join product as p on p.id_product = d.product_id
                            WHERE p.name LIKE '%{$input_oder}%' ";
        $result_oder = $db->query($sql);
        
        // $qr = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result_oder)>0){?>
          $output_oder = " <thead >
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
            </thead>"

           
            <tbody>
            <?php
                while($rows = mysqli_fetch_array($result_oder)){
                  
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
                    <td align="center"><button href="" class="tinhnang1" type="button" title="Xóa" id=""><i class="icon1 ti-trash"></i></button>  <button href="" class="tinhnang2 js-change-donhang" type="button" title="Sửa" id=""><i class="icon1 ti-marker-alt"></i></button></td>
                </tr>
               
                <?php }?>
            </tbody>
            
          <?php
          echo $output_oder;
        } else{
            echo "No data";
        } 
      }
?>

<!-- Search voucher -->
<?php
      
      $output_vc = '';
      if(isset($_POST['input_vc'])){
        $input_vc = $_POST['input_vc'];
        $sql = "SELECT vc.id_voucher, vc.code, vc.value, vc.start_date, vc.end_date
                FROM voucher as vc
                WHERE vc.code LIKE '%{$input_vc}%' ";
        $result_vc = $db->query($sql);
        
        // $qr = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result_vc)>0){?>
          $output_vc = " <thead >
                <tr style="height: 60px;">
                  <th width="5%">ID</th>
                    <th width="20%">Mã giảm giá</th>
                    <th width="10%">Giá trị</th>
                    <th width="25%">Ngày bắt đầu</th>
                    <th width="25%">Ngày kết thúc</th>
                    <th width="15%">Tính năng</th>
                </tr>
            </thead>"

           
            <tbody>
            <?php
                while($rows = mysqli_fetch_array($result_vc)){
                  
            ?>
                <tr>
                       <td><?php echo $rows["id_voucher"];?></td>
                        <td><?php echo $rows["code"];?></td>
                        <td><?php echo $rows["value"];?></td>
                        <td><?php echo $rows["start_date"];?></td>
                        <td><?php echo $rows["end_date"];?></td>
                        <td align="center"><button href="" class="tinhnang1" type="button" title="Xóa" id=""><i class="icon1 ti-trash"></i></button>  <button href="" class="tinhnang2 js-change-voucher" type="button" title="Sửa" id=""><i class="icon1 ti-marker-alt"></i></button></td>
                  </tr>
               
                <?php }?>
            </tbody>
            
          <?php
          echo $output_vc;
        } else{
            echo "No data";
        } 
      }
?>