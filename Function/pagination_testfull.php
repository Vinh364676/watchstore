<?php
    require "../db/connect.php";
?>
<?php 

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

    $db = new Database();

    $sql = "SELECT p.id_product, p.name AS name_product, p.img, p.price, p.quantity, mw.name AS name_wire, mg.name AS name_glass, pi.name AS name_pin, b.name AS name_brand, pd.color, pd.size, pd.origin, ca.name As name_category
                              FROM product AS p JOIN material_wire mw ON p.material_wire_id = mw.id_material_wire
                              join product_detail as pd on p.id_product = pd.id_product
                              JOIN material_glass AS mg on p.material_glass_id = mg.id_material_glass
                              JOIN pin as pi ON p.pin_id = pi.id_pin
                              JOIN brand as b ON p.brand_id = b.id_band
                              JOIN category as ca on p.category_id = ca.id_category
                              ORDER BY p.id_product ASC LIMIT " . $limit . " OFFSET " . $start_from;
                $data = $db->select($sql);
                foreach($data as $rows) {

                    $output .= '
                    <div class="grid__item">
                        <div class="grid__item-content">
                            <a href="detail.php?id_product='.$rows['id_product'].'">
                                <div class="wrapper__product-img"><img src="imgsql/'.$rows['img'].'" class="grid__item-img"
                                        alt="img error" srcset=""></div>
            
                                <div class="grid__item-info">
                                    <label class="grid__item-title">'.$rows['name_category'].'</label>
                                    <div class="grid__item-name black">'.$rows['name_product'].'</div>
                                    <div class="grid__item-price"><strong
                                            class="red">'.number_format($rows['price'],0,',','.').'đ</strong></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    ';
                }
                $sql2 = "SELECT * FROM product";
                $total_records = $db->select($sql2);
                $total_pages = ceil(sizeof($total_records) / $limit);

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

?>