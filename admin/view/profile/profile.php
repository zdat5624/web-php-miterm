<?php
require_once "../dao/pdo.php";

$uploadDir = "../uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$profile = pdo_query_one("SELECT * FROM profile LIMIT 1");

if ($profile === false) {
    pdo_execute(
        "INSERT INTO profile (name, workplace, short_intro, detailed_intro, research_fields, contact_info, avatar) VALUES (?, ?, ?, ?, ?, ?, ?)",
        "Chưa xác định",
        "Chưa xác định",
        "Chưa xác định",
        "Chưa xác định",
        "Chưa xác định",
        "Chưa xác định",
        ""
    );
    $profile = pdo_query_one("SELECT * FROM profile LIMIT 1");
}

// Xử lý cập nhật profile
if (isset($_POST['updateprofile'])) {
    $name = $_POST['name'];
    $workplace = $_POST['workplace'];
    $short_intro = $_POST['short_intro'];
    $detailed_intro = $_POST['detailed_intro'];
    $research_fields = $_POST['research_fields'];
    $contact_info = $_POST['contact_info'];
    $avatar = $profile['avatar'];

    // Xử lý upload ảnh đại diện
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxFileSize = 2 * 1024 * 1024; // 2MB
        $fileType = $_FILES['avatar']['type'];
        $fileSize = $_FILES['avatar']['size'];

        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxFileSize) {
            $fileName = uniqid() . '-' . basename($_FILES['avatar']['name']);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $filePath)) {
                $avatar = $fileName;
                if (!empty($profile['avatar']) && file_exists($uploadDir . $profile['avatar'])) {
                    unlink($uploadDir . $profile['avatar']);
                }
            } else {
                $error = "Lỗi khi upload ảnh đại diện!";
            }
        } else {
            $error = "File không hợp lệ hoặc quá lớn! Chỉ chấp nhận JPG, PNG, GIF dưới 2MB.";
        }
    }

    // Cập nhật profile
    pdo_execute(
        "UPDATE profile SET name = ?, workplace = ?, short_intro = ?, detailed_intro = ?, research_fields = ?, contact_info = ?, avatar = ? WHERE id = ?",
        $name,
        $workplace,
        $short_intro,
        $detailed_intro,
        $research_fields,
        $contact_info,
        $avatar,
        $profile['id']
    );

    // Làm mới dữ liệu profile sau khi cập nhật
    $profile = pdo_query_one("SELECT * FROM profile LIMIT 1");

    // Thông báo thành công
    $success = "Cập nhật hồ sơ thành công!";
}
?>

<div class="container px-3 mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-primary">Hồ sơ</h2>
    </div>

    <?php if (isset($success)): ?>
        <div id="alert-message" class="mb-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $success ?>
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

    <!-- Hiển thị ảnh hiện tại -->
    <div class="mb-4">
        <h4>Ảnh đại diện hiện tại</h4>
        <?php if (!empty($profile['avatar'])): ?>
            <img src="../uploads/<?= htmlspecialchars($profile['avatar']) ?>" alt="Avatar" style="max-width: 200px; height: auto;">
        <?php else: ?>
            <p>Chưa có ảnh đại diện.</p>
        <?php endif; ?>
    </div>

    <!-- Form cập nhật profile -->
    <form action="index.php?pg=profile" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $profile['id'] ?? '' ?>">

        <div class="mb-3">
            <label class="form-label">Họ và tên</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($profile['name'] ?? 'Chưa xác định') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Ảnh đại diện</label>
            <input type="file" name="avatar" class="form-control" accept="image/jpeg,image/png,image/gif">
        </div>

        <div class="mb-3">
            <label class="form-label">Công việc</label>
            <textarea name="workplace" class="form-control" required><?= htmlspecialchars($profile['workplace'] ?? 'Chưa xác định') ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Giới thiệu ngắn</label>
            <textarea name="short_intro" id="short_intro" class="form-control" required><?= htmlspecialchars($profile['short_intro'] ?? 'Chưa xác định') ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Giới thiệu chi tiết</label>
            <textarea name="detailed_intro" id="detailed_intro" class="form-control" required><?= htmlspecialchars($profile['detailed_intro'] ?? 'Chưa xác định') ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Lĩnh vực nghiên cứu</label>
            <textarea name="research_fields" id="research_fields" class="form-control" required><?= htmlspecialchars($profile['research_fields'] ?? 'Chưa xác định') ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Thông tin liên hệ</label>
            <textarea name="contact_info" id="contact_info" class="form-control" required><?= htmlspecialchars($profile['contact_info'] ?? 'Chưa xác định') ?></textarea>
        </div>

        <button type="submit" name="updateprofile" class="btn btn-primary">Cập nhật</button>
    </form>
</div>

<!-- CKEditor 5 CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<style>
    /* Đặt chiều cao cho từng CKEditor */
    #short_intro+.ck-editor .ck-editor__editable_inline {
        min-height: 100px;
    }

    #detailed_intro+.ck-editor .ck-editor__editable_inline {
        min-height: 400px;
    }

    #research_fields+.ck-editor .ck-editor__editable_inline {
        min-height: 200px;
    }

    #contact_info+.ck-editor .ck-editor__editable_inline {
        min-height: 200px;
    }
</style>
<script>
    // Custom Upload Adapter
    class UploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }

        upload() {
            return this.loader.file.then(file => new Promise((resolve, reject) => {
                const data = new FormData();
                data.append('upload', file);

                fetch('/ckeditor/upload_image.php', {
                        method: 'POST',
                        body: data
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.uploaded) {
                            resolve({
                                default: result.url
                            });
                        } else {
                            reject(result.message);
                        }
                    })
                    .catch(error => {
                        reject('Upload failed: ' + error);
                    });
            }));
        }

        abort() {
            // Xử lý hủy upload
        }
    }

    // Gắn adapter vào CKEditor
    function MyCustomUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            return new UploadAdapter(loader);
        };
    }

    // Khởi tạo CKEditor cho từng trường
    const editors = [{
            id: 'short_intro'
        },
        {
            id: 'detailed_intro'
        },
        {
            id: 'research_fields'
        },
        {
            id: 'contact_info'
        }
    ];

    editors.forEach(field => {
        ClassicEditor
            .create(document.querySelector(`#${field.id}`), {
                extraPlugins: [MyCustomUploadAdapterPlugin],
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'imageUpload', 'blockQuote', 'insertTable', 'undo', 'redo'],
                alignment: {
                    options: ['left', 'center', 'right', 'justify']
                }
            })
            .catch(error => {
                console.error(error);
            });
    });
</script>