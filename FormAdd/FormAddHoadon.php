<div id="form_addhd" class="content-formaddnhanvien">

    
    <div class="row">

        <div class="form1">
            <label class="labelnhanvien">Tên khách hàng: </label>
            <input class="form-control" type="text">

        </div>

        <div class="form1">
            <label class="labelnhanvien">Địa chỉ giao hàng: </label>
            <input class="form-control" type="text">
        </div>

        <!-- <div class="form1">
            <label class="labelnhanvien">Tình trạng: </label>
            <select class="cbo" name="" id="">
                <option value="">Đang xử lý</option>
                <option value="">Đã hoàn thành</option>
            </select>
        </div> -->

        <div class="form1">
            <label class="labelnhanvien">Tình trạng: </label>
            <div class="chon">
                <input value="1" id="dangxuly" type="radio" name="status" class="check-type"><label class="labeldonhang"
                    for="">Đang xử lý</label>
                <input value="2" id="dahoanthanh" type="radio" name="status" class="check-type"><label class="labeldonhang"
                    for="">Đã hoàn thành</label>
            </div>
        </div>
        
        <div class="form1">
            <label class="labelnhanvien">Sản phẩm: </label>
            <select class="cbo" name="" id="">
                
            </select>
        </div>

        
        <div class="form1">
            <label class="labelnhanvien">Giá bán: </label>
            <input class="form-control" type="text">
        </div>
        
        <div class="form1">
            <label class="labelnhanvien">Số lượng: </label>
            <input class="form-control" type="number" min="0">
        </div>
        
        
        <div id="form1"></div>
        
        <button class="addspmoi" type="button" class="" onclick="addSP();">Thêm sản phẩm </button>
        
        <hr><br>

        <div class="form1">
            <label class="labelnhanvien">Tổng tiền: </label>
            <input class="form-control" type="text">
        </div>

        <div class="form1">
            <label class="labelnhanvien">Mã giảm giá: </label>
            <input class="form-control" type="text">
        </div>

        <div class="form1">
            <label class="labelnhanvien">Tổng tiền sau khi giảm: </label>
            <input class="form-control" type="text">
        </div>
        
        <div class="form1">
            <button href="" class="add-donhang" type="button" title="Lưu" id=""><i class="icon1 ti-save"></i>Tạo đơn hàng</button>
            <button onclick="location.href='Index.php?id=qlhd';" class="add-nhanvien" type="button" title="Hủy" id=""><i class="icon1 ti-trash"></i>Hủy bỏ</button>

        </div>

    </div>

    <div class="">
        

    </div>

</div>

<script>
    $(document).ready(function() {
        $('.check-type').change(function() {
            var status = $('input[name="status"]:checked').val();
            $.ajax({
                type: "POST",
                url: "qlHoadon.php",
                data: {
                    status: status
                },
                success: function(result) {
                    console.log(result);
                }
            });
        });
    });

</script>