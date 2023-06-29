<?php
require_once '../db/connect.php';
$db = new Database();

$limit = 3;
    $page = 1;
    $output = '';

    if(isset($_POST['page'])) {
        $page = $_POST['page'];
    } else {
        $page = 1;
    }

    if(isset($_POST['limit'])) {
        $limit = $_POST['limit'];
    } else {
        $limit = 3;
    }

    $start_from = ($page - 1) * $limit;

if(isset($_GET['key-search'])) {
    $key = $_GET['key-search'];
    $sql = "SELECT p.*, c.*, p.name as name_product FROM product p JOIN category c ON p.category_id = c.id_category WHERE p.category_id=2 AND p.name LIKE '%" . $key . "%' ORDER BY p.id_product ASC LIMIT ". $limit ." OFFSET " . $start_from;
    $result = $db->query($sql);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            echo '<div class="grid__item">';
            echo '<div class="grid__item-content">';
            echo '<a href="detail.php?id_product=' . $row['id_product'] . '">';
            echo '<div class="wrapper__product-img"><img src="imgsql/' . $row['img'] . '" class="grid__item-img" alt="img error" srcset=""></div>';
            echo '<div class="grid__item-info">';
            echo '<label class="grid__item-title">' . $row['name'] . '</label>';
            echo '<div class="grid__item-name black">' . $row['name_product'] . '</div>';
            echo '<div class="grid__item-price"><strong class="red">' . number_format($row['price'], 0, ',', '.') . 'đ</strong></div>';
            echo '</div>';
            echo '</a>';
            echo '</div>';
            echo '</div>';
        }

        $sql2 = "SELECT p.*, c.*, p.name as name_product FROM product p JOIN category c ON p.category_id = c.id_category WHERE p.category_id=2 AND p.name LIKE '%" . $key . "%'";
        $total_records = $db->select($sql2);
        $total_pages = ceil(sizeof($total_records) / $limit);

$output = '';

$output .= '<div class="container">
        <div class="row">
            <div class="col">
            </div>
            <div class="col">
                <nav aria-label="Page navigation example">';
        $output .= '<ul class="pagination">';

        if($page > 3) {
            $first_page = 1;
            $output .= '<li class="page-item" id="'.$first_page.'"><a class="page-link"
            href="#">First</a></li>';
        }

        if ($page > 1) {
            $prev_page = $page - 1;
            $output .= '<li class="page-item" id="'.$prev_page.'">
            <a class="page-link" href="#"
                aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>';
        }

        for($num = 1; $num < $total_pages; $num++) {
            if($num != $page) {
                if($num > $page - 3 && $num < $page + 3) {
                    $output .= '<li class="page-item" id="'.$num.'"><a class="page-link"
                    href="#">'.$num.'</a></li>';
                }
            } else {
                $output .= '<strong>
                <li class="page-item" id="'.$num.'"><a class="page-link"
                        href="#">'.$num.'</a></li>
            </strong>';
            }
        }

        if($page < $total_pages) {
            $next_page = $page + 1;
            $output .= '<li class="page-item" id="'.$next_page.'">
            <a class="page-link" href="#"
                aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>';
        }

        if($page < $total_pages - 3) {
            $end_page = $total_pages;
            $output .= '<li class="page-item" id="'.$end_page.'"><a class="page-link"
            href="#">End</a></li>';
        }

        $output .= '</ul>';

        $output .= '</nav>
        </div>
        <div class="col">
            <select id="choose" class="form-select">';

        if($limit == 1) {
            $output .= '<option value="1" selected>1</option>
            <option value="3">3</option>
            <option value="6">6</option>';
        } else if ($limit == 3) {
            $output .= '<option value="1">1</option>
            <option value="3" selected>3</option>
            <option value="6">6</option>';
        } else {
            $output .= '<option value="1">1</option>
            <option value="3">3</option>
            <option value="6" selected>6</option>';
        }

        $output .= '
            </select>
        </div>
    </div>
</div>';

echo $output;
   } else {
      echo 'Không tìm thấy sản phẩm nào!';
   }

// Đóng kết nối cơ sở dữ liệu
$db->close();
}