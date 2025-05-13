<?php
session_start();
require_once "pdo.php";
require_once "user.php";

header('Content-Type: application/json');

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $user = user_login($username, $password);

    if ($user) {
        $_SESSION['user'] = $user;
        echo json_encode([
            'status' => 'success',
            'message' => 'Đăng nhập thành công!',
            'user' => $user
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Tên đăng nhập hoặc mật khẩu không đúng!'
        ]);
    }
    exit();
}

echo json_encode(['status' => 'error', 'message' => 'Yêu cầu không hợp lệ']);
