<div class="table-container px-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="color: rgb(60, 102, 215);">Quản lý người dùng</h3>
        <a href="index.php?pg=adduser" class="btn btn-success">
            <i class="fas fa-plus"></i> Thêm
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>
                        <a href="index.php?pg=users&sort=id&order=DESC" class="sort-link active">
                            ID
                            <i class="fas fa-sort-down"></i>
                        </a>
                    </th>
                    <th>
                        <a href="index.php?pg=users&sort=email&order=ASC" class="sort-link">
                            Email
                            <i class="fas fa-sort"></i>
                        </a>
                    </th>
                    <th>
                        <a href="index.php?pg=users&sort=name&order=ASC" class="sort-link">
                            Tên
                            <i class="fas fa-sort"></i>
                        </a>
                    </th>


                    <th>
                        <a href="index.php?pg=users&sort=role&order=ASC" class="sort-link">
                            Vai trò
                            <i class="fas fa-sort"></i>
                        </a>
                    </th>
                    <th>
                        <a href="index.php?pg=users&sort=role&order=ASC" class="sort-link">
                            Danh mục tài liệu truy cập
                            <i class="fas fa-sort"></i>
                        </a>
                    </th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>nguyenvana@example.com</td>
                    <td>Nguyễn Văn A</td>
                    <td>Admin</td>
                    <td>Trường 1</td>
                    <td>
                        <a href="index.php?pg=updateuser&id=1">
                            <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Sửa</button>
                        </a>
                        <a href="index.php?pg=deleteuser&id=1" onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                            <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Xóa</button>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>tranvanb@example.com</td>
                    <td>Trần Văn B</td>
                    <td>User</td>
                    <td>Trường 2</td>
                    <td>
                        <a href="index.php?pg=updateuser&id=2">
                            <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Sửa</button>
                        </a>
                        <a href="index.php?pg=deleteuser&id=2" onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                            <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Xóa</button>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>lethic@example.com</td>
                    <td>Lê Thị C</td>
                    <td>User</td>
                    <td>Trường 3</td>
                    <td>
                        <a href="index.php?pg=updateuser&id=3">
                            <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Sửa</button>
                        </a>
                        <a href="index.php?pg=deleteuser&id=3" onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                            <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Xóa</button>
                        </a>
                    </td>
                </tr>


            </tbody>
        </table>
    </div>

    <!-- Paging -->
    <!-- <nav aria-label="Page navigation">
        <ul class="pagination">
            <li class="page-item <?= $current_page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="index.php?pg=users&page=<?= $current_page - 1 ?>&sort=<?= $sort ?>&order=<?= $order ?>" aria-label="Previous">
                    <span aria-hidden="true">«</span>
                </a>
            </li>

            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                <li class="page-item <?= $current_page == $i ? 'active' : '' ?>">
                    <a class="page-link" href="index.php?pg=users&page=<?= $i ?>&sort=<?= $sort ?>&order=<?= $order ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <li class="page-item <?= $current_page >= $total_pages ? 'disabled' : '' ?>">
                <a class="page-link" href="index.php?pg=users&page=<?= $current_page + 1 ?>&sort=<?= $sort ?>&order=<?= $order ?>" aria-label="Next">
                    <span aria-hidden="true">»</span>
                </a>
            </li>
        </ul>
    </nav> -->

</div>