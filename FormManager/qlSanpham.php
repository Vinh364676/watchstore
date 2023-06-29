<div id="qlsp" class="content">

    <div class="content-header">

        <div id="clock">
        </div>

    </div>

    <div class="content-mid">

        <a href="Index.php?id=form_addsp" class="add" type="button" title="Thêm" id="add_sp"><i
                class="icon1 ti-plus"></i>Thêm sản phẩm</a>
        <!-- <a href="" class="print" type="button" title="Xuất" id=""><i class="icon1 ti-printer"></i>Xuất file Excel</a> -->
        <label class="form-timkiem" for="">Tìm kiếm:
            <input type="search" id="txtsearch" class="search"><button class="ti-search" type="button" title="Tìm kiếm"
                id=""></button>
        </label>

    </div>

    <div class="form-dssanpham">

        <h1>Danh sách sản phẩm</h1>
        <form method="post">
            <div class="form1 formchonloc">
                <label class="labelnhanvien">Lọc: </label>
                <select class="cbo chonloc" name="type" id="type" onchange="filterData()">
                    <option value="asc">Theo thứ tự từ a -> z</option>
                    <option value="desc">Theo thứ tự từ z -> a</option>
                </select>

            </div>
        </form>


        <table id="table_data" width="100%" border="3" cellspacing="2px" align="center" bordercolor="aquamarine">
            <thead>
                <tr style="height: 60px;">
                    <th width="2%">ID</th>
                    <th width="13%">Tên</th>
                    <th width="6%">Ảnh</th>
                    <!-- <th width="14%">Nhóm</th> -->
                    <th width="13%">Code</th>
                    <th width="6%">Giá bán</th>
                    <th width="6%">Số lượng</th>
                    <th width="6%">Dây</th>
                    <th width="6%">Kính</th>
                    <th width="6%">Pin</th>
                    <th width="6%">Màu</th>
                    <th width="6%">Size</th>
                    <th width="6%">Thương hiệu</th>
                    <th width="6%">Danh mục</th>
                    <th width="6%">Xuất xứ</th>
                    <th width="6%">Tính năng</th>
                </tr>
            </thead>
            <tbody id="table-body">

                <!--  -->
                <tr>
                    <?php
               $data = $db->select("SELECT p.id_product, p.name AS name_product, p.img, p.price, p.quantity, mw.name AS name_wire, mg.name AS name_glass, pi.name AS name_pin, b.name AS name_brand,c.name AS name_category, pd.color, pd.size, pd.origin, pd.code
               FROM product AS p 
               JOIN material_wire mw ON p.material_wire_id = mw.id_material_wire
               join product_detail as pd on p.id_product = pd.id_product
               JOIN material_glass AS mg on p.material_glass_id = mg.id_material_glass
               JOIN pin as pi ON p.pin_id = pi.id_pin
               JOIN brand as b ON p.brand_id = b.id_band
               JOIN category as c ON p.category_id = c.id_category  
               WHERE p.is_deleted = 0"); 

                $db->close();
                // $lastCode = null;
                
                foreach ($data as $rows) {

                ?>

                <tr data-id="<?php echo $rows["id_product"];?>">
                    <td><?php echo $rows["id_product"];?></td>
                    <td id="name_product"><?php echo $rows["name_product"];?></td>
                    <td><?php echo '<img src="./imgsql/'.$rows["img"].'" width="100%"'?></td>
                    <td><?php echo $rows["code"];?></td>
                    <td><?php echo number_format($rows['price'],0,',','.')?>đ</td>
                    <td><?php echo $rows["quantity"];?></td>
                    <td><?php echo $rows["name_wire"];?></td>
                    <td><?php echo $rows["name_glass"];?></td>
                    <td><?php echo $rows["name_pin"];?></td>
                    <td><?php echo $rows["color"];?></td>
                    <td><?php echo $rows["size"];?></td>
                    <td><?php echo $rows["name_brand"];?></td>
                    <td><?php echo $rows["name_category"];?></td>
                    <td><?php echo $rows["origin"];?></td>
                    <td align="center"><button type="button" name="btn_delete"
                            data-id="<?php echo $rows['id_product'];?>" class="tinhnang1 js-change-sanpham-delete"
                            title="Xóa" id="btn_delete"><i class="icon1 ti-trash"></i></button>
                        <button data-id ="<?php echo $rows['id_product'];?>"  value="<?php echo $rows['id_product'];?>" class="tinhnang2 js-change-sanpham "
                            type="submit" title="Sửa" id="btn_update"><i class="icon1 ti-marker-alt"></i></button>
                    </td>
                </tr>


                <?php } 
                ?>

                </tr>

            </tbody>
        </table>

    </div>

</div>
<!-- tim kiem san pham -->
<script>
$(document).ready(function() {
    $("#txtsearch").keyup(function() {
        var input = $(this).val();
        if (input != "") {
            $.ajax({
                url: "Function/search.php",
                method: "post",
                data: {
                    input: input
                },
                success: function(data) {
                    $("#table_data").html(data);
                }
            });
        } else {
            $("#searchresult").css("display", "none");
        }
    })
})
</script>

<!-- Select form and update -->
<script>
$(document).ready(function() {
    $('.tinhnang2').click(function() {
        $('.js-modalSP').show();
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
var materialWireText;
switch (updatedData.material_wire_id) {
  case '1':
    materialWireText = 'Dây Da';
    break;
  case '2':
    materialWireText = 'Dây Kim Loại';
    break;
  case '3':
    materialWireText = 'Dây Nhựa/Cao Su';
    break;
  case '4':
    materialWireText = 'Dây Vải';
    break;
  default:
    materialWireText = updatedData.material_wire_id;
}
tr.find('td').eq(6).text(materialWireText);

var nameGlassText;
switch (updatedData.material_glass_id) {
  case '1':
    nameGlassText = 'Kính Cứng';
    break;
  case '2':
    nameGlassText = 'Kính Sapphire';
    break;
  default:
    nameGlassText = updatedData.material_glass_id;
}
tr.find('td').eq(7).text(nameGlassText);

var namePinText;
switch (updatedData.pin_id) {
  case '1':
    namePinText = 'Máy Quartz';
    break;
  case '2':
    namePinText = 'Máy cơ';
    break;
  case '3':
    namePinText = 'Máy lên cót tay';
    break;
  case '4':
    namePinText = 'Máy lên dây tự động';
    break;
  default:
    namePinText = updatedData.pin_id;
}

tr.find('td').eq(8).text(namePinText);

tr.find('td').eq(9).text(updatedData.color);
tr.find('td').eq(10).text(updatedData.size);
var brandText;
switch (updatedData.brand_id) {
  case '1':
    brandText = 'Casio';
    break;
  case '2':
    brandText = 'Citizen';
    break;
  case '3':
    brandText = 'G-Shock & Baby-G';
    break;
  case '4':
    brandText = 'Louis Erard';
    break;
  case '5':
    brandText = 'Olym Pianus - Olympia Star';
    break;
  case '6':
    brandText = 'Orient';
    break;
  case '7':
    brandText = 'Seiko';
    break;
  case '8':
    brandText = 'Tissot';
    break;
  default:
    brandText = updatedData.brand_id;
}

tr.find('td').eq(11).text(brandText);

var categoryText;
switch (updatedData.category_id) {
  case '1':
    categoryText = 'Đồng hồ nam';
    break;
  case '2':
    categoryText = 'Đồng hồ nữ';
    break;
  case '3':
    categoryText = 'Phụ kiện';
    break;
  default:
    categoryText = updatedData.category_id;
}

tr.find('td').eq(12).text(categoryText);

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

<script>
$(document).on('click', '.tinhnang1', function() {
    var product_id = $(this).data('id');
    var tr = $(this).closest('tr');
    if (confirm("Bạn muốn xóa sản phẩm " + product_id + "?")) {


        $.ajax({
            url: 'Function/delete.php',
            type: 'POST',
            data: {
                id_product: product_id
            },
            success: function(response) {
                console.log(response);
                try {
                    var result = JSON.parse(response).result;
                    console.log(result);
                    if (result === "success") {
                        alert("Xóa sản phẩm thành công!");
                        tr.remove();
                    } else if (result === "error") {
                        alert("Không thể xóa sản phẩm do còn hóa đơn chưa hoàn thành!");
                    } else if (result === "complete") {
                        alert("Sản phẩm có hóa đơn đã hoàn thành, sẽ ẩn đi nhưng không thể xóa!");
                        tr.css("display", "none");
                    } else {
                        alert("Xóa sản phẩm thất bại!");
                    }
                } catch (error) {
                    console.log(error);
                    alert("Xóa sản phẩm thất bại!");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Xử lý lỗi nếu có
                console.log(textStatus, errorThrown);
            }

        });
    }
});
</script>

<script>
$("#avatar").change(function() {
    var reader = new FileReader();
    reader.onload = function(event) {
        $('#img').attr('src', event.target.result);
    };
    reader.readAsDataURL(this.files[0]);
});
$('#removeAvatar').click(function() {
    if ($(this).is(':checked')) {
        // Xóa ảnh hiện tại
        $('#img').attr('src', '');
        // Đặt giá trị của trường input file avatar về null
        $('#avatar').val(null);
        // Đặt giá trị của trường avatar trong đối tượng FormData về null để xóa ảnh trên máy chủ
        formData.set('avatar', null);
    }
});
</script>

<script>
function filterData() {
    var value = $('#type').val(); // lấy giá trị của thẻ select
    console.log(value);
    $.ajax({
        type: "POST", // phương thức gửi dữ liệu
        url: "filter.php", // đường dẫn xử lý dữ liệu
        data: {
            type: value
        }, // dữ liệu gửi đi (giá trị của thẻ select)
        success: function(data) {
            console.log(data);
            $('#table-body').html(data);
        }
    });
}
</script>