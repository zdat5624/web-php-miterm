<?php
require_once __DIR__ . '/../../../dao/user.php';

// Thiết lập các tham số phân trang
$limit = 6; // Số bản ghi mỗi trang
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$current_page = max($current_page, 1);
$offset = ($current_page - 1) * $limit;

// Lấy tổng số bản ghi và dữ liệu
$total_rows = (int)get_user_count();
$total_pages = (int)ceil($total_rows / $limit);
$users = get_users_paginated_with_university($limit, $offset);
?>

<div class="table-container px-3 min-vh-100">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="color: rgb(60, 102, 215);">Quản lý người dùng</h3>
        <a href="index.php?pg=adduser" class="btn btn-success">
            <i class="fas fa-plus"></i> Thêm
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Tên</th>
                    <th>Vai trò</th>
                    <th>Danh mục tài liệu truy cập</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($users) > 0): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['role']); ?></td>
                            <td><?php echo htmlspecialchars($user['university_name'] ?? 'Không xác định'); ?></td>
                            <td>
                                <a href="index.php?pg=updateuser&id=<?php echo $user['id']; ?>">
                                    <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Sửa</button>
                                </a>
                                <a href="index.php?pg=deleteuser&id=<?php echo $user['id']; ?>" onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Xóa</button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Không có dữ liệu</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-end">
            <li class="page-item <?php echo $current_page <= 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="index.php?pg=users&page=<?php echo $current_page - 1; ?>" aria-label="Previous">
                    <span aria-hidden="true">«</span>
                </a>
            </li>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo $current_page == $i ? 'active' : ''; ?>">
                    <a class="page-link" href="index.php?pg=users&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <li class="page-item <?php echo $current_page >= $total_pages ? 'disabled' : ''; ?>">
                <a class="page-link" href="index.php?pg=users&page=<?php echo $current_page + 1; ?>" aria-label="Next">
                    <span aria-hidden="true">»</span>
                </a>
            </li>
        </ul>
    </nav>
</div>