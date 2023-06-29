<?php
    require "../db/connect.php";
    $db = new Database();
?>  
<?php
if (isset($_POST['id_product'])) {
  $id = $_POST['id_product'];

  // Kiểm tra xem sản phẩm có tồn tại trong bảng bill_detail hay không
  $query = "SELECT COUNT(*) as count FROM bill_detail WHERE id_product = $id";
  $result = $db->select($query);
  $count = $result[0]['count'];

  if ($count == 0) {
      // Trường hợp 1: sản phẩm không nằm trong bảng bill_detail
      $where = "id_product = $id";
      $result = $db->delete("product", $where);

      if ($result) {
          $response = array("result" => "success");
      } else {
          $response = array("result" => "failure");
      }
  } else {
      // Trường hợp 2, 3: sản phẩm nằm trong bảng bill_detail
      $query = "SELECT bill.status_bill 
                FROM bill 
                INNER JOIN bill_detail ON bill_detail.id_bill = bill.id_bill 
                WHERE bill_detail.id_product = $id AND bill_detail.is_deleted = 0 ";
      $statuses = $db->select($query);

      $allow_delete = true;
      foreach ($statuses as $status) {
          if ($status['status_bill'] != 2) {
              // Trường hợp 2: sản phẩm nằm trong bảng bill_detail với tình trạng chưa xử lý
              $allow_delete = false;
              break;
          } else {
              // Trường hợp 3: sản phẩm nằm trong bảng bill_detail với tình trạng đã hoàn thành
              $where = "id_product = $id";
              $result = $db->update("product", ["is_deleted" => 1], $where);

              $where = "id_product = $id";
              $result = $db->update("bill_detail", ["is_deleted" => 1], $where);

              if ($result) {
                  $response = array("result" => "complete");
              } else {
                  $response = array("result" => "failure");
              }
          }
      }

      if ($allow_delete == false) {
          $response = array("result" => "error");
      }
  }

  echo json_encode($response);
}


  
  else if (isset($_POST['id_user'])) {
    // xóa người dùng
    $id = $_POST['id_user'];
    $where = "id_user = $id";
    $result = $db->delete("user", $where);
  
    if ($result) {
      echo "Xóa người dùng thành công";
    } else {
      echo "Xóa người dùng không thành công";
    }
  }  
  
  else if (isset($_POST['id_account'])) {
    // xóa tài khoản
    $id = $_POST['id_account'];
    $where = "id_account = $id";
    $result = $db->delete("account", $where);
  
    if ($result) {
      echo "Xóa tài khoản thành công";
    } else {
      echo "Xóa tài khoản không thành công";
    }
  }

  else if (isset($_POST['id_cereipt'])) {
    // xóa đơn hàng
    $id = $_POST['id_cereipt'];
    $where = "id_receipt = $id";
    $result = $db->delete("receipt", $where);
  
    if ($result) {
      echo "Xóa tài khoản thành công";
    } else {
      echo "Xóa tài khoản không thành công";
    }
  }
  
  else if (isset($_POST['id_supplier'])) {
    // xóa nhà cung cấp
    $id = $_POST['id_supplier'];
    $where = "id_supplier = $id";
    $result = $db->delete("supplier", $where);
  
    if ($result) {
      echo "Xóa nhà cung cấp thành công";
    } else {
      echo "Xóa nhà cung cấp thành công";
    }
  }

  else if (isset($_POST['id_voucher'])) {
    // xóa nhà cung cấp
    $id = $_POST['id_voucher'];
    $where = "id_voucher = $id";
    $result = $db->delete("voucher", $where);
  
    if ($result) {
      echo "Xóa voucher thành công";
    } else {
      echo "Xóa voucher không thành công";
    }
  }


?>
