<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets./css./bootstrap./bootstrap-5.2.2-dist./css/bootstrap.css">
    <link rel="stylesheet" href="./assets./css./Roboto/Roboto-Medium.ttf">
    <link rel="stylesheet" href="./assets./css./themify-icons-font./themify-icons/themify-icons.css">
    <link rel="stylesheet" href="./assets./css./index.css">
    <link rel="stylesheet" href="./assets./css./modal.css">
    <link rel="stylesheet" href="./assets./css./product.css">
    <link rel="stylesheet" href="./assets./css./card.css ">
    <link href="./assets./css./aos-master./aos-master./dist/aos.css" rel="stylesheet">
    <script src="./assets./css./aos-master./aos-master./dist/aos.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <style>
    /* Định dạng màu chữ */
    .yellow {
      color: yellow;
    }
  </style>
</head>

<body>
    <?php include 'template/header.php' ?>
    
    <?php
   
        if (isset($_GET['id'])) {
                include "body.php"; 
                include "template/footer.php";

            } else {
                include "MainPage/gioithieu.php"; 
                include "template/footer.php";

            }
           
    ?>
    <?php
//     if(isset($_SESSION['user_name'])){
//     echo "Hello! ".$_SESSION['user_name'] ."<br>";
//     echo "Dang xuat" .'<a href="Logout.php">Logout</a>';
// } 
// else{
//     header("Location: index.php");
// }
?>  <?php
// if(isset($_SESSION['user_id'])){
//   echo "Hello! ".$_SESSION['user_id'] ."<br>";
//   echo "Dang xuat" .'<a href="Logout.php">Logout</a>';
// } 
// else{
//   header("Location: index.php");
// }
?>
    <!-- Modal -->

    <script src="assets/css/bootstrap/bootstrap-5.2.2-dist/js/bootstrap.js"></script>
    <script>AOS.init();</script>
    <script src="assets/js/index.js"></script>
</body>



</html>