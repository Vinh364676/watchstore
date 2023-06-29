<?php
 if(isset($_POST["submitRole"])){

    $data = array(
        "name" => $_POST['name'],
    );
    $sql = "SELECT *
    FROM role ";
    
    
    $db->insert('role', $data);
      
      
    $db->close();
 }
?>



<form method="post">

    <div id="form_addquyen" class="content-formaddnhanvien">
            
        <div class="row">

            <div class="form1">
                <label class="labelnhanvien">Tên quyền: </label>
                <input name="name" class="form-control" type="text">
            </div>

            <div class="form1">
                <button onclick="location.href='Index.php?id=qlq';" href="" class="add-nhanvien" type="submit" name="submitRole" title="Lưu" id=""><i class="icon1 ti-save"></i>Thêm quyền</button>
                <button onclick="location.href='Index.php?id=qlq';" class="add-nhanvien" type="button" title="Hủy" id=""><i class="icon1 ti-trash"></i>Hủy bỏ</button>
            </div>

        </div>


        <div class="">
            

        </div>

    </div>
</form>
