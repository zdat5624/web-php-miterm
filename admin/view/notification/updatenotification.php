<?php

$errors = [];
$success = '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$notification = $id > 0 ? get_notification_by_id($id) : null;

if (!$notification) {
    $errors[] = 'Thông báo không tồn tại.';
} else {
    $title = $notification['title'];
    $content = $notification['content'];
    $university_id = $notification['university_id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content_notification'] ?? '');
    $university_id = (int)($_POST['university_id'] ?? 0);


    $sql = "SELECT id FROM universities WHERE id = ?";
    $university = pdo_query_one($sql, $university_id);
    if (!$university) {
        $errors[] = 'Trường đại học không tồn tại.';
    }

    if (empty($errors)) {
        try {
            update_notification($id, $title, $content, $university_id);
            $success = 'Cập nhật thông báo thành công!';
            header("Refresh: 2; url=index.php?pg=notifications");
        } catch (PDOException $e) {
            $errors[] = 'Lỗi khi cập nhật thông báo: ' . $e->getMessage();
        }
    }
}

$universities = get_all_universities();
?>


<div class="container mt-5 min-vh-100">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="color: rgb(60, 102, 215);">Cập nhật thông báo</h3>
        <a href="index.php?pg=notifications" class="btn btn-outline-secondary">← Quay lại</a>
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

    <form method="POST" action="index.php?pg=updatenotification&id=<?php echo $id; ?>">
        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
        </div>
        <div class="mb-3 editor-container">
            <label for="content_notification" class="form-label">Nội dung <span class="text-danger">*</span></label>
            <textarea name="content_notification" id="content_notification" class="form-control" required><?php echo htmlspecialchars($content); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="university_id" class="form-label">Chọn trường <span class="text-danger">*</span></label>
            <select class="form-select" id="university_id" name="university_id" required>
                <?php foreach ($universities as $university): ?>
                    <option value="<?php echo $university['id']; ?>" <?php echo $university_id == $university['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($university['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Cập nhật</button>
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

    // Xem trước ảnh (xóa nếu không sử dụng)
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('preview');
            output.src = reader.result;
            output.style.display = "block";
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<style>
    .ck-editor__editable_inline {
        min-height: 300px !important;


    }
</style>