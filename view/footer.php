    <!-- Footer -->
    <footer>
        <p>© 2025. All rights reserved.</p>
    </footer>

    <script src="./layout/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>

    <!-- AJAX Login Script -->
    <script>
        $(document).ready(function() {
            // Xử lý submit form
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                var username = $('#username').val().trim();
                var password = $('#password').val().trim();

                // check input
                if (!username || !password) {
                    $('#login-message').html('<div class="alert alert-danger">Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu</div>');
                    return;
                }

                $.ajax({
                    url: './dao/login_ajax.php',
                    type: 'POST',
                    data: {
                        login: true,
                        username: username,
                        password: password
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#loginModal').modal('hide');
                            $('#loginForm')[0].reset();
                            $('#login-message').empty();

                            // Cập nhật thanh điều hướng
                            var navItems = `
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?pg=logout">Đăng xuất</a>
                        </li>
                    `;
                            if (response.user.role === 'ADMIN') {
                                navItems = `
                            <li class="nav-item">
                                <a class="nav-link" href="../admin/">Đến trang quản trị</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?pg=logout">Đăng xuất</a>
                            </li>
                        `;
                            }

                            $('.navbar-nav:last').html(navItems);

                            $('.navbar-nav:last').html(navItems);

                            // hiển thị "Tài liệu" và "Thông báo"
                            var leftNavItems = `
                                <li class="nav-item">
                                    <a class="nav-link <?= !isset($_GET['pg']) ? 'active' : '' ?>" aria-current="page" href="index.php">Trang chủ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?= isset($_GET['pg']) && $_GET['pg'] == 'documents' ? 'active' : '' ?>" href="index.php?pg=documents">Tài liệu</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?= isset($_GET['pg']) && $_GET['pg'] == 'notifications' ? 'active' : '' ?>" href="index.php?pg=notifications">Thông báo</a>
                                </li>
                            `;
                            $('.navbar-nav:first').html(leftNavItems);
                        } else {
                            $('#login-message').html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#login-message').html('<div class="alert alert-danger">Lỗi: ' + xhr.status + ' - ' + error + '</div>');
                    }
                });
            });

            // Xóa thông báo khi modal mở lại
            $('#loginModal').on('show.bs.modal', function() {
                $('#login-message').empty();
            });
        });
    </script>