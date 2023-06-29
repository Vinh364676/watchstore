<?php
require "db/connect.php"
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
    <link rel="stylesheet" href="./assets./css./themify-icons-font/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="./assets./css/index.css">
    <link rel="stylesheet" href="./assets./css/modal.css ">
    <link rel="stylesheet" href="./assets./css/product.css">
    <link href="./assets./css./aos-master/aos-master./dist/aos.css" rel="stylesheet">
    <script src="./assets./css./aos-master/aos-master./dist/aos.js"></script>
</head>

<body>
    <?php include 'template/header.php' ?>

    <div id="wrapper">
        <?php include 'template/content/product_detail.php' ?>
        
        <?php include 'template/footer.php' ?>
    </div>

    <!-- Modal -->
    <?php include 'template/modal.php' ?>

    <script src="assets/css/bootstrap/bootstrap-5.2.2-dist/js/bootstrap.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="assets/js/index.js"></script>
</body>

</html>