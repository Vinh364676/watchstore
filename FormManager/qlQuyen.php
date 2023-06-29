
<div id="qlq" class="content">

    <div class="content-header">

        <div id="clock"></div>
        
    </div>
    
    <div class="content-mid">
        
        <a href="Index.php?id=form_addquyen" class="add" type="button" title="Thêm" id=""><i class="icon1 "></i>Thêm quyền</a>
        <a href="Index.php?id=form_ganquyen" class="add" type="button" title="Thêm" id=""><i class="icon1 "></i>Gán quyền</a>
        <!-- <label class="form-timkiem" for="">Tìm kiếm: 
            <input type="search" id="search_voucher" class="search"><button class="ti-search" type="button" title="Tìm kiếm" id="" ></button>
        </label> -->

    </div>

    <div class="form-dsnguoidung">
        
        <h1>Quản lý quyền</h1>

        <div class="form1 formchonloc">
            <label class="labelnhanvien">Lọc: </label>
            <select class="cbo chonloc" name="type" id="">
                <option>Theo thứ tự từ a -> z</option>
                <option>Theo thứ tự từ z -> a</option>
            </select>
        </div>

        <table id="table_data_q"  width="100%" border="3" cellspacing="2px" align="center" bordercolor = "aquamarine">
            <thead >
                <tr style="height: 60px;">
                    <th width="20%">ID</th>
                    <th width="60%">Tên quyền</th>
                    <th width="20%">Tính năng</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <?php
                // $db = new Database();
                $sql = "SELECT *
                FROM role";
                $result = $db->query($sql);

                while($rows = mysqli_fetch_array($result)){
            ?>
                    <tr>
                        <td align="center"><?php echo $rows["id_role"];?></td>
                        <td align="center"><?php echo $rows["name"];?></td>
                        <td align="center"><button data-id="<?php echo $rows["id_role"];?>" href="" class="tinhnang1" type="button" title="Xóa" id=""><i class="icon1 ti-trash"></i></button>  <button href="" class="tinhnang2 js-change-role" type="button" title="Sửa" id=""><i class="icon1 ti-marker-alt"></i></button></td>
                    </tr>

                <?php }?>
            </tr>
                
                
               
            </tbody>
        </table>

    </div>


    <div class="footer">
        <a href="Index.php?id=qltk" class="add" type="button" title="Quản lý tài khoản" id=""><i class="icon1 ti-hand-point-left"></i>Quản lý tài khoản</a>
    </div>

</div>

