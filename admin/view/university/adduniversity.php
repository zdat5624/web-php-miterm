<?php
require_once "../dao/pdo.php";

// Xử lý thêm trường
if (isset($_POST['adduniversity'])) {
    $name = trim($_POST['name']);

    // Kiểm tra dữ liệu đầu vào
    if (empty($name)) {
        $error = "Tên trường không được để trống!";
    } elseif (strlen($name) > 255) {
        $error = "Tên trường quá dài (tối đa 255 ký tự)!";
    } else {
        // Thêm vào bảng universities
        pdo_execute(
            "INSERT INTO universities (name) VALUES (?)",
            $name
        );
        $success = "Thêm trường thành công!";
    }
}
?>

<div class="container mt-5 min-vh-100">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="color: rgb(60, 102, 215);">Thêm trường</h3>
        <a href="index.php?pg=universities" class="btn btn-outline-secondary">← Quay lại</a>
    </div>

    <?php if (isset($success)): ?>
        <div id="alert-message" class="mb-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $success ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div id="alert-message" class="mb-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $error ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Form thêm trường -->
    <form action="index.php?pg=adduniversity" method="POST">
        <div class="mb-3">
            <label class="form-label">Tên trường</label>
            <input type="text" name="name" class="form-control" value="" required>
        </div>

        <button type="submit" name="adduniversity" class="btn btn-primary">Thêm trường</button>
    </form>
</div>