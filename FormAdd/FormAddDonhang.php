<?php
 if(isset($_POST["submitDH"])){
    $data = array(
        "supplier_id" => $_POST['supplier_id'],
        "user_id" => $_POST['user_id'],
        "total" => $_POST['total'],
        
    );

    $sql = "SELECT re.supplier_id, re.user_id, re.total, d.product_id , d.quantity, d.price, d.percent 
            FROM receipt as re join supplier as s on s.id_supplier = re.supplier_id
                                join user as us on us.id_user = re.user_id
                                join receipt_detail as d on d.receipt_id = re.id_receipt
                                join product as p on p.id_product = d.product_id
            
            ";
                                
    $db ->insert('receipt', $data);
        $id_receipt = $db ->conn->insert_id;
        $receipt_data = array(
        "receipt_id" => $id_receipt,
        "product_id" => $_POST["product_id"], 
        "quantity" => $_POST["quantity"],
        "price" => $_POST["price"], 
        "percent" => $_POST["percent"], 
        );

    $db->insert('receipt_detail', $receipt_data);

    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $percent = $_POST['percent'];

    $sql = "UPDATE product SET quantity = quantity + {$quantity}, price = {$price} + {$price} * {$percent}  WHERE id_product = {$product_id}";
    $db->query($sql);

    $db->close();
 }
?>

<form method="post">

    <div id="form_adddh" class="content-formaddnhanvien">

        
        <div class="row">

            <!-- <div class="form1">
                <label class="labelnhanvien">Mã đơn hàng: </label>
                <input class="form-control" type="text">
            </div> -->

            <!-- <div class="form1">
                <label class="labelnhanvien">Loại đơn hàng: </label><br>
                <div class="chon">
                    <input id="" type="radio" name="hangnhap" class="check-type"><label class="labeldonhang" for="">Đơn hàng nhập</label>
                    <input id="" type="radio" name="hangxuat" class="check-type"><label class="labeldonhang" for="">Đơn hàng xuất</label>
                    <input id="" type="radio" name="hangloi" class="check-type"><label class="labeldonhang" for="">Đơn hàng lỗi</label>
                </div>
            </div> -->

            <!-- <div class="form1">
                <label class="labelnhanvien">Mã khách hàng: </label>
                <input class="form-control" type="text">
            </div> -->

            <div class="form1">
                <label class="labelnhanvien">Nhà cung cấp: </label>
                <select class="cbo" name="supplier_id" id="">
                    <?php
                
                $sql = "SELECT * FROM supplier";
                $result = $db->query($sql);
                while($rows = mysqli_fetch_array($result)){
            ?>

                        <option value="<?php echo $rows["id_supplier"]; ?>"><?php echo $rows["name"];?></option>
                        <?php }?>
                </select>
            </div>

            <div class="form1">
                <label class="labelnhanvien">Nhân viên: </label>
                <select class="cbo" name="user_id" id="">
                    <?php
                
                $sql = "SELECT *, user.name as user_name FROM user, type where user.type = type.id_type and type.id_type = '1'";
                $result = $db->query($sql);
                while($rows = mysqli_fetch_array($result)){
            ?>

                        <option value="<?php echo $rows["id_user"]; ?>"><?php echo $rows["user_name"];?></option>
                        <?php }?>
                    </select>
            </div>
            
            <div class="form1">
                <label class="labelnhanvien">Tổng tiền: </label>
                <input class="form-control" id="total" name="total" type="text" >
            </div>

            <!-- <div class="form1">
                <label class="labelnhanvien">Ngày tạo đơn hàng: </label>
                <input class="form-control" type="date">
            </div> -->

            <hr>
            <h1 class="thongso">Chi tiết đơn hàng nhập</h1>

            <div class="form1">
                <label class="labelnhanvien">Sản phẩm: </label>
                <select class="cbo" name="product_id" id="">
                    <?php
                
                $sql = "SELECT * FROM product";
                $result = $db->query($sql);
                while($rows = mysqli_fetch_array($result)){
            ?>

                        <option value="<?php echo $rows["id_product"]; ?>"><?php echo $rows["name"];?></option>
                        <?php }?>
                </select>
            </div>

            <div class="form1">
                <label class="labelnhanvien">Số lượng: </label>
                <input class="form-control" id="soluong" name="quantity" type="number" min="0" step="1" oninput="result()" >
            </div>

            <div class="form1">
                <label class="labelnhanvien">Giá gốc: </label>
                <input class="form-control" id="price" name="price" type="number" oninput="result()">
            </div>

            <div class="form1">
                <label class="labelnhanvien">Phần trăm: </label>
                <input class="form-control" id="percent" name="percent" type="number" min="0" step="0.01" oninput="result()">
            </div>

            <div id="form1"></div>
            
            <button class="addspmoi" type="button" class="" onclick="addSPtrongDH();">Thêm sản phẩm </button>
            
            
            <div class="form1">
                <button onclick="location.href='Index.php?id=qldh';" name="submitDH" class="add-donhang" type="submit" title="Lưu" id=""><i class="icon1 ti-save"></i>Tạo đơn hàng</button>
                <button onclick="location.href='Index.php?id=qldh';" class="add-nhanvien" type="button" title="Hủy" id=""><i class="icon1 ti-trash"></i>Hủy bỏ</button>

            </div>

        </div>

        <div class="">
            

        </div>

    </div>
</form>



<script>
    function result() {
    // Lấy giá trị của số a và b từ ô input
        // var a = parseFloat(document.getElementById("price").value);
        // var b = parseFloat(document.getElementById("percent").value);
        // var c = parseFloat(document.getElementById("quantity").value);

        var a = document.getElementById("price").value;
        var b = document.getElementById("percent").value;
        var c = document.getElementById("soluong").value;


        let sum = 0;
        a = parseFloat(a);
        b = parseFloat(b);
        c = parseFloat(c);

        // Tính tổng của a và b
        // var sum = (a + (a * b)) * c;
        // sum = (parseFloat(a) + (parseFloat(a) * parseFloat(b))) * parseFloat(c);
        sum = (a + (a * b)) * c;
        var formattedSum = sum.toLocaleString('de-DE'); // đổi thành tiền
        

        // Hiển thị kết quả tính toán trên ô kết quả
        document.getElementById("total").value = sum;
    }
    
</script>




