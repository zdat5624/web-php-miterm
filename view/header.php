<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Portal</title>
    <link href="./layout/css/bootstrap.min.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="../favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="../favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon/favicon-16x16.png">
    <link rel="manifest" href="../favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="../favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">


    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="./layout/css/style.css">

</head>

<body>
    <!-- Thanh điều hướng Bootstrap -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <!-- <a class="navbar-brand" href="#">TS. Nguyễn Văn A</a> -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link  <?= !isset($_GET['pg']) ? "active" : '' ?>" aria-current="page" href="index.php">Trang chủ</a>
                    </li>

                    <?php
                    if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
                        echo '
                            <li class="nav-item">
                                <a class="nav-link ' . (isset($_GET['pg']) && $_GET['pg'] == "documents" ? "active" : "") . '" href="index.php?pg=documents">Tài liệu</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ' . (isset($_GET['pg']) && $_GET['pg'] == "notifications" ? "active" : "") . '" href="index.php?pg=notifications">Thông báo</a>
                            </li>
                        ';
                    }
                    ?>
                </ul>
                <ul class="navbar-nav">
                    <?php
                    if (isset($_SESSION['user']) && !empty($_SESSION['user']) && $_SESSION['user']['role'] === 'ADMIN') {
                        echo '
                            <li class="nav-item">
                                <a class="nav-link" href="../admin/">Đến trang quản trị</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?pg=logout">Đăng xuất</a>
                            </li>
                        ';
                    } else if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
                        echo '
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?pg=logout">Đăng xuất</a>
                            </li>
                        ';
                    } else {
                        echo '
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Đăng nhập</a>
                            </li>
                        ';
                    }
                    ?>
                </ul>

            </div>
        </div>
    </nav>

    <!-- Modal Đăng nhập -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Đăng nhập</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="login-message"></div>
                    <form id="loginForm">
                        <div class="mb-3">
                            <label for="username" class="form-label">Email đăng nhập</label>
                            <input type="email" class="form-control" id="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" required>
                        </div>
                        <button type="submit" class="btn btn-login">Đăng nhập</button>
                    </form>
                </div>
            </div>
        </div>
    </div>