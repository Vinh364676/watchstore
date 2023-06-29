<?php
    require '../db/connect.php';
    $db = new Database();
?>



<!-- Search Thong tin -->
<?php
      
      $output_infor = '';
      if(isset($_POST['input_infor'])){
        $input_infor = $_POST['input_infor'];
        $results_infor = $db->search('user', 'name', $input_infor,
        'role', 'user.role_id = role.id_role',
    );
        
        // $qr = mysqli_query($conn,$sql);
        if($results_infor->num_rows > 0){?>
          $output_infor = " <thead >
                <tr style="height: 60px;">
                    <th width="4%">ID</th>
                    <th width="16%">Họ và tên</th>
                    <th width="16%">Địa chỉ</th>
                    <th width="16%">Email</th>
                    <th width="8%">Số điện thoại</th>
                    <th width="8%">Ngày sinh</th>
                    <th width="8%">Giới tính</th>
                    <th width="8%">Phân loại</th>
                    <th width="8%">Phân quyền</th>
                    <th width="8%">Tính năng</th>
                </tr>
            </thead>"

           
            <tbody>
            <?php
                while($rows =$results_infor->fetch_assoc()){
                  
            ?>
                <tr>
                <td><?php echo $rows["id_user"];?></td>
                    <td><?php echo $rows["name"];?></td>
                    <td><?php echo $rows["address"];?></td>
                    <td><?php echo $rows["email"];?></td>
                    <td><?php echo $rows["phone"];?></td>
                    <td><?php echo $rows["birthday"];?></td>
                    <td><?php echo $rows["gender_display"];?></td>
                    <td><?php echo $rows["name_type"];?></td>
                    <td><?php echo $rows["role.name"];?></td>
                    <td align="center"><button href="" class="tinhnang1" type="button" title="Xóa" id=""><i class="icon1 ti-trash"></i></button>  <button href="" class="tinhnang2 js-change-nhanvien" type="button" title="Sửa" id=""><i class="icon1 ti-marker-alt"></i></button></td>  
                </tr>
               
                <?php }?>
            </tbody>
            
          <?php
          echo $output_infor;
        } else{
            echo "No data";
        } 
      }
?>
