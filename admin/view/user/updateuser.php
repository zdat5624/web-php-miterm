<?php
require_once __DIR__ . '/../../../dao/user.php';
require_once __DIR__ . '/../../../dao/university.php';

// Lấy ID từ URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Lấy thông tin người dùng
$user = get_user_by_id($id);

// Kiểm tra xem người dùng có tồn tại không
if (!$user) {
    header("Location: index.php?pg=users");
    exit;
}

// Lấy danh sách trường đại học để hiển thị trong dropdown
$universities = get_all_universities();

// Xử lý cập nhật
if (isset($_POST['updateuser'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $name = trim($_POST['name']);
    $role = trim($_POST['role']);
    $university_id = (int)$_POST['university_id'];

    // Kiểm tra dữ liệu đầu vào
    if (empty($email) || empty($password) || empty($name) || empty($role) || $university_id <= 0) {
        $error = "Vui lòng điền đầy đủ thông tin!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email không hợp lệ!";
    } elseif (email_exists($email) && $email !== $user['email']) {
        $error = "Email đã tồn tại!";
    } elseif (strlen($name) > 255 || strlen($email) > 255 || strlen($role) > 255) {
        $error = "Dữ liệu nhập vào quá dài (tối đa 255 ký tự)!";
    } else {
        // Cập nhật người dùng với mật khẩu mới
        update_user($id, $email, $password, $name, $role, $university_id);
        $success = "Cập nhật người dùng thành công!";
    }
}
?>

<div class="container mt-5 min-vh-100">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="color: rgb(60, 102, 215);">Cập nhật người dùng</h3>
        <a href="index.php?pg=users" class="btn btn-outline-secondary">← Quay lại</a>
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

    <!-- Form cập nhật người dùng -->
    <form action="index.php?pg=updateuser&id=<?= $id ?>" method="POST">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mật khẩu</label>
            <input type="password" name="password" class="form-control" value="<?= $user['password'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tên</label>
            <input type="text" name="name" class="form-control" value="<?= $user['name'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Vai trò</label>
            <select name="role" class="form-control" required>
                <option value="">Chọn vai trò</option>
                <option value="ADMIN" <?= $user['role'] === 'ADMIN' ? 'selected' : '' ?>>ADMIN</option>
                <option value="USER" <?= $user['role'] === 'USER' ? 'selected' : '' ?>>USER</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Trường đại học</label>
            <select name="university_id" class="form-control" required>
                <option value="">Chọn trường</option>
                <?php foreach ($universities as $university): ?>
                    <option value="<?= $university['id'] ?>" <?= $user['university_id'] == $university['id'] ? 'selected' : '' ?>>
                        <?= $university['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" name="updateuser" class="btn btn-primary">Cập nhật</button>
    </form>
</div>