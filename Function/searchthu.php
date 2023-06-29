<?php
  require '../db/connect.php';
?>
<?php
      
      $output = '';
      $db = new Database();
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
                       <button  value="<?php echo $rows['id_product'];?>" class="tinhnang2 js-change-sanpham" name="submit_edit" type="submit" title="Sửa" id="btn_update"><i class="icon1 ti-marker-alt"></i></button></td>
                
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
<!-- <script>
    $(document).ready(function() {
  $('.tinhnang2').click(function() {
    
      $('.js-modalSP').css('display', 'flex').show();

    var id_product = $(this).val();
    console.log(id_product);
    $.ajax({
      url: 'get_data.php',
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

//         var cboWire = $('#name_wire');
// cboWire.val(data.material_wire_id);

    //     $('#name_wire').val(data.material_name);
          
         // var defaultValue = $('#name_wire').val();

// Cập nhật giá trị select khi ấn nút lưu
// $('#btn-save').on('click', function() {
//   // Code cập nhật dữ liệu

//   // Hiển thị giá trị mới trên select
//   var newSelectedValue = // Lấy giá trị mới từ dữ liệu
//   $('#name_wire').val(newSelectedValue);
// });

// // Khôi phục giá trị ban đầu khi hủy
// $('#btn-cancel').on('click', function() {
//   $('#name_wire').val(defaultValue);
// });
var cboWire = $('#name_wire');
cboWire.find('option[value="'+data.material_wire_id+'"]').prop('selected', true);

         // var cboWire = $('#name_wire');
        //  cboWire.val(data.material_wire_name);
        
        // var cboGlass = $('#name_glass');
        // cboGlass.find('option[value="'+data.material_glass_id+'"]').prop('selected', true);
        // var cboPin = $('#name_pin');
        // cboPin.find('option[value="'+data.pin_id+'"]').prop('selected', true);
        // var cboBrand = $('#name_brand');
        // cboBrand.find('option[value="'+data.brand_id+'"]').prop('selected', true);
        //var cboGlass = $('#name_glass');
        // cboGlass.append($('<option>', {
        //   value: data.material_glass_id,
        //   text: data.material_glass_name,
        //   selected: true
        // }));
        // var cboPin = $('#name_pin');
        // cboPin.append($('<option>', {
        //   value: data.pin_id,
          
        //   text: data.name_pin,
        //   selected: true
        // }));
        // var cboBrand = $('#name_brand');
        // cboBrand.append($('<option>', {
        //   value: data.brand_id,
        //   text: data.name_brand,
        //   selected: true
      //  }));
        // Hiển thị form cập nhật
        
        $('.js-modalSP').data('id', id_product); // Định nghĩa giá trị id_product trong form
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
  url: 'save_data.php',
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
   $('.js-modalSP').hide();
  
    // Xử lý kết quả trả về (nếu có)
  },
  error: function(jqXHR, textStatus, errorThrown) {
    console.log('Error: ' + errorThrown);
  }
});
    
  });
});

</script> -->


