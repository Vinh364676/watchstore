<?php
require_once '../db/connect.php'; // Import class database


//Tạo đối tượng của class database
//Tạo đối tượng của class database
$db = new database();
?>

<?php
if(isset($_POST['id_product'])){
    $id_product = $_POST['id_product'];

    // Lấy dữ liệu từ form gửi lên
    $name = $_POST['name'];
    $code = $_POST['code'];
    $quantity = $_POST['quantity'];
    $color = $_POST['color'];
    $size = $_POST['size'];
    $origin = $_POST['origin'];
    $description = $_POST['description'];
    $material_wire_id = $_POST['material_wire_id'];
    $pin_id = $_POST['pin_id'];
    $material_glass_id = $_POST['material_glass_id'];
    $brand_id = $_POST['brand_id'];
    $category_id = $_POST['category_id'];
    //$removeAvatar = $_POST['removeAvatar'];
    $avatar = $_FILES['avatar'];
    // echo '<pre>';
    // var_dump($avatar);
    // echo '</pre>';

    $file_name = $avatar["name"];
    $file_tmp = $avatar["tmp_name"];

    // Tạo đường dẫn cho tệp mới trên máy chủ
    $new_file_path = "../imgsql/" . $file_name;

    // Sao chép tệp từ vị trí ban đầu đến thư mục chứa ảnh của bạn
    if(move_uploaded_file($file_tmp, $new_file_path)) {

        $data = [
            'name' => $name,
            'code' => $code,
            'quantity' => $quantity,
            'color' => $color,
            'size' => $size,
            'origin' => $origin,
            'description' => $description,
            'material_wire_id' => $material_wire_id,
            'pin_id' => $pin_id,
            'material_glass_id' => $material_glass_id,
            'brand_id' => $brand_id,
            'category_id' => $category_id,
            'img' => $file_name
        ];

        $where = "product.id_product=$id_product";

        // Thực hiện truy vấn SQL bằng method update mới thêm
        $result = $db->update('product INNER JOIN product_detail ON product.id_product = product_detail.id_product', $data, $where);
        if ($result) {
            header('Content-Type: application/json');
            echo json_encode(array('status' => 'success','name' => $name, 'code' => $code, 'img' => $file_name, 'size' => $size,'material_wire_id' => $material_wire_id, 'category_id' => $category_id, 'material_glass_id' => $material_glass_id, 'brand_id' => $brand_id, 'quantity' => $quantity, 'color' => $color, 'description' => $description, 'pin_id' => $pin_id, 'origin' => $origin ));
        } else {
            header('Content-Type: application/json');
            echo json_encode(array('status' => 'error'));
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(array('status' => 'error', 'message' => 'Failed to upload avatar.'));
    }
}


else if(isset($_POST['id_account'])){
    $id_account = $_POST['id_account'];
    
    // Lấy dữ liệu từ form gửi lên
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    $data = [
        'user_name' => $user_name,
        'password' => $password,
    ];
    
    $where = "account.id_account=$id_account";
    
    // Thực hiện truy vấn SQL bằng method update mới thêm
    $result = $db->update('account', $data, $where);
    
    if ($result) {
        echo json_encode(array('status' => 'success'));
    } else {
        echo json_encode(array('status' => 'error'));
    }
    }

else if(isset($_POST['id_bill'])){
        $id_bill = $_POST['id_bill'];
        
        // Lấy dữ liệu từ form gửi lên
        $fullname = $_POST['fullname'];
        $deliver_address = $_POST['deliver_address'];
        $status_bill = $_POST['status_bill'];
        $unit_price = $_POST['unit_price'];
         $quantity = $_POST['quantity'];
        // $create_date = $_POST['create_date'];
        $data = [
            'fullname' => $fullname,
            'status_bill' => $status_bill,
            'deliver_address' => $deliver_address,
            'unit_price' => $unit_price,
             'quantity' => $quantity,
            // 'create_date' => $create_date
        ];
        
        $where = "bill.id_bill=$id_bill";
        
        // Thực hiện truy vấn SQL bằng method update mới thêm
        $result = $db->update('bill INNER JOIN bill_detail ON bill.id_bill = bill_detail.id_bill INNER JOIN voucher ON bill.voucher_id = voucher.id_voucher', $data, $where);
        if ($result) {
            if ($status_bill == 2) {
                $db->query("UPDATE product p 
                    INNER JOIN bill_detail bd ON p.id_product = bd.id_product 
                    INNER JOIN bill b ON bd.id_bill = b.id_bill 
                    SET p.quantity = p.quantity - bd.quantity 
                    WHERE b.status_bill = 2 AND b.id_bill = $id_bill");
            }    
            echo json_encode(array('status' => 'success','status_bill' => $status_bill));
        } else {
            echo json_encode(array('status' => 'error'));
        }
        }
?>