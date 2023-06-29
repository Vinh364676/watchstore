<?php
    require "db/connect.php";
?>

<div id="dongho"> 
    <div id="wrapper">
        <div class="wrapper_child">
            <div class="grid">
                <!-- Content -->
                <?php include 'template/content/products_all.php' ?>
                <?php include 'template/modal.php' ?>
            </div>
        </div>
    </div>

</div>

    

    <script src="assets/css/bootstrap/bootstrap-5.2.2-dist/js/bootstrap.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="assets/js/index.js"></script>
