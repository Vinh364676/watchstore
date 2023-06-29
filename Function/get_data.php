<?php
require '../db/connect.php';
$db = new Database();
?>

<?php
// Tạo đối tượng Database và kết nối đến cơ sở dữ liệu
if(isset($_GET['id_product'])){
$id_product = $_GET['id_product'];// Lấy product_id từ yêu cầu Ajax POST

        $sql = "SELECT p.id_product, p.name, p.img, p.price, p.quantity, 
                m.name AS material_wire_name, 
                mg.name AS material_glass_name,
                pi.name AS name_pin, 
                c.name AS name_category, 
                b.name AS name_brand, pd.color, pd.size, pd.origin, pd.code, pd.description, pd.shape
                FROM product AS p 
                JOIN material_wire AS m ON p.material_wire_id = m.id_material_wire
                join product_detail as pd on p.id_product = pd.id_product
                JOIN material_glass AS mg on p.material_glass_id = mg.id_material_glass
                JOIN pin as pi ON p.pin_id = pi.id_pin
                JOIN brand as b ON p.brand_id = b.id_band
                JOIN category as c ON p.category_id = c.id_category
                WHERE p.id_product = $id_product";
                
$result = $db->query($sql);

// Đưa thông tin sản phẩm vào một mảng kết quả
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $data = array(
        'name' => $row['name'],
        'code' => $row['code'],
        'quantity' => $row['quantity'],
        'color' => $row['color'],
        'origin' => $row['origin'],
        'size' => $row['size'],
        'description' => $row['description'],
        'shape' => $row['shape'],
        'img' => 'imgsql/' . $row['img'],
        'material_wire_name' => $row['material_wire_name'],
        'material_glass_name' => $row['material_glass_name'],
        'name_pin' => $row['name_pin'],
        'name_brand' => $row['name_brand'],
        'name_category' => $row['name_category'],
        
    );
} else {
    $data = array();
}

// Trả về thông tin sản phẩm dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($data);
}

else if(isset($_GET['id_account'])){


    $id_account = $_GET['id_account'];// Lấy product_id từ yêu cầu Ajax POST
    
            $sql = "SELECT tk.create_date, tk.id_account, tk.user_id, tk.user_name, tk.password, tk.status, us.name as name_display, r.name as role_display
            FROM account as tk 
            join user as us on tk.user_id = us.id_user 
            join role as r on us.role_id = r.id_role
                    WHERE tk.id_account = $id_account";
                    
    $result = $db->query($sql);
    
    // Đưa thông tin sản phẩm vào một mảng kết quả
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $data = array(
            'user_name' => $row['user_name'],
            'password' => $row['password'],
        );
    } else {
        $data = array();
    }
    
    
    // Trả về thông tin sản phẩm dưới dạng JSON
    header('Content-Type: application/json');
    echo json_encode($data);
    }
else if(isset($_GET['id_bill'])){

        $id_bill = $_GET['id_bill'];// Lấy product_id từ yêu cầu Ajax POST        
                $sql = "SELECT b.id_bill, b.fullname, b.total_price, b.deliver_address, b.create_date, b.user_id, bd.unit_price, p.name as name_product, bd.quantity, p.img, p.id_product, v.code, v.value, CASE WHEN b.status_bill = 2 THEN 'Đã hoàn thành' 
                     WHEN b.status_bill = 1 THEN 'Đang xử lý' 
                     ELSE 'Không rõ'END as status_display
                     FROM bill AS b JOIN bill_detail as bd ON b.id_bill = bd.id_bill
                     join product as p on bd.id_product = p.id_product
                     join voucher as v on b.voucher_id = v.id_voucher
                     WHERE b.id_bill = '$id_bill'
                     ORDER BY id_bill ASC ";
                        
        $result = $db->query($sql);
        
        // Đưa thông tin sản phẩm vào một mảng kết quả
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $data = array(
                'fullname' => $row['fullname'],
                'create_date' => $row['create_date'],
                'deliver_address' => $row['deliver_address'],
                'quantity' => $row['quantity'],
                'unit_price' => $row['unit_price'],
                'code' => $row['code'],
                'name_product' => $row['name_product']
            );
        } else {
            $data = array();
        }
        
        
        // Trả về thông tin sản phẩm dưới dạng JSON
        header('Content-Type: application/json');
        echo json_encode($data);
        }  
// Đóng kết nối đến cơ sở dữ liệu
$db->close();
?>