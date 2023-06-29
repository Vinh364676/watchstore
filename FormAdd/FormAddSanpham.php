<?php

?>
<!--    -->
<?php
 if(isset($_POST["submit"])){
    // Lấy thông tin về tệp được tải lên
    $file_name = $_FILES["image"]["name"];
    $file_tmp = $_FILES["image"]["tmp_name"];
    
    // Tạo đường dẫn cho tệp mới trên máy chủ
    $new_file_path = "./imgsql/" . $file_name;
    
    // Sao chép tệp từ vị trí ban đầu đến thư mục chứa ảnh của bạn
    copy($file_tmp, $new_file_path);

    $data = array(
        "name" => $_POST['name'],
        "img" => $file_name,
        "category_id" => $_POST['id_category'],
        "pin_id" => $_POST['id_pin'],
        "material_wire_id" => $_POST['id_material_wire'],
        "material_glass_id" => $_POST['id_material_glass'],
        "brand_id" => $_POST['id_band'],
    );
    $sql = "SELECT p.id_product, p.name AS name_product, p.img, p.price, p.quantity, mw.name AS name_wire, mg.name AS name_glass, pi.name AS name_pin, b.name AS name_brand, pd.color, pd.size, pd.origin, pd.code, pd.gender
    FROM product AS p JOIN material_wire mw ON p.material_wire_id = mw.id_material_wire
    join product_detail as pd on p.id_product = pd.id_product
    JOIN material_glass AS mg on p.material_glass_id = mg.id_material_glass
    JOIN pin as pi ON p.pin_id = pi.id_pin
    JOIN brand as b ON p.brand_id = b.id_band
    JOIN category as ca ON p.category_id = ca.id_category
    
    WHERE p.category_id = '" . $data["category_id"] . "' AND p.pin_id= '" . $data["pin_id"] . "' 
    AND p.material_wire_id= '" . $data["material_wire_id"] . "'AND p.material_glass_id= '" . $data["material_glass_id"] . "' 
    AND p.brand_id= '" . $data["brand_id"] . "'
    ON DUPLICATE KEY UPDATE p.quantity = p.quantity + 1 ";
   // $result = $db->query($sql);
   $result =  $db->insert('product', $data);
        $id_product = $db->conn->insert_id;
        $product_data = array(
            "id_product" => $id_product, 
            "code" => $_POST["code"], 
            "shape" => $_POST["shape"],
            "size" => $_POST["size"], 
            "color" => $_POST["color"], 
            "gender" => $_POST["gioitinh"], 
            "water_resistance" => $_POST["water_resistance"],
            "origin" => $_POST["origin"],
            "description" => $_POST["description"],
         );
        
        $db->insert('product_detail', $product_data);
        // $chitiet_data = array("code" => $_POST["code"], "id_product" => $id_product);
        // $chitiet_result = $db->insert("product_detail", $chitiet_data);
    //     if ($chitiet_result) {
    //       echo "Inserted successfully.";
    //     } else {
    //       echo "Error: " . $this->conn->error;
    //     }
    
      if($result){
        header('location: Index.php?id=qlsp');
      }
    $db->close();
 }
?>

<form method="post"enctype="multipart/form-data">
    <div id="form_addsp" class="content-formaddnhanvien">

        <div class="row">

            <div class="form1">
                <label class="labelnhanvien">Tên sản phẩm: </label>
                <input class="form-control" name="name" type="text" pattern="[a-zA-Z\s]+" required
  oninvalid="this.setCustomValidity('Vui lòng nhập tên của bạn. Tên chỉ được chứa các chữ cái và khoảng trắng')"
  oninput="setCustomValidity('')">
            </div>
            <div class="form1">
                <label class="labelnhanvien">Danh mục: </label>
                <select class="cbo" name="id_category" id="">
                    <?php

               
                $sql = "SELECT * FROM category";
                $result = $db->query($sql);
                while($rows = mysqli_fetch_array($result)){
            ?>


                    <option value="<?php echo $rows["id_category"]; ?>"><?php echo $rows["name"];?></option>

                    <?php }?>
                </select>
            </div>

            <div id="image-preview"></div>

            <div class="load-img">
                <label for="file-upload" class="up-img"><i class="upload">Tải ảnh lên</i></label>
                <!-- <input id="file-upload" class="btn-up" type="file" name="img" /> -->
                <input type="file" id="image" name="image" required oninvalid="this.setCustomValidity('Vui lòng chọn ảnh!')"
  oninput="setCustomValidity('')" >
            </div>


            <hr>
            <h1 class="thongso">Chi tiết sản phẩm</h1>

            <div class="form1">
                <label class="labelnhanvien">Mã sản phẩm: </label>
                <input class="form-control" name="code" type="text" pattern="[A-Za-z0-9]+" required
  oninvalid="this.setCustomValidity('Vui lòng nhập mã của sản phẩm. Mã chỉ được chứa các chữ cái và số')"
  oninput="setCustomValidity('')">
            </div>

            <div class="form1">
                <label class="labelnhanvien">Bộ máy và năng lượng: </label>
                <select class="cbo" name="id_pin" id="">
                    <?php
               
               $sql = "SELECT * FROM pin";
               $result = $db->query($sql);
               while($rows = mysqli_fetch_array($result)){
           ?>

                    <option value="<?php echo $rows["id_pin"]; ?>"><?php echo $rows["name"];?></option>
                    <?php }?>
                </select>
            </div>

            <div class="form1">
                <label class="labelnhanvien">Chất liệu dây: </label>
                <select class="cbo" name="id_material_wire" id="">
                    <?php
               
               $sql = "SELECT * FROM material_wire";
               $result = $db->query($sql);
               while($rows = mysqli_fetch_array($result)){
           ?>

                    <option value="<?php echo $rows["id_material_wire"]; ?>"><?php echo $rows["name"];?></option>
                    <?php }?>
                </select>
            </div>

            <div class="form1">
                <label class="labelnhanvien">Chất liệu kính: </label>
                <select class="cbo" name="id_material_glass" id="">
                    <?php
               
               $sql = "SELECT * FROM material_glass";
               $result = $db->query($sql);
               while($rows = mysqli_fetch_array($result)){
           ?>

                    <option value="<?php echo $rows["id_material_glass"]; ?>"><?php echo $rows["name"];?></option>
                    <?php }?>
                </select>
            </div>

            <div class="form1">
                <label class="labelnhanvien">Giới tính: </label>
                <div class="chon">
                    <input value="1" id="gtnam" type="radio" name="gioitinh" class="check-type"><label class="labeldonhang"
                        for="">Nam</label>
                    <input value="2" id="gtnu" type="radio" name="gioitinh" class="check-type"><label class="labeldonhang"
                        for="">Nữ</label>
                </div>
            </div>

            <div class="form1">
                <label class="labelnhanvien">Hình dạng mặt kính: </label>
                <input class="form-control" name="shape" type="text" pattern="[a-zA-Z\s]+" required
  oninvalid="this.setCustomValidity('Vui lòng nhập hình dạng của sản phẩm. Hình dạng chỉ được chứa các chữ cái và khoảng trắng')"
  oninput="setCustomValidity('')">
            </div>

            <div class="form1">
                <label class="labelnhanvien">Size mặt kính: </label>
                <input class="form-control" name="size" type="text" pattern="(\d+(\.\d+)?|\.\d+)(\s*(>|<)\s*(\d+(\.\d+)?|\.\d+))?mm" required
  oninvalid="this.setCustomValidity('Vui lòng nhập kích thước của sản phẩm theo định dạng số có đơn vị mm, ví dụ: 10mm hoặc >10mm')"
  oninput="setCustomValidity('')">


            </div>

            <div class="form1">
                <label class="labelnhanvien">Màu: </label>
                
<input class="form-control" name="color" type="text" pattern="[a-zA-Z\s]+" required
  oninvalid="this.setCustomValidity('Vui lòng nhập màu sắc của sản phẩm. Màu sắc chỉ được chứa các chữ cái và khoảng trắng')"
  oninput="setCustomValidity('')">
            </div>

            <div class="form1">
                <label class="labelnhanvien">Khả năng chống nước: </label>
                <input class="form-control" name="water_resistance" type="text" pattern="[0-9]+ATM" required
  oninvalid="this.setCustomValidity('Vui lòng nhập độ chịu nước của sản phẩm theo định dạng Số ATM. Ví dụ: 5ATM')"
  oninput="setCustomValidity('')">
            </div>

            <div class="form1">
                <label class="labelnhanvien">Thương hiệu: </label>
                <select class="cbo" name="id_band" id="">
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
                <label class="labelnhanvien">Xuất xứ: </label>
                <input class="form-control" name="origin" type="text" pattern="[a-zA-Z\s]+" required
  oninvalid="this.setCustomValidity('Vui lòng nhập xuất xứ của sản phẩm. Xuất xứ chỉ được chứa các chữ cái và khoảng trắng')"
  oninput="setCustomValidity('')">
            </div>

            <div class="form1">
                <label class="labelnhanvien">Miêu tả sản phẩm: </label> <br>
                <textarea name="description" id="ghichu" cols="50" rows="10"></textarea>
            </div>

            <div class="form1">
                <button type="submit" name="submit" href="" class="add-sanpham" title="Lưu" id=""><i
                        class="icon1 ti-save"></i>Tạo sản phẩm</button>
                <button onclick="location.href='Index.php?id=qlsp';" class="add-nhanvien" type="button" title="Hủy"
                    id=""><i class="icon1 ti-trash"></i>Hủy bỏ</button>
            </div>



        </div>




        <div class="">


        </div>

    </div>
</form>

<script>
    $(document).ready(function() {
        $('.check-type').change(function() {
            var gioitinh = $('input[name="gioitinh"]:checked').val();
            $.ajax({
                type: "POST",
                url: "qlSanpham.php",
                data: {
                    gioitinh: gioitinh
                },
                success: function(result) {
                    console.log(result);
                }
            });
        });
    });

</script>