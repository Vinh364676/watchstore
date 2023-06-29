<?php
require "db/connect.php";
$db = new Database();
?>
<?php
if(isset($_POST['type'])){
$type = $_POST['type'];
$data = $db->select("SELECT p.id_product, p.name AS name_product, p.img, p.price, p.quantity, mw.name AS name_wire, mg.name AS name_glass, pi.name AS name_pin, b.name AS name_brand,c.name AS name_category, pd.color, pd.size, pd.origin, pd.code
                FROM product AS p JOIN material_wire mw ON p.material_wire_id = mw.id_material_wire
                join product_detail as pd on p.id_product = pd.id_product
                JOIN material_glass AS mg on p.material_glass_id = mg.id_material_glass
                JOIN pin as pi ON p.pin_id = pi.id_pin
                JOIN brand as b ON p.brand_id = b.id_band
                JOIN category as c ON p.category_id = c.id_category ORDER BY id_product $type");
// tạo lại HTML cho bảng dữ liệu
$html = '';
foreach ($data as $rows) {
        $html .= '<tr>';
        $html .= '<td>' . $rows["id_product"] . '</td>';
        $html .= '<td>' . $rows["name_product"] . '</td>';
        $html .= '<td>' . '<img src="./imgsql/' . $rows["img"] . '" width="100%" />' . '</td>';
        $html .= '<td>' . $rows["code"] . '</td>';
        $html .= '<td>' . number_format($rows['price'], 0, ',', '.') . 'đ' . '</td>';
        $html .= '<td>' . $rows["quantity"] . '</td>';
        $html .= '<td>' . $rows["name_wire"] . '</td>';
        $html .= '<td>' . $rows["name_glass"] . '</td>';
        $html .= '<td>' . $rows["name_pin"] . '</td>';
        $html .= '<td>' . $rows["color"] . '</td>';
        $html .= '<td>' . $rows["size"] . '</td>';
        $html .= '<td>' . $rows["name_brand"] . '</td>';
        $html .= '<td>' . $rows["name_category"] . '</td>';
        $html .= '<td>' . $rows["origin"] . '</td>';
        $html .= '<td align="center"><button type="button" name="btn_delete"
        data-id="' . $rows['id_product'] . '" class="tinhnang1 js-change-sanpham-delete"
        title="Xóa" id="btn_delete"><i class="icon1 ti-trash"></i></button>
    <button value="' . $rows['id_product'] . '" class="tinhnang2 js-change-sanpham filter_product_result"
        name="submit_edit" type="submit" title="Sửa" id="btn_update"><i
            class="icon1 ti-marker-alt"></i></button>
    </td>';
        $html .= '</tr>';

}
echo $html; // trả về kết quả cho Ajax
} 
else if(isset($_POST['type_view_product'])){
    $type_view_product = $_POST['type_view_product'];
$data = $db->select("SELECT p.id_product, p.name AS name_product, p.img, p.price, p.quantity, p.create_date, mw.name AS name_wire, mg.name AS name_glass, pi.name AS name_pin, b.name AS name_brand,c.name AS name_category, pd.color, pd.size, pd.origin, pd.code
                FROM product AS p JOIN material_wire mw ON p.material_wire_id = mw.id_material_wire
                join product_detail as pd on p.id_product = pd.id_product
                JOIN material_glass AS mg on p.material_glass_id = mg.id_material_glass
                JOIN pin as pi ON p.pin_id = pi.id_pin
                JOIN brand as b ON p.brand_id = b.id_band
                JOIN category as c ON p.category_id = c.id_category ORDER BY create_date $type_view_product");
$html = '';
foreach ($data as $rows) {
    $html .= '<div class="grid__item">
    <div class="grid__item-content">
        <a href="detail.php?id_product='. $rows['id_product'] .'">
            <div class="wrapper__product-img"><img src="imgsql/'. $rows['img'] .'" class="grid__item-img" alt="img error" srcset=""></div>

            <div class="grid__item-info">
                <label class="grid__item-title">'. $rows['name_category'] .'</label>
                <div class="grid__item-name black">'. $rows['name_product'] .'</div>
                <div class="grid__item-price"><strong class="red">'. number_format($rows['price'], 0, ',', '.') .'đ</strong></div>
            </div>
        </a>
    </div>
</div>';
}
echo $html; // hiển thị kết quả
}

else if(isset($_POST['type_hd'])){
    $type_hd = $_POST['type_hd'];
    $data = $db->select("SELECT b.id_bill, b.fullname,b.total_price, b.deliver_address, b.create_date, b.user_id, bd.unit_price, p.name, bd.quantity, p.img, p.id_product, v.value, 
    CASE 
        WHEN b.status_bill = 2 THEN 'Đã hoàn thành' 
        WHEN b.status_bill = 1 THEN 'Đang xử lý' 
        ELSE 'Không rõ' 
    END as status_display
FROM bill AS b 
JOIN bill_detail as bd ON b.id_bill = bd.id_bill
JOIN product as p on bd.id_product = p.id_product
JOIN voucher as v on b.voucher_id = v.id_voucher
WHERE b.status_bill = $type_hd -- Lọc các sản phẩm đã hoàn thành
   ");
$html = '';
foreach ($data as $rows) {
    $html .= '<tr>
<td>'.$rows["id_bill"].'</td>
<td>'.$rows["fullname"].'</td>
<td>'.$rows["status_display"].'</td>
<td>'.$rows["deliver_address"].'</td>
<td>'.$rows["create_date"].'</td>
<td>'.$rows["name"].'</td>
<td>'.number_format($rows["unit_price"], 0, ',', '.').'đ</td>
<td>'.$rows["quantity"].'</td>
<td>'.$rows["value"].'%</td>
<td>'.number_format($rows["total_price"], 0, ',', '.').'đ</td>
<td align="center">';
if ($rows['status_display'] == "Đã hoàn thành") {
$html .= '<button style="display: none;" type="button" name="btn_delete" data-id="'.$rows['id_bill'].'"
         class="tinhnang1 js-change-sanpham-delete" title="Xóa" id="btn_delete">
<i class="icon1 ti-trash"></i>
</button>
<button style="display: none;" value="'.$rows['id_bill'].'"
         class="tinhnang2 js-change-hoadon" name="submit_edit" type="submit" title="Sửa"
         id="btn_update">
<i class="icon1 ti-marker-alt"></i>
</button>';
} else {
$html .= '
<button value="'.$rows['id_bill'].'" class="tinhnang2 js-change-hoadon filter_bill"
         name="submit_edit" type="submit" title="Sửa" id="btn_update">
<i class="icon1 ti-marker-alt"></i>
</button>';
}
$html .= '</td>

</tr>';
}
echo $html; // hiển thị kết quả
}
?>
<script>
$(document).ready(function() {
    $('.filter_bill').click(function() {
        $('.js-modalHD').css('display', 'flex').show();
        var id_bill = $(this).val();
        console.log(id_bill);
        $.ajax({
            url: 'Function/get_data.php',
            type: 'GET',
            data: {
                id_bill: id_bill
            },
            success: function(data) {
                var createDate = data.create_date.split(" ")[0]; // tach lay ngay
                // Gán giá trị dữ liệu cho các trường trong form cập nhật
                $('#fullname').val(data.fullname);
                $('#create_date').val(createDate);
                $('#deliver_address').val(data.deliver_address);
                $('#unit_price').val(data.unit_price);
                $('#quantity_bill').val(data.quantity);
                $('#code_bill').val(data.code);
                $('#form_update_bill').data('id',
                    id_bill); // Định nghĩa giá trị id_product trong form
                console.log(data);
            }
        });
    });
    $('.btn_save').click(function(event) {

        var fullname = $('#fullname').val();
        var create_date = $('#create_date').val();
        var deliver_address = $('#deliver_address').val();
        var unit_price = $('#unit_price').val();
        var quantity = $('#quantity_bill').val();
        var code = $('#code_bill').val();
        var status = $('input[name=status]:checked').val();

        event.preventDefault();
        var id_bill = $('#form_update_bill').data('id'); // Lấy giá trị id_product từ form
        // Gửi yêu cầu Ajax để lưu cập nhật
        $.ajax({
            url: 'Function/save_data.php',
            type: 'POST',
            dataType: 'json',
            data: {
                id_bill: id_bill,
                fullname: fullname,
                create_date: create_date,
                deliver_address: deliver_address,
                unit_price: unit_price,
                quantity: quantity,
                code: code,
                status_bill: status
            },
            success: function(data) {
                console.log(data);
                // window.location.href = 'Index.php?id=qlsp';
                $('#form_update_bill').hide();

                // Xử lý kết quả trả về (nếu có)
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error: ' + errorThrown);
            }
        });

    });
});
</script>
<script>
$(document).ready(function() {
    $('.filter_product_result').click(function() {
        $('.js-modalSP').css('display', 'flex').show();
        var id_product = $(this).val();
        console.log(id_product);
        $.ajax({
            url: 'Function/get_data.php',
            type: 'GET',
            data: {
                id_product: id_product
            },
            success: function(data) {
                // Gán giá trị dữ liệu cho các trường trong form cập nhật
                $('#name').val(data.name);
                $('#code').val(data.code);
                $('#quantity').val(data.quantity);
                $('#color').val(data.color);
                $('#size').val(data.size);
                $('#origin').val(data.origin);
                $('#img').attr('src', data.img);
                $('#shape').val(data.shape);
                $('#description').val(data.description);
                $('#form_update_product').data('id',
                    id_product); // Định nghĩa giá trị id_product trong form
                console.log(data);
            }
        });
    });
    $('.btn_save').click(function(event) {
    event.preventDefault();

    var name = $('#name').val();
    var code = $('#code').val();
    var quantity = $('#quantity').val();
    var color = $('#color').val();
    var size = $('#size').val();
    var origin = $('#origin').val();
    var description = $('#description').val();
    var shape = $('#shape').val();
    var material_wire_id = $('#name_wire').val();
    console.log(material_wire_id);
    var material_glass_id = $('#name_glass').val();
    var category_id = $('#name_category').val();
    console.log(category_id);
    var pin_id = $('#name_pin').val();
    var brand_id = $('#name_brand').val();
    var removeAvatar = $('#removeAvatar').is(":checked");
    var avatar = $('#avatar').prop('files')[0];
        console.log(avatar);
    var id_product = $('#form_update_product').data('id'); // Lấy giá trị id_product từ form
    var id_product = $('#form_update_product').data('id');
    var tr = $('tr[data-id="' + id_product + '"]');
    console.log(tr);
    // Tạo đối tượng FormData và thêm các trường dữ liệu cần thiết vào
    var formData = new FormData();
    formData.append('id_product', id_product);
    formData.append('name', name);
    formData.append('code', code);
    formData.append('quantity', quantity);
    formData.append('color', color);
    formData.append('size', size);
    formData.append('origin', origin);
    formData.append('description', description);
    formData.append('shape', shape);
    formData.append('material_wire_id', material_wire_id);
    formData.append('material_glass_id', material_glass_id);
    formData.append('category_id', category_id);
    formData.append('pin_id', pin_id);
    formData.append('brand_id', brand_id);
    formData.append('removeAvatar', removeAvatar);
    formData.append('avatar', avatar);

    // Gửi yêu cầu Ajax để lưu cập nhật
    $.ajax({
        url: 'Function/save_data.php',
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        data: formData,
        success: function(data) {
            console.log(data);
            //   window.location.href = 'Index.php?id=qlsp';
            $('.js-modalSP').hide();
            var updatedData = data;
            console.log(updatedData);
console.log(updatedData.name);
console.log(updatedData.img);
console.log(updatedData.code);
// Thực hiện các thay đổi vào hàng <tr> này
tr.find('td#name_product').text(updatedData.name);
tr.find('td img').attr('src', './imgsql/' + updatedData.img);
tr.find('td').eq(3).text(updatedData.code);
tr.find('td').eq(4).text(updatedData.price);
tr.find('td').eq(5).text(updatedData.quantity);
tr.find('td').eq(6).text(updatedData.name_wire);
tr.find('td').eq(7).text(updatedData.name_glass);
tr.find('td').eq(8).text(updatedData.name_pin);
tr.find('td').eq(9).text(updatedData.color);
tr.find('td').eq(10).text(updatedData.size);
tr.find('td').eq(11).text(updatedData.name_brand);
tr.find('td').eq(12).text(updatedData.name_category);
tr.find('td').eq(13).text(updatedData.origin);


            // Xử lý kết quả trả về (nếu có)
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error: ' + errorThrown);
    console.log(jqXHR.responseText);
        }
    });
});
});
</script>
