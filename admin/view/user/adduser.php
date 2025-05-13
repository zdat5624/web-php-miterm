<?php


$universities = get_all_universities();

// Xử lý thêm người dùng
if (isset($_POST['adduser'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $name = trim($_POST['name']);
    $role = trim($_POST['role']);
    $university_id = (int)$_POST['university_id'];

    // Kiểm tra dữ liệu
    if (empty($email) || empty($password) || empty($name) || empty($role) || $university_id <= 0) {
        $error = "Vui lòng điền đầy đủ thông tin!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email không hợp lệ!";
    } elseif (email_exists($email)) {
        $error = "Email đã tồn tại!";
    } elseif (strlen($password) < 6) {
        $error = "Mật khẩu phải có ít nhất 6 ký tự!";
    } elseif (strlen($name) > 255 || strlen($email) > 255 || strlen($role) > 255) {
        $error = "Dữ liệu nhập vào quá dài (tối đa 255 ký tự)!";
    } else {


        add_user($email, $password, $name, $role, $university_id);
        $success = "Thêm người dùng thành công!";
    }
}
?>

<div class="container mt-5 min-vh-100">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="color: rgb(60, 102, 215);">Thêm người dùng</h3>
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
            </div>
        </div>
    <?php endif; ?>

    <!-- Form thêm người dùng -->
    <form action="index.php?pg=adduser" method="POST">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mật khẩu</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tên</label>
            <input type="text" name="name" class="form-control" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Vai trò</label>
            <select name="role" class="form-control" required>
                <option value="">Chọn vai trò</option>
                <option value="ADMIN">ADMIN</option>
                <option value="USER">USER</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Trường đại học (Người dùng vai trò USER sẽ chỉ truy cập được tài nguyên thuộc trường của người dùng)</label>
            <select name="university_id" class="form-control" required>
                <option value="">Chọn trường</option>
                <?php foreach ($universities as $university): ?>
                    <option value="<?php echo $university['id']; ?>" <?php echo isset($_POST['university_id']) && (int)$_POST['university_id'] === $university['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($university['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" name="adduser" class="btn btn-primary">Thêm người dùng</button>
    </form>
</div>