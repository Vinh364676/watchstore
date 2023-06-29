<?php 
if(isset($_GET['id'])){
    $id = $_GET['id'];
}

if(isset($_GET['b'])) {
    $id_brand = $_GET['b'];
?>

<div class="container">
    <div class="row">
        <div class="col">
        </div>
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php if ($current_page > 3) {
    $first_page = 1;?>
                    <li class="page-item"><a class="page-link"
                            href="?id=<?=$id?>&b=<?=$id_brand?>&page=<?=$first_page?>&per_page=<?=$item_per_page?>">First</a></li>
                    <?php } ?>
                    <?php if ($current_page > 1) { 
            $prev_page = $current_page - 1;?>
                    <li class="page-item">
                        <a class="page-link" href="?id=<?=$id?>&b=<?=$id_brand?>&page=<?=$prev_page?>&per_page=<?=$item_per_page?>"
                            aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php } ?>
                    <?php for($num = 1; $num <= $totalPages; $num++) { ?>
                    <?php if($num != $current_page) { ?>
                    <?php if($num > $current_page - 3 && $num < $current_page + 3) { ?>
                    <li class="page-item"><a class="page-link"
                            href="?id=<?=$id?>&b=<?=$id_brand?>&page=<?=$num?>&per_page=<?=$item_per_page?>"><?=$num?></a></li>
                    <?php } ?>
                    <?php } else { ?>
                    <strong>
                        <li class="page-item"><a class="page-link"
                                href="?id=<?=$id?>&b=<?=$id_brand?>&page=<?=$num?>&per_page=<?=$item_per_page?>"><?=$num?></a></li>
                    </strong>
                    <?php } } ?>
                    <?php if ($current_page < $totalPages) { 
            $next_page = $current_page + 1;?>
                    <li class="page-item">
                        <a class="page-link" href="?id=<?=$id?>&b=<?=$id_brand?>&page=<?=$next_page?>&per_page=<?=$item_per_page?>"
                            aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    <?php } ?>
                    <?php if ($current_page < $totalPages - 3) {
            $end_page = $totalPages;?>
                    <li class="page-item"><a class="page-link"
                            href="?id=<?=$id?>&b=<?=$id_brand?>&page=<?=$end_page?>&per_page=<?=$item_per_page?>">End</a></li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
        <div class="col">
            <select id="choose" class="form-select">
                <option selected>Chọn số sản phẩm trên trang</option>
                <option value="1">1</option>
                <option value="3">3</option>
                <option value="6">6</option>
            </select>
        </div>
    </div>
</div>

<?php } else { ?>
<div class="container">
    <div class="row">
        <div class="col">
        </div>
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php if ($current_page > 3) {
    $first_page = 1;?>
                    <li class="page-item"><a class="page-link"
                            href="?id=<?=$id?>&page=<?=$first_page?>&per_page=<?=$item_per_page?>">First</a></li>
                    <?php } ?>
                    <?php if ($current_page > 1) { 
            $prev_page = $current_page - 1;?>
                    <li class="page-item">
                        <a class="page-link" href="?id=<?=$id?>&page=<?=$prev_page?>&per_page=<?=$item_per_page?>"
                            aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php } ?>
                    <?php for($num = 1; $num <= $totalPages; $num++) { ?>
                    <?php if($num != $current_page) { ?>
                    <?php if($num > $current_page - 3 && $num < $current_page + 3) { ?>
                    <li class="page-item"><a class="page-link"
                            href="?id=<?=$id?>&page=<?=$num?>&per_page=<?=$item_per_page?>"><?=$num?></a></li>
                    <?php } ?>
                    <?php } else { ?>
                    <strong>
                        <li class="page-item"><a class="page-link"
                                href="?id=<?=$id?>&page=<?=$num?>&per_page=<?=$item_per_page?>"><?=$num?></a></li>
                    </strong>
                    <?php } } ?>
                    <?php if ($current_page < $totalPages) { 
            $next_page = $current_page + 1;?>
                    <li class="page-item">
                        <a class="page-link" href="?id=<?=$id?>&page=<?=$next_page?>&per_page=<?=$item_per_page?>"
                            aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    <?php } ?>
                    <?php if ($current_page < $totalPages - 3) {
            $end_page = $totalPages;?>
                    <li class="page-item"><a class="page-link"
                            href="?id=<?=$id?>&page=<?=$end_page?>&per_page=<?=$item_per_page?>">End</a></li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
        <div class="col">
            <select id="choose" class="form-select">
                <option selected>Chọn số sản phẩm trên trang</option>
                <option value="1">1</option>
                <option value="3">3</option>
                <option value="6">6</option>
            </select>
        </div>
    </div>
</div>
<?php } ?>

<script>
jQuery(document).ready(function() {
    jQuery('#choose').change(function() {
var value = jQuery(this).val();
        var url = window.location.href;
        var i = url.length - 1;
        while (i >= 0 && url[i] !== "=") {
            i--;
        }
        var newUrl = url.substr(0, i + 1);
        var result = newUrl + value;
        window.location.href = result;
    });
})
</script>