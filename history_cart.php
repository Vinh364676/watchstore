<?php
 require "db/connect.php";
 $db = new Database();
 session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử đơn hàng</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <header>
        <div class="container">
            <h1>Lịch sử đơn hàng</h1>
        </div>
    </header>

    <main>
        <div class="container">
            <form method="post">
            <table class="order-history-table">
                <thead>
                    <tr>
                        <th class="order-history-table__heading">Mã đơn hàng</th>
                        <th class="order-history-table__heading">Ngày đặt hàng</th>
                        <th class="order-history-table__heading">Tổng giá trị</th>
                        <th class="order-history-table__heading">Tình trạng</th>
                        <th class="order-history-table__heading">Sản phẩm</th>
                        <th width="13%" class="order-history-table__heading"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                <?php
                $user_id = $_SESSION["user_id"];
                $data = $db->select("SELECT b.id_bill, b.create_date, b.user_id, bd.unit_price, p.name, bd.quantity, p.img, p.id_product, CASE WHEN b.status_bill = 2 THEN 'Đã hoàn thành' 
                WHEN b.status_bill = 1 THEN 'Đang xử lý' 
                ELSE 'Không rõ'END as status_display
                FROM bill AS b JOIN bill_detail as bd ON b.id_bill = bd.id_bill
                join product as p on bd.id_product = p.id_product 
                WHERE b.user_id = $user_id
                ORDER BY b.create_date DESC");
                // $lastCode = null;
                foreach ($data as $rows){
                   
                    ?>
                    <tr>
                    
                    <td name="id" class="order-history-table__data"><?php echo $rows["id_bill"];?></td>
                        <td class="order-history-table__data"><?php echo $rows["create_date"];?></td>
                        <td class="order-history-table__data"><?php echo number_format($rows["unit_price"], 0, ',', '.'); ?>đ</td>
                        <td class="order-history-table__data"><?php echo $rows["status_display"];?></td>
                        <td class="order-history-table__data">
                            <ul class="product-list">
                                <li style="display:flex;width: 483px;list-style-type: none;line-height: 50px;" class="product-list__item">
                                <img src="imgsql/<?php echo $rows['img']?>" class="img_history"
                            alt="img error" srcset="">
                                    <span class="product-list__name"><?php echo $rows["name"];?> x<?php echo $rows["quantity"];?></span>
                                </li>
                            </ul>
                        </td>
                        <td class="order-history-table__data">
                            <?php
                           if($rows['status_display'] !== 'Đã hoàn thành') {
                            echo '<button style="background-color: none; border: none; color: inherit;" name="cancel_order" value="' . $rows["id_bill"] . '" onclick="return confirm(\'Bạn có chắc chắn muốn hủy đơn hàng này không?\')" type="submit">Hủy đơn hàng</button>';
                        } else {?>
                            <a href="detail.php?id_product=<?php echo $rows['id_product']; ?>" style="color: inherit; text-decoration: none;">
                                <i style="font-size: 20px;font-style: normal;"> Mua lại </i>
                            </a>
                       <?php
                        }
                        
                            ?> 
                        </td>
                    </tr>
                       
                        <?php } 
                        ?>
                    </tr>
                </tbody>
            </table>
            <div class="back-btn">
  <a href="index1.php">Quay về trang chủ</a>
</div>
    
            </form>
        </div>
    </main>
</body>
</html>

<?php
if(isset($_POST['cancel_order'])){
    $id_bill = $_POST['cancel_order'];
    $db->query("DELETE FROM bill_detail WHERE id_bill = $id_bill");
    $db->query("DELETE FROM bill WHERE id_bill = $id_bill");    
    ?>
        <script>
            window.location.href = "history_cart.php";
        </script>
        <?php

}
?>