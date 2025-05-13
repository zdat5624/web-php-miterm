<?php

ob_start();
session_start();
require_once "../dao/pdo.php";
require_once "../dao/university.php";
require_once "../dao/user.php";
require_once "../dao/document.php";
require_once "../dao/notification.php";

if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit();
}


if ($_SESSION['user']['role'] !== 'ADMIN') {
    header("Location: ../index.php");
    exit();
}



include "view/header.php";

//index.php?pg=products

if (!isset($_GET['pg'])) {
    $total_documents = get_document_count();
    $total_universities = get_university_count();
    $total_users = get_user_count();
    $total_notifications = get_notification_count();
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

        case 'updateuser':
            include "view/user/updateuser.php";
            break;

        case 'deleteuser':
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            if ($id > 0) {
                delete_user($id);
            }
            header("Location: index.php?pg=users");
            exit;
            break;









        case 'universities':


            include "view/university/universities.php";
            break;

        case 'adduniversity':
            include "view/university/adduniversity.php";
            break;

        case 'updateuniversity':
            include "view/university/updateuniversity.php";
            break;

        case 'deleteuniversity':
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            if ($id > 0) {
                delete_university($id);
            }
            header("Location: index.php?pg=universities");
            exit;
            break;

        case 'documents':


            include "view/document/documents.php";
            break;

        case 'adddocument':


            include "view/document/adddocument.php";
            break;

        case 'updatedocument':
            include "view/document/updatedocument.php";
            break;
        case 'deletedocument':
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            if ($id > 0) {
                delete_document($id);
            }
            header("Location: index.php?pg=documents");
            exit;
            break;


        /* Controller notification */
        case 'notifications':
            include "view/notification/notifications.php";
            break;
        case 'addnotification':
            include "view/notification/addnotification.php";
            break;
        case 'updatenotification':
            include "view/notification/updatenotification.php";
            break;
        case 'deletenotification':
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            if ($id > 0) {
                delete_notification($id);
            }
            header("Location: index.php?pg=notifications");
            exit;
            break;


        case 'profile':

            include "view/profile/profile.php";
            break;





        default:
            $total_documents = get_document_count();
            $total_universities = get_university_count();
            $total_users = get_user_count();
            $total_notifications = get_notification_count();
            include "view/home.php";
            break;
    }
}


include "view/footer.php";
ob_end_flush();
