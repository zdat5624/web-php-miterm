<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
$limit = 6;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$current_page = max($current_page, 1);
$offset = ($current_page - 1) * $limit;

$university_id = isset($_GET['university_id'])  ? $_GET['university_id'] : null;

$total_rows = (int)get_notification_count($university_id);
$total_pages = (int)ceil($total_rows / $limit);
$notifications = get_notifications_paginated($limit, $offset, $university_id);

$universities = get_all_universities();
?>

<div class="table-container px-3 min-vh-100">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="color: rgb(60, 102, 215);">Quản lý thông báo</h3>
        <a href="index.php?pg=addnotification" class="btn btn-success">
            <i class="fas fa-plus"></i> Thêm
        </a>
    </div>

    <!-- Dropdown lọc theo trường -->
    <div class="mb-3">
        <form method="GET" action="index.php">
            <input type="hidden" name="pg" value="notifications">
            <input type="hidden" name="page" value="<?php echo $current_page; ?>">
            <div class="input-group" style="max-width: 300px;">
                <select name="university_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Tất cả trường</option>
                    <?php foreach ($universities as $university): ?>
                        <option value="<?php echo $university['id']; ?>" <?php echo $university_id === $university['id'] ? 'selected' : ''; ?>>
                            <?php echo ($university['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ngày đăng</th>
                    <th>Tiêu đề</th>
                    <th>Trường</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($notifications) > 0): ?>
                    <?php foreach ($notifications as $notification): ?>
                        <tr>
                            <td><?php echo ($notification['id']); ?></td>
                            <td>
                                <?php
                                $date = new DateTime($notification['create_at']);
                                echo  $date->format('H:i d/m/Y');
                                ?>


                            </td>
                            <td><?php echo ($notification['title']); ?></td>
                            <td><?php echo ($notification['university_name'] ?? 'Không xác định'); ?></td>
                            <td>
                                <a href="index.php?pg=updatenotification&id=<?php echo $notification['id']; ?>">
                                    <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Sửa</button>
                                </a>
                                <a href="index.php?pg=deletenotification&id=<?php echo $notification['id']; ?>" onclick="return confirm('Bạn có chắc muốn xóa thông báo này?')">
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Xóa</button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Không có dữ liệu</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-end">
            <li class="page-item <?php echo $current_page <= 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="index.php?pg=notifications&page=<?php echo $current_page - 1; ?>&university_id=<?php echo $university_id ?? ''; ?>" aria-label="Previous">
                    <span aria-hidden="true">«</span>
                </a>
            </li>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo $current_page == $i ? 'active' : ''; ?>">
                    <a class="page-link" href="index.php?pg=notifications&page=<?php echo $i; ?>&university_id=<?php echo $university_id ?? ''; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <li class="page-item <?php echo $current_page >= $total_pages ? 'disabled' : ''; ?>">
                <a class="page-link" href="index.php?pg=notifications&page=<?php echo $current_page + 1; ?>&university_id=<?php echo $university_id ?? ''; ?>" aria-label="Next">
                    <span aria-hidden="true">»</span>
                </a>
            </li>
        </ul>
    </nav>
</div>