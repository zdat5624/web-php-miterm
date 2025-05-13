<?php

$limit = 6;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$current_page = max($current_page, 1);
$offset = ($current_page - 1) * $limit;


$total_rows = (int)get_university_count();
$total_pages = (int)ceil($total_rows / $limit);
$universities = get_universities_paginated($limit, $offset);
?>

<div class="table-container px-3 min-vh-100">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="color: rgb(60, 102, 215);">Quản lý trường</h3>
        <a href="index.php?pg=adduniversity" class="btn btn-success">
            <i class="fas fa-plus"></i> Thêm
        </a>
    </div>

    <!-- Hiển thị thông báo lỗi nếu có -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo ($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên trường</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($universities) > 0): ?>
                    <?php foreach ($universities as $university): ?>
                        <tr>
                            <td><?php echo ($university['id']); ?></td>
                            <td><?php echo ($university['name']); ?></td>
                            <td>
                                <a href="index.php?pg=updateuniversity&id=<?php echo $university['id']; ?>">
                                    <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Sửa</button>
                                </a>
                                <a href="index.php?pg=deleteuniversity&id=<?php echo $university['id']; ?>" onclick="return confirm('Bạn có chắc muốn xóa trường này?')">
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Xóa</button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">Không có dữ liệu</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-end">
            <li class="page-item <?php echo $current_page <= 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="index.php?pg=universities&page=<?php echo $current_page - 1; ?>" aria-label="Previous">
                    <span aria-hidden="true">«</span>
                </a>
            </li>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo $current_page == $i ? 'active' : ''; ?>">
                    <a class="page-link" href="index.php?pg=universities&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <li class="page-item <?php echo $current_page >= $total_pages ? 'disabled' : ''; ?>">
                <a class="page-link" href="index.php?pg=universities&page=<?php echo $current_page + 1; ?>" aria-label="Next">
                    <span aria-hidden="true">»</span>
                </a>
            </li>
        </ul>
    </nav>
</div>