<?php
ob_start();
session_start();
// nhúng kết nối csdl
require_once "dao/pdo.php";
require_once 'dao/document.php';
require_once 'dao/university.php';
require_once 'dao/notification.php';

include "view/header.php";

if (!isset($_GET['pg'])) {

    include "view/home.php";
} else {
    switch ($_GET['pg']) {
        case 'logout':
            session_unset(); // Xóa tất cả biến session
            session_destroy(); // Hủy session
            header("Location: index.php");
            exit();
            break;


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
