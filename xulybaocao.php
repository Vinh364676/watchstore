<?php
    require_once './db/connect.php'; 
    $db = new database();
?>

<?php

if(isset($_POST['id_1'])){

    $day_start = $_POST["day_start"];
    $day_end = $_POST["day_end"];
    $top = intval($_POST["top"]);
    // $top = isset($_POST["top"]) ? intval($_POST["top"]) : 3;
    $data = $db->select( "SELECT ROW_NUMBER() 
                OVER (ORDER BY SUM(bill_detail.quantity) DESC) AS thutu,
                product.id_product as ID, 
                product.name as name_product, 
                SUM(bill_detail.quantity) AS TotalQuantity,
                product.quantity AS HaveQuantity,
                product.price as giaban
                                        
            FROM product, bill_detail, bill
            where bill_detail.id_product = product.id_product 
                    and bill_detail.id_bill = bill.id_bill 
                    and bill.status_bill = '2'
                    -- and DATE_FORMAT(bill.create_date, '%Y-%m-%d') >= '$day_start' and DATE_FORMAT(bill.create_date, '%Y-%m-%d') <= '$day_end'
                    and bill.create_date>= '$day_start' and bill.create_date <= '$day_end'
                                
            GROUP BY product.id_product, product.name, product.quantity, product.price, bill_detail.id_product
            ORDER BY TotalQuantity DESC
            limit $top
            ");
    $html = '';
    foreach ($data as $rows) {
        $html .= '<tr align="center" style="height: 60px;">';
        $html .= '<td>' . $rows["thutu"] . '</td>';
        $html .= '<td>' . $rows["ID"] . '</td>';
        $html .= '<td>' . $rows["name_product"] . '</td>';
        $html .= '<td>' . $rows["TotalQuantity"] . '</td>';
        $html .= '<td>' . $rows["HaveQuantity"] . '</td>';
        $html .= '<td>' . number_format($rows['giaban'], 0, ',', '.') . 'đ' . '</td>';
        $html .= '</tr>';

    }
    echo $html; // trả về kết quả cho Ajax

}

else if(isset($_POST['id_2'])){
    $brand = $_POST['brand'];
    $start = $_POST['start'];
    $end = $_POST['end'];

    if($brand != "all"){
        $data = $db->select("SELECT ROW_NUMBER() 
                                OVER (ORDER BY bill.create_date ASC) AS thutu,
                                product.id_product as ID, 
                                product.name as name_product, 
                                brand.name as name_brand, 
                                bill_detail.quantity AS TotalQuantity,
                                product.price as giaban,
                                bill.fullname as name_customer,
                                bill.create_date as create_date
                                                        
                            FROM product, bill_detail, bill, brand
                            where bill_detail.id_product = product.id_product 
                                    and brand.id_band = product.brand_id
                                    and bill_detail.id_bill = bill.id_bill 
                                    and bill.status_bill = '2'
                                    and DATE_FORMAT(bill.create_date, '%Y-%m-%d') >= '$start' and DATE_FORMAT(bill.create_date, '%Y-%m-%d') <= '$end'
                                    and product.brand_id = '$brand'
                                    
                            ORDER BY bill.create_date ASC
                            ");
    }
    else {
        $data = $db->select("SELECT ROW_NUMBER() 
                                OVER (ORDER BY bill.create_date ASC) AS thutu,
                                product.id_product as ID, 
                                product.name as name_product, 
                                brand.name as name_brand, 
                                bill_detail.quantity AS TotalQuantity,
                                product.price as giaban,
                                bill.fullname as name_customer,
                                bill.create_date as create_date
                                
                            FROM product, bill_detail, bill, brand
                            where bill_detail.id_product = product.id_product 
                                    and brand.id_band = product.brand_id
                                    and bill_detail.id_bill = bill.id_bill 
                                    and bill.status_bill = '2'
                                    and DATE_FORMAT(bill.create_date, '%Y-%m-%d') >= '$start' and DATE_FORMAT(bill.create_date, '%Y-%m-%d') <= '$end'
                                    
                            
                            ORDER BY bill.create_date ASC
                ");
    }

    $html = '';
    foreach ($data as $rows) {
        $html .= '<tr align="center" style="height: 60px;">';
        $html .= '<td>' . $rows["thutu"] . '</td>';
        $html .= '<td>' . $rows["ID"] . '</td>';
        $html .= '<td>' . $rows["name_product"] . '</td>';
        $html .= '<td>' . $rows["name_brand"] . '</td>';
        $html .= '<td>' . $rows["TotalQuantity"] . '</td>';
        $html .= '<td>' . $rows["create_date"] . '</td>';
        $html .= '<td>' . number_format($rows['giaban'], 0, ',', '.') . 'đ' . '</td>';
        $html .= '<td>' . $rows["name_customer"] . '</td>';
        $html .= '</tr>';

    }
    echo $html; // trả về kết quả cho Ajax
}

else if(isset($_POST['id_3'])){
    $value = $_POST['value'];
    $start_day = $_POST['start_day'];
    $end_day = $_POST['end_day'];

    $data = $db->select("SELECT ROW_NUMBER() 
                            OVER (ORDER BY b.create_date ASC) AS thutu, b.id_bill, b.fullname, b.total_price, b.deliver_address, b.create_date, b.user_id, bd.unit_price, p.name, bd.quantity, p.img, p.id_product, v.value, 
                            CASE 
                                WHEN b.status_bill = 2 THEN 'Đã hoàn thành' 
                                WHEN b.status_bill = 1 THEN 'Đang xử lý' 
                                ELSE 'Không rõ' 
                                END as status_display
                        FROM bill AS b 
                        JOIN bill_detail AS bd ON b.id_bill = bd.id_bill
                        JOIN product AS p ON bd.id_product = p.id_product
                        JOIN voucher AS v ON b.voucher_id = v.id_voucher
                        WHERE b.status_bill = $value -- Lọc các sản phẩm đã hoàn thành
                        AND b.create_date >= '$start_day' AND b.create_date <= '$end_day'
                        ORDER BY b.create_date ASC
                        ");

    $html = '';
    foreach ($data as $rows) {
        $html .= '<tr align="center" style="height: 60px;">';
        $html .= '<td>' . $rows["thutu"] . '</td>';
        $html .= '<td>' . $rows["id_bill"] . '</td>';
        $html .= '<td>' . $rows["status_display"] . '</td>';
        $html .= '<td>' . $rows["create_date"] . '</td>';
        $html .= '<td>' . number_format($rows['total_price'], 0, ',', '.') . 'đ' . '</td>';
        $html .= '<td>' . $rows["fullname"] . '</td>';
        $html .= '</tr>';

    }
    echo $html; // trả về kết quả cho Ajax
}


?>