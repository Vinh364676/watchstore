<?php
    require "../db/connect.php";
?>
<?php
    if (isset($_POST['submit'])) {
        $id_product = $_POST['id'];
        $name = $_POST['name'];
        //$price = $_POST['price'];
      
        $db = new Database();
      
        $data = array(
          "name" => $name,
         // "price" => $price
        );
      
        $where = "id_product={$id_product}";
      
        $db->update("product", $data, $where);
      
        $db->close();
      
        header("Location: Index.php?id=qlsp");
      }
      
?>