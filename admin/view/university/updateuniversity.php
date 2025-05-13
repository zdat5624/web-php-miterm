<?php

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$university = get_university_by_id($id);

// Kiểm tra xem trường có tồn tại không
if (!$university) {
    header("Location: index.php?pg=universities");
    exit;
}

// Xử lý cập nhật trường
if (isset($_POST['updateuniversity'])) {
    $name = trim($_POST['name']);

    if (empty($name)) {
        $error = "Tên trường không được để trống!";
    } elseif (strlen($name) > 255) {
        $error = "Tên trường quá dài (tối đa 255 ký tự)!";
    } else {
        update_university($id, $name);
        $success = "Cập nhật trường thành công!";
    }
}
?>

<div class="container mt-5 min-vh-100">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="color: rgb(60, 102, 215);">Cập nhật trường</h3>
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

    <!-- Form cập nhật trường -->
    <form action="index.php?pg=updateuniversity&id=<?= $id ?>" method="POST">
        <div class="mb-3">
            <label class="form-label">Tên trường</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($university['name']) ?>" required>
        </div>

        <button type="submit" name="updateuniversity" class="btn btn-primary">Cập nhật trường</button>
    </form>
</div>