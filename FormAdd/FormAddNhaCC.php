<?php
 if(isset($_POST["submitNCC"])){

    $data = array(
        "name" => $_POST['name'],
        "address" => $_POST['address'],
        "phone_number" => $_POST['phone_number'],
        "email" => $_POST['email'],
    );
    
    $sql = "SELECT ncc.id_supplier, ncc.name, ncc.address, ncc.phone_number, ncc.email
    FROM supplier as ncc ";
    
    
    $db->insert('supplier', $data);
      
      
    $db->close();
 }
?>



<form method="post">

    <div id="form_addncc" class="content-formaddnhanvien">
            
        <div class="row">

            <div class="form1">
                <label class="labelnhanvien">Tên nhà cung cấp: </label>
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
                <input name="phone_number" class="form-control" type="text">
            </div>

            <div class="form1">
                <button onclick="location.href='Index.php?id=qlncc';" href="" class="add-nhanvien" type="submit" name="submitNCC" title="Lưu" id=""><i class="icon1 ti-save"></i>Thêm nhà cung cấp</button>
                <button onclick="location.href='Index.php?id=qlncc';" class="add-nhanvien" type="button" title="Hủy" id=""><i class="icon1 ti-trash"></i>Hủy bỏ</button>
            </div>

        </div>


        <div class="">
            

        </div>

    </div>
</form>
