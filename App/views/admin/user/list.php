<?php include 'app/views/shares/headerAdmin.php'; ?>
<div class="container mt-5">
    <h1>Quản lý Người dùng</h1>
    <a href="/s4_php/admin/user/add" class="btn btn-success mb-3">Thêm Người dùng</a>
    <?php if (!empty($users)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên người dùng</th>
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user->id ?></td>
                        <td><?= htmlspecialchars($user->username) ?></td>
                        <td><?= htmlspecialchars($user->fullname) ?></td>
                        <td><?= htmlspecialchars($user->email) ?></td>
                        <td>
                            <a href="/s4_php/admin/user/show/<?= $user->id ?>" class="btn btn-info btn-sm">Xem</a>
                            <a href="/s4_php/admin/user/edit/<?= $user->id ?>" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="/s4_php/admin/user/delete/<?= $user->id ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Không có người dùng nào.</p>
    <?php endif; ?>
</div>
<?php include 'app/views/shares/footerAdmin.php'; ?>
