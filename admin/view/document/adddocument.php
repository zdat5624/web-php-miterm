<?php
require_once __DIR__ . '/../../../dao/document.php';

$errors = [];
$success = '';
$name = $link = $order_number = $university_id = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $name = trim($_POST['name'] ?? '');
    $link = trim($_POST['link'] ?? '');
    $order_number = (int)($_POST['order_number'] ?? 0);
    $university_id = (int)($_POST['university_id'] ?? 0);

    // Xác thực dữ liệu
    if (empty($name)) {
        $errors[] = 'Tên tài liệu là bắt buộc.';
    }


    if (empty($errors)) {
        try {
            add_document($name, $link, $order_number, $university_id);
            $success = 'Thêm tài liệu thành công!';
        } catch (PDOException $e) {
            $errors[] = 'Lỗi khi thêm tài liệu: ' . $e->getMessage();
        }
    }
}

// Lấy danh sách trường đại học cho dropdown
$universities = get_all_universities();
?>

<div class="container mt-5 min-vh-100">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="color: rgb(60, 102, 215);">Thêm tài liệu mới</h3>
        <a href="index.php?pg=documents" class="btn btn-outline-secondary">← Quay lại</a>
    </div>

    <!-- Thông báo -->
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Form thêm tài liệu -->
    <form method="POST" action="index.php?pg=adddocument">
        <div class="mb-3">
            <label for="name" class="form-label">Tên tài liệu <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
        </div>
        <div class="mb-3">
            <label for="link" class="form-label">Link tài liệu <span class="text-danger">*</span></label>
            <input type="url" class="form-control" id="link" name="link" value="<?php echo htmlspecialchars($link); ?>" required>
        </div>
        <div class="mb-3">
            <label for="university_id" class="form-label">Chọn trường <span class="text-danger">*</span></label>
            <select class="form-select" id="university_id" name="university_id" required>
                <option value="">Chọn trường</option>
                <?php foreach ($universities as $university): ?>
                    <option value="<?php echo $university['id']; ?>" <?php echo $university_id == $university['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($university['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="order_number" class="form-label">Thứ tự hiển thị <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="order_number" name="order_number" value="<?php echo htmlspecialchars($order_number); ?>" min="0" required>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary"> Thêm tài liệu</button>
        </div>
    </form>
</div>

<!-- JavaScript để tự động điền order_number -->
<script>
    document.getElementById('university_id').addEventListener('change', function() {
        const universityId = this.value;
        const orderNumberInput = document.getElementById('order_number');

        if (universityId) {
            fetch(`/dao/get_max_order_number.php?&university_id=${universityId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.order_number) {
                        orderNumberInput.value = data.order_number;
                    } else {
                        orderNumberInput.value = 1;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    orderNumberInput.value = 1;
                });
        } else {
            orderNumberInput.value = '';
        }
    });
</script>