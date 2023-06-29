<div id="form_ganquyen" class="content">

    <div class="content-header">

        <div style="display: list-item;" id="clock"></div>

    </div>

    <div class="content-mid">

        <!-- <label class="labelnhanvien">Phân quyền : </label> -->


    </div>

    <div class="form-dsnguoidung">

        <h1>Gán quyền</h1>

        <label style="margin-left: 25px;" class="labelnhanvien">Tên quyền : </label>
        <select style="width: 20%" class="cbo" name="role_id" id="selectedRoleId">
            <?php
               
               $sql = "SELECT * FROM role";
               $result = $db->query($sql);
               while($rows = mysqli_fetch_array($result)){
           ?>

            <option value="<?php echo $rows["id_role"]; ?>"><?php echo $rows["name"];?></option>
            <?php }?>
        </select>

        <div class="form-baocao">
            <?php
            $sql = "SELECT * FROM action";
            $result = $db->query($sql);
            
            while($rows = mysqli_fetch_array($result)){ ?>
            <div class="muccheck1">
                <div class="tonghop">

                    <h4><?php echo $rows["name"];?></h4>
                    <input id="nguoidung" data-id="<?php echo $rows["name"];?>" class="check1 chontatca"
                        type="checkbox"> <label class="chiso"> Tất cả
                    </label> <br>
                    <input id="nguoidungthem" class="check1" type="checkbox"> <label class="chiso"> Thêm
                        <?php echo $rows["name"];?>
                    </label><br>
                    <input id="nguoidungsua" class="check1" type="checkbox"> <label class="chiso"> Sửa
                        <?php echo $rows["name"];?>
                    </label><br>
                    <input id="nguoidungxoa" class="check1" type="checkbox"> <label class="chiso"> Xóa
                        <?php echo $rows["name"];?>
                    </label><br>
                </div>
            </div>
            <?php } ?>
            <button onclick="location.href='Index.php?id=qlq';" href="" class="add-nhanvien" type="submit"
                name="submitRole" title="Lưu" id=""><i class="icon1 ti-save"></i>Lưu</button>
        </div>

        <div class="footer">
            <a href="Index.php?id=qlq" class="add" type="button" title="Quản lý quyền" id=""><i
                    class="icon1 ti-hand-point-left"></i>Quản lý quyền</a>
        </div>

    </div>

    <script>
    jQuery(document).ready(function() {
        jQuery('.chontatca').click(function(e) {
            if (jQuery(this).is(':checked')) {
                var sib = $(this).siblings('.check1')
                for (let i = 0; i < sib.length; i++) {
                    sib[i].setAttribute("checked", "checked");
                }
            } else {
                var sib = $(this).siblings('.check1')
                for (let i = 0; i < sib.length; i++) {
                    sib[i].removeAttribute('checked');
}
            }
        });

        jQuery('.check1').click(function(e) {
            if (jQuery(this).is(':checked')) {
                this.setAttribute("checked", "checked");
            } else {
                this.removeAttribute('checked');
            }
        });
    });
    </script>

    <script>
    jQuery(document).ready(function() {
        jQuery('#selectedRoleId').change(function() {
            var roleId = $('#selectedRoleId').find(":selected").val();
            console.log(roleId);
        });
    });
    </script>
