<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Watch</title>
    <link rel="stylesheet" href="./assets/css/StyleGiaodien.css">
    <link rel="stylesheet" href="./assets/css/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="./assets/css/StyleQuanly.css">
    <link rel="stylesheet" href="./assets/css/Sua.css">
    <link rel="stylesheet" href="./assets/css/Donhang.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.17.1/dist/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.core.min.js"></script>

</head>
<body onload="time()">
    <div class="Main">
    <?php
        require "db/connect.php";
        $db = new Database();
    ?>  
    
        <?php
        include 'Trangchuql.php'; 
         if(isset($_COOKIE['user_name'])){
            include 'Body.php'; 
         } else
         {
            echo '<script>';
            echo 'alert("Bạn cần đăng nhập để truy cập nội dung này.");';
            echo 'window.location.href = "index1.php";'; // Thay đổi URL tương ứng với trang index của bạn
            echo '</script>';         }?>
        <script src="./JS/clock.js"></script>
        <script src="./JS/changeNV.js"></script>
        <script src="./JS/changeTK.js"></script>
        <script src="./JS/changeDH.js"></script>
        <script src="./JS/changeSP.js"></script>
        <script src="./JS/changeNCC.js"></script>
        <script src="./JS/changeHD.js"></script>
        <script src="./JS/changeVC.js"></script>
        <script src="./JS/changeRole.js"></script>
        <script src="./JS/uploadimg.js"></script>
        <script src="./JS/AddSP.js"></script>
        <script src="./JS/AddDH.js"></script>

       
    </div>
</body>
</html>
