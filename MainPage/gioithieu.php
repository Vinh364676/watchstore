<?php
    require "db/connect.php";
  

?>

<div id="gioithieu"> 
    <div id="wrapper">
    
        <?php include 'template/slider.php' ?>

        <!-- Content -->
        <?php include 'template/content/home.php' ?>

        
    </div>
        <?php include 'template/modal.php' ?>


</div>


    <script src="assets/css/bootstrap/bootstrap-5.2.2-dist/js/bootstrap.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="assets/js/index.js"></script>

