<?php
ob_start();
require_once "../dao/pdo.php";



include "view/header.php";

//index.php?pg=products

if (!isset($_GET['pg'])) {

    include "view/home.php";
} else {
    switch ($_GET['pg']) {

        /* Controller user */
        case 'users':


            include "view/user/users.php";
            break;

        case 'adduser':

            include "view/user/adduser.php";
            break;

        case 'deleteuser':

            include "view/user/users.php";
            break;

        case 'updateuser':

            break;

        case 'handleupdateuser':

            break;






        case 'categories':


            include "view/category/categories.php";
            break;

        case 'documents':


            include "view/document/documents.php";
            break;









        default:
            include "view/home.php";
            break;
    }
}


include "view/footer.php";
ob_end_flush();
