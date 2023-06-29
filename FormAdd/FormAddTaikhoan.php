<?php
 if(isset($_POST["submitTK"])){
    // $sql = "SELECT account.user_id, user.id_user
    //         FROM account
    //         LEFT JOIN user ON user.id_user = account.user_id";
    $user_ID = $_POST['user_id'];
    $user_NAME = $_POST['user_name'];
    $sql = "SELECT user_id FROM account WHERE user_id = '$user_ID'";
    $sql1 = "SELECT user_name FROM account WHERE user_name = '$user_NAME'";
    $result = $db->query($sql);
    $result1 = $db->query($sql1);
    if($_POST['password'] == $_POST['password2'] && $result->num_rows <= 0 && $result1->num_rows <= 0){
        $data = array(
            "user_id" => $_POST['user_id'],
            "user_name" => $_POST['user_name'],
            "password" => $_POST['password'],
            // "status" => $_POST['status'],
        );

        // $sql = "SELECT tt.id_user, tt.name, tt.address, tt.phone, tt.email, tt.type, tt.role_id, tt.birthday, tt.gender
        // FROM user as tt ";

        $sql = "SELECT tk.user_id, tk.user_name, tk.password, tk.status
                    FROM account as tk 
                    join user as us on tk.user_id = us.id_user ";

        
        $db->insert('account', $data);
        
        $db->close();

        
        
        
    } else if ($result->num_rows > 0 ){
        echo '<script type = "text/javascript">
        window.onload = function(){ alert("Người dùng đã có tài khoản");}
        </script>';
    } else if ($result1->num_rows > 0 ){
        echo '<script type = "text/javascript">
        window.onload = function(){ alert("Tên đăng nhập đã tồn tại");}
        </script>';
    } else {
        echo '<script type = "text/javascript">
                window.onload = function(){ alert("Mật khẩu không trùng khớp");}
                </script>';
    }
 }
?>

<form method="post">

    <div id="form_addnd" class="content-formaddnhanvien">

            
        <div class="row">

            <div class="form1">
                <label class="labelnhanvien">Tên người dùng: </label>
                <select class="cbo" name="user_id" id="">
                    <?php
                
                $sql = "SELECT * FROM user";
                $result = $db->query($sql);
                while($rows = mysqli_fetch_array($result)){
            ?>

                        <option value="<?php echo $rows["id_user"]; ?>"><?php echo $rows["name"];?></option>
                        <?php }?>
                    </select>
            </div>

            <div class="form1">
                <label class="labelnhanvien">Tên đăng nhập: </label>
                <input name="user_name" class="form-control" type="text">
            </div>

            <div class="form1">
                <label class="labelnhanvien">Mật khẩu: </label>
                <input name="password" class="form-control" type="text">
            </div>

            <div class="form1">
                <label class="labelnhanvien">Nhập lại mật khẩu: </label>
                <input name="password2" class="form-control" type="text">
            </div>

            <!-- <div class="form1">
                <label class="labelnhanvien">Ngày tạo tài khoản: </label>
                <input class="form-control" type="date">
            </div> -->
            
            <!-- <div class="form1">
                <label class="labelnhanvien">Trạng thái: </label>
                <select class="cbo" name="" id="">
                    
                </select>
            </div> -->

            <div class="form1">
                <button onclick="location.href='../Index.php?id=qltk';" class="add-nhanvien" type="submit" name="submitTK" title="Lưu" id=""><i class="icon1 ti-save"></i>Lưu thông tin</button>
                <button onclick="location.href='Index.php?id=qltk';" class="add-nhanvien" type="button" title="Hủy" id=""><i class="icon1 ti-trash"></i>Hủy bỏ</button>
            </div>

        </div>



        <div class="">
            

        </div>

    </div>

</form>
