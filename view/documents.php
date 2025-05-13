<?php



// Thiết lập phân trang
$limit = 3;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $limit;

// Lấy university_id
$university_id = isset($_GET['university_id']) && !empty($_GET['university_id'])
    ? $_GET['university_id']
    : (isset($_SESSION['user']['university_id']) ? $_SESSION['user']['university_id'] : null);

// Nếu không có university_id, chọn trường đầu tiên
$universities = get_all_universities();
if (!$university_id && !empty($universities)) {
    $university_id = $universities[0]['id'];
}
$university = get_university_by_id($university_id);

$total_rows = (int)get_document_count($university_id);
$total_pages = (int)ceil($total_rows / $limit);
$documents = get_documents_paginated_with_university($limit, $offset, $university_id);
?>

<!-- Tài liệu Section -->
<section class="content-section">
    <div class="container">
        <h1 class="section-title">Tài liệu giảng dạy</h1>

        <!-- Bảng tài liệu -->
        <div class="resource-table">
            <div class="table-header mb-3">
                <div class="table-title d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                    <div class="fw-bold fs-5">
                        <?php echo $university ? ($university['name']) : 'Không xác định'; ?>
                    </div>
                    <div class="notification-header" <?php echo ($_SESSION['user']['role'] === 'USER') ? 'style="display: none;"' : ''; ?>>
                        <form method="GET" action="index.php" class="mb-0">
                            <input type="hidden" name="pg" value="documents">
                            <input type="hidden" name="page" value="1">
                            <select id="selectUniversity" name="university_id" class="form-select" onchange="this.form.submit()">
                                <?php foreach ($universities as $uni): ?>
                                    <option value="<?php echo $uni['id']; ?>"
                                        <?php echo $university_id == $uni['id'] ? 'selected' : ''; ?>>
                                        <?php echo ($uni['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Bảng tài liệu -->
            <div class="table-wrapper">
                <table class="table-responsive">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên tài liệu</th>
                            <th>Link</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($documents) > 0): ?>
                            <?php $stt = $offset + 1; ?>
                            <?php foreach ($documents as $document): ?>
                                <tr>
                                    <td data-label="STT"><?php echo $stt++; ?></td>
                                    <td data-label="Tên tài liệu"><?php echo ($document['name']); ?></td>
                                    <td data-label="Link">
                                        <a href="<?php echo ($document['link']); ?>"
                                            class="download-link" target="_blank">Tải xuống</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">Không có tài liệu</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Phân trang -->
        <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <a href="index.php?pg=documents&page=<?php echo max(1, $current_page - 1); ?>&university_id=<?php echo $university_id; ?>"
                    class="page-link <?php echo $current_page <= 1 ? 'disabled' : ''; ?>">Trước</a>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="index.php?pg=documents&page=<?php echo $i; ?>&university_id=<?php echo $university_id; ?>"
                        class="page-link <?php echo $current_page == $i ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <a href="index.php?pg=documents&page=<?php echo min($total_pages, $current_page + 1); ?>&university_id=<?php echo $university_id; ?>"
                    class="page-link <?php echo $current_page >= $total_pages ? 'disabled' : ''; ?>">Sau</a>
            </div>
        <?php endif; ?>
    </div>
</section>