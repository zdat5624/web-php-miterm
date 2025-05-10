<?php
// nhúng kết nối csdl
require_once "dao/pdo.php";



include "view/header.php";

if (!isset($_GET['pg'])) {

    include "view/home.php";
} else {
    switch ($_GET['pg']) {
        case 'documents':
            include "view/documents.php";
            break;

        case 'notifications':
            include "view/notifications.php";
            break;

        default:

            include "view/home.php";
            break;
    }
}


include "view/footer.php";
