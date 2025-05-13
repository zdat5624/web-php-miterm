<?php
require_once "dao/pdo.php";

// Lấy dữ liệu profile
$profile = pdo_query_one("SELECT * FROM profile LIMIT 1");

// Nếu không có profile, gán giá trị mặc định
if ($profile === false) {
    $profile = [
        'avatar' => '',
        'name' => 'Chưa có thông tin',
        'workplace' => 'Chưa có thông tin',
        'short_intro' => 'Chưa có thông tin',
        'detailed_intro' => 'Chưa có thông tin',
        'research_fields' => 'Chưa có thông tin',
        'contact_info' => 'Chưa có thông tin'
    ];
}

// Đường dẫn ảnh mặc định nếu không có avatar
$avatar = !empty($profile['avatar']) ? '../Uploads/' . ($profile['avatar']) : 'assets/images/default-avatar.jpg';
?>

<!-- Hero Section -->
<section id="trangchu" class="hero">
    <div class="hero-content">
        <div class="hero-img">
            <img src="<?= $avatar ?>" alt="Ảnh giảng viên" class="profile-img">
        </div>
        <div class="hero-text">
            <h1><?= ($profile['name']) ?></h1>
            <h3><?= ($profile['workplace']) ?></h3>
            <p><?= ($profile['short_intro']) ?></p>
            <a href="#lienhe" class="cta-btn">Liên hệ ngay</a>
        </div>
    </div>
</section>

<!-- Nội dung chính -->
<section class="content-section">
    <div class="container">
        <div id="gioithieu" class="content-card">
            <h2>Giới thiệu</h2>
            <p><?= ($profile['detailed_intro']) ?></p>
        </div>
        <div id="nghiencuu" class="content-card">
            <h2>Lĩnh vực nghiên cứu</h2>
            <?= html_entity_decode($profile['research_fields']) ?>
        </div>
        <div id="lienhe" class="content-card">
            <h2>Liên hệ</h2>
            <?= html_entity_decode($profile['contact_info']) ?>
        </div>
    </div>
</section>