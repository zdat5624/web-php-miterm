<?php

$limit = 6;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$current_page = max($current_page, 1);
$offset = ($current_page - 1) * $limit;

$university_id = isset($_GET['university_id']) ? $_GET['university_id'] : null;
$sort = isset($_GET['sort']) && $_GET['sort'] === 'order_number' ? 'order_number' : null;
$order = isset($_GET['order']) && in_array($_GET['order'], ['ASC', 'DESC']) ? $_GET['order'] : 'ASC';

$total_rows = (int)get_document_count($university_id);
$total_pages = (int)ceil($total_rows / $limit);
$documents = get_documents_paginated_with_university($limit, $offset, $university_id, $sort, $order);

$universities = get_all_universities();
?>

<div class="table-container px-3 min-vh-100">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="color: rgb(60, 102, 215);">Quản lý tài liệu</h3>
        <a href="index.php?pg=adddocument" class="btn btn-success">
            <i class="fas fa-plus"></i> Thêm
        </a>
    </div>

    <!-- Dropdown lọc theo trường -->
    <div class="mb-3">
        <form method="GET" action="index.php">
            <input type="hidden" name="pg" value="documents">
            <input type="hidden" name="page" value="<?php echo $current_page; ?>">
            <input type="hidden" name="sort" value="<?php echo $sort; ?>">
            <input type="hidden" name="order" value="<?php echo $order; ?>">
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
                    <th>Tên tài liệu</th>
                    <th>Link tài liệu</th>
                    <th>Trường</th>
                    <th>
                        <a href="index.php?pg=documents&page=<?php echo $current_page; ?>&university_id=<?php echo $university_id ?? ''; ?>&sort=order_number&order=<?php echo $sort === 'order_number' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>" class="sort-link <?php echo $sort === 'order_number' ? 'active' : ''; ?>">
                            Thứ tự hiển thị
                            <?php if ($sort === 'order_number'): ?>
                                <i class="fas fa-sort-<?php echo $order === 'ASC' ? 'up' : 'down'; ?>"></i>
                            <?php else: ?>
                                <i class="fas fa-sort"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($documents) > 0): ?>
                    <?php foreach ($documents as $document): ?>
                        <tr>
                            <td><?php echo ($document['id']); ?></td>
                            <td><?php echo ($document['name']); ?></td>
                            <td><a href="<?php echo ($document['link']); ?>" target="_blank">Link</a></td>
                            <td><?php echo ($document['university_name'] ?? 'Không xác định'); ?></td>
                            <td><?php echo ($document['order_number']); ?></td>
                            <td>
                                <a href="index.php?pg=updatedocument&id=<?php echo $document['id']; ?>">
                                    <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Sửa</button>
                                </a>
                                <a href="index.php?pg=deletedocument&id=<?php echo $document['id']; ?>" onclick="return confirm('Bạn có chắc muốn xóa tài liệu này?')">
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
                <a class="page-link" href="index.php?pg=documents&page=<?php echo $current_page - 1; ?>&university_id=<?php echo $university_id ?? ''; ?>&sort=<?php echo $sort; ?>&order=<?php echo $order; ?>" aria-label="Previous">
                    <span aria-hidden="true">«</span>
                </a>
            </li>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo $current_page == $i ? 'active' : ''; ?>">
                    <a class="page-link" href="index.php?pg=documents&page=<?php echo $i; ?>&university_id=<?php echo $university_id ?? ''; ?>&sort=<?php echo $sort; ?>&order=<?php echo $order; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <li class="page-item <?php echo $current_page >= $total_pages ? 'disabled' : ''; ?>">
                <a class="page-link" href="index.php?pg=documents&page=<?php echo $current_page + 1; ?>&university_id=<?php echo $university_id ?? ''; ?>&sort=<?php echo $sort; ?>&order=<?php echo $order; ?>" aria-label="Next">
                    <span aria-hidden="true">»</span>
                </a>
            </li>
        </ul>
    </nav>
</div>