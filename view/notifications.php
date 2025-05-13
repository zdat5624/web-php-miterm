<?php
// Thiết lập phân trang
$limit = 3; // Số thông báo mỗi trang
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

$total_rows = (int)get_notification_count($university_id);
$total_pages = (int)ceil($total_rows / $limit);
$notifications = get_notifications_paginated($limit, $offset, $university_id);
?>

<!-- Thông báo Section -->
<section class="content-section">
    <div class="container">
        <h1 class="section-title">Thông Báo</h1>

        <!-- Header với dropdown chọn trường -->
        <div class="notification-header mb-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                <div class="fw-bold fs-5">
                    <?php echo $university ? ($university['name']) : 'Không xác định'; ?>
                </div>
                <div class="notification-header" <?php echo ($_SESSION['user']['role'] === 'USER') ? 'style="display: none;"' : ''; ?>>
                    <form method="GET" action="index.php" class="mb-0">
                        <input type="hidden" name="pg" value="notifications">
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

        <!-- Danh sách thông báo -->
        <div id="notifications">
            <?php if (count($notifications) > 0): ?>
                <?php foreach ($notifications as $notification): ?>
                    <div class="notification">
                        <h5><?php echo ($notification['title']); ?></h5>
                        <p><?php echo ($notification['content']); ?></p>
                        <div class="date">Ngày đăng: <?php echo date('d-m-Y', strtotime($notification['create_at'])); ?></div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="notification">
                    <p>Không có thông báo</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Phân trang -->
        <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <a href="index.php?pg=notifications&page=<?php echo max(1, $current_page - 1); ?>&university_id=<?php echo $university_id; ?>"
                    class="page-link <?php echo $current_page <= 1 ? 'disabled' : ''; ?>">Trước</a>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="index.php?pg=notifications&page=<?php echo $i; ?>&university_id=<?php echo $university_id; ?>"
                        class="page-link <?php echo $current_page == $i ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <a href="index.php?pg=notifications&page=<?php echo min($total_pages, $current_page + 1); ?>&university_id=<?php echo $university_id; ?>"
                    class="page-link <?php echo $current_page >= $total_pages ? 'disabled' : ''; ?>">Sau</a>
            </div>
        <?php endif; ?>
    </div>
</section>