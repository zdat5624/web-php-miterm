<?php
header('Content-Type: application/json');

// Đường dẫn lưu ảnh
$uploadDir = '../upload/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Kiểm tra file upload
if (isset($_FILES['upload']) && $_FILES['upload']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['upload'];
    $fileName = uniqid() . '_' . basename($file['name']);
    $filePath = $uploadDir . $fileName;

    // Di chuyển file vào thư mục uploads
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        // Trả về URL của ảnh
        $url = 'http://localhost:3000/' . $filePath; // Thay yourdomain.com bằng domain thực tế
        echo json_encode([
            'uploaded' => true,
            'url' => $url
        ]);
    } else {
        echo json_encode([
            'uploaded' => false,
            'message' => 'Không thể lưu file.'
        ]);
    }
} else {
    echo json_encode([
        'uploaded' => false,
        'message' => 'Không có file hoặc lỗi upload.'
    ]);
}
