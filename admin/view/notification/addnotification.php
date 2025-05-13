<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

$errors = [];
$success = '';
$title = $content = $university_id = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content_notification'] ?? '');
    $university_id = (int)($_POST['university_id'] ?? 0);


    $sql = "SELECT id FROM universities WHERE id = ?";
    $university = pdo_query_one($sql, $university_id);
    if (!$university) {
        $errors[] = 'Trường đại học không tồn tại.';
    }

    // Nếu không có lỗi, thêm thông báo
    if (empty($errors)) {
        try {
            insert_notification($title, $content, $university_id);
            $success = 'Thêm thông báo thành công!';
        } catch (PDOException $e) {
            $errors[] = 'Lỗi khi thêm thông báo: ' . $e->getMessage();
        }
    }
}

$universities = get_all_universities();
?>

<div class="container mt-5 min-vh-100">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="color: rgb(60, 102, 215);">Thêm thông báo</h3>
        <a href="index.php?pg=notifications" class="btn btn-outline-secondary">← Quay lại</a>
    </div>

    <!-- Thông báo -->
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo ($success); ?></div>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo ($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php?pg=addnotification">
        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo ($title); ?>" required>
        </div>
        <div class="mb-3 editor-container">
            <label for="content_notification" class="form-label">Nội dung <span class="text-danger">*</span></label>
            <textarea name="content_notification" id="content_notification" class="form-control"><?php echo ($content); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="university_id" class="form-label">Chọn trường <span class="text-danger">*</span></label>
            <select class="form-select" id="university_id" name="university_id" required>
                <option value="">-- Chọn trường --</option>
                <?php foreach ($universities as $university): ?>
                    <option value="<?php echo $university['id']; ?>" <?php echo $university_id == $university['id'] ? 'selected' : ''; ?>>
                        <?php echo ($university['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Thêm</button>
        </div>
    </form>
</div>

<!-- CKEditor 5 CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    // Định nghĩa custom upload adapter
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

    function MyCustomUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            return new UploadAdapter(loader);
        };
    }

    ClassicEditor
        .create(document.querySelector('#content_notification'), {
            extraPlugins: [MyCustomUploadAdapterPlugin],
            toolbar: {
                items: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'imageUpload', 'blockQuote', 'insertTable', 'undo', 'redo'],
                viewportTopOffset: 0,
                shouldNotGroupWhenFull: true
            },
            alignment: {
                options: ['left', 'center', 'right', 'justify']
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>

<style>
    .ck-editor__editable_inline {
        min-height: 300px !important;
    }
</style>