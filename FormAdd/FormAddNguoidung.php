<?php
 if(isset($_POST["submitTT"])){

    $data = array(
        "name" => $_POST['name'],
        "address" => $_POST['address'],
        "phone" => $_POST['phone'],
        "email" => $_POST['email'],
        "type" => $_POST['type'],
        "role_id" => $_POST['role_id'],
        "birthday" => $_POST['birthday'],
        "gender" => $_POST['gioitinh'],
    );

    // $sql = "SELECT tt.id_user, tt.name, tt.address, tt.phone, tt.email, tt.type, tt.role_id, tt.birthday, tt.gender
    // FROM user as tt ";

    $sql = "SELECT tt.id_user, tt.name, tt.address, tt.phone, tt.email, tt.birthday, t.name, r.name, tt.gender
                FROM user as tt 
                join type as t on tt.type = t.id_type 
                Join role as r on tt.role_id = r.id_role";

    $db->insert('user', $data);
      
      
    $db->close();
 }
?>

<form method="post">

    <div id="form_addnd" class="content-formaddnhanvien">
            
        <div class="row">

            <div class="form1">
                <label class="labelnhanvien">Họ và tên: </label>
                <input name="name" class="form-control" type="text">
            </div>
            
            <div class="form1">
                <label class="labelnhanvien">Địa chỉ: </label>
                <input name="address" class="form-control" type="text">
            </div>

            <div class="form1">
                <label class="labelnhanvien">Email: </label>
                <input name="email" class="form-control" type="text">
            </div>

            <div class="form1">
                <label class="labelnhanvien">Số điện thoại: </label>
                <input name="phone" class="form-control" type="text">
            </div>

            <!-- <div class="form1">
                <label class="labelnhanvien">Căn cước công dân: </label>
                <input class="form-control" type="text">
            </div> -->

            <div class="form1">
                <label class="labelnhanvien">Ngày sinh: </label>
                <input name="birthday" class="form-control" type="date">
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
                <label class="labelnhanvien">Phân loại: </label>
                <select class="cbo" name="type" id="">
                <?php
               
               $sql = "SELECT * FROM type";
               $result = $db->query($sql);
               while($rows = mysqli_fetch_array($result)){
           ?>

                    <option value="<?php echo $rows["id_type"]; ?>"><?php echo $rows["name"];?></option>
                    <?php }?>
                </select>
            </div>

            <div class="form1">
                <label class="labelnhanvien">Phân quyền : </label>
                <select class="cbo" name="role_id" id="">
                <?php
               
               $sql = "SELECT * FROM role";
               $result = $db->query($sql);
               while($rows = mysqli_fetch_array($result)){
           ?>

                    <option value="<?php echo $rows["id_role"]; ?>"><?php echo $rows["name"];?></option>
                    <?php }?>
                </select>
            </div>
        
            <!-- <div id="image-preview"></div>
            
            <div class="load-img">
                <label for="file-upload" class="up-img"><i class="upload">Tải ảnh lên</i></label>
                <input id="file-upload" class="btn-up" type="file" accept="image/*" />
            </div> -->


            <div class="form1">
                <button onclick="location.href='Index.php?id=qltt';" class="add-nhanvien" type="submit" name="submitTT" title="Lưu" ><i class="icon1 ti-save"></i>Tạo hồ sơ</button>
                <button onclick="location.href='Index.php?id=qltt';" class="add-nhanvien" type="button" title="Hủy" ><i class="icon1 ti-trash"></i>Hủy bỏ</button>
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
                url: "qlThongtin.php",
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