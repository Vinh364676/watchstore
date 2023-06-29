<?php
    if(isset($_GET["id"])){
        switch($_GET["id"]){
            case "qltt":
                include("FormManager/qlThongtin.php");
                break;
            
            case "qlsp":
                include("FormManager/qlSanpham.php");
                break;

            case "qlhd":
                include("FormManager/qlHoadon.php");
                break;

            case "qldh":
                include("FormManager/qlDonhang.php");
                break;

            case "qlbc":
                include("FormManager/qlBaocao.php");
                break;
            
            case "qlq":
                include("FormManager/qlQuyen.php");
                break;

            case "qltk":
                include("FormManager/qlTaikhoan.php");
                break;

            case "form_addnd":
                include("FormAdd/FormAddNguoidung.php");
                break;

            case "form_addquyen":
                include("FormAdd/FormAddQuyen.php");
                break;

            case "form_ganquyen":
                include("FormAdd/FormGanQuyen.php");
                break;
        
            case "form_addsp":
                include("FormAdd/FormAddSanpham.php");
                break;
            
            case "form_adddh":
                include("FormAdd/FormAddDonhang.php");
                break;

            case "form_addtk":
                include("FormAdd/FormAddTaikhoan.php");
                break;

            case "qlncc":
                include("FormManager/qlNhaCC.php");
                break;
            
            case "form_addncc":
                include("FormAdd/FormAddNhaCC.php");
                break;

            case "qlvc":
                include("FormManager/qlVoucher.php");
                break;
            
            case "form_addvc":
                include("FormAdd/FormAddVoucher.php");
                break;

            case "form_addhd":
                include("FormAdd/FormAddHoadon.php");
                break;
            
            case "donghonam":
                include("MainPage/male.php");
                break;
            case "donghonu":
                include("MainPage/female.php");
                break;
            case "thuonghieu":
                include("MainPage/brand.php");
                break;
            case "lienhe":
                include("MainPage/contact.php");
                break;
            case "gioithieu":
                include("MainPage/gioithieu.php");
                break;    
            case "tocard":
                include("MainPage/card.php");
                break;

            case "tocard":
                    include("MainPage/card.php");
                    break;
            case "dongho":
                include("MainPage/product.php");
                break;
            default:
                echo "Lỗi";
                break;
        }
    }
?>