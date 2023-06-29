<?php
 if(isset($_POST["submitVC"])){

    $data = array(
        "code" => $_POST['code'],
        "value" => $_POST['value'],
        "start_date" => $_POST['start_date'],
        "end_date" => $_POST['end_date'],
    );
    $sql = "SELECT vc.id_voucher, vc.code, vc.value, vc.start_date, vc.end_date
    FROM voucher as vc ";
    
    
    $db->insert('voucher', $data);
      
      
    $db->close();
 }
?>
<form method="post">

    <div id="form_addvc" class="content-formaddnhanvien">
            
        <div class="row">

            <div class="form1">
                <label class="labelnhanvien">Mã giảm giá: </label>
                <input name="code" class="form-control" type="text">
            </div>
            
            <div class="form1">
                <label class="labelnhanvien">Giá trị: </label>
                <input name="value" class="form-control" type="number" min="0" step="0.01">
            </div>

            <div class="form1">
                <label class="labelnhanvien">Ngày bắt đầu: </label>
                <input name="start_date" class="form-control" type="date">
            </div>

            <div class="form1">
                <label class="labelnhanvien">Ngày kết thúc: </label>
                <input name="end_date" class="form-control" type="date">
            </div>

            <div class="form1">
                <button onclick="location.href='Index.php?id=qlvc';" class="add-nhanvien" type="submit" name="submitVC" title="Lưu" id=""><i class="icon1 ti-save"></i>Thêm voucher</button>
                <button onclick="location.href='Index.php?id=qlvc';" class="add-nhanvien" type="button" title="Hủy" id=""><i class="icon1 ti-trash"></i>Hủy bỏ</button>
            </div>

        </div>


    </div>
</form>
