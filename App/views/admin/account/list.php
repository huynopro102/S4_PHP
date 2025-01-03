<?php include 'app/views/shares/headerAdmin.php'; ?>

<h2>Danh sách tài khoản</h2>
<a href="/s4_php/admin/account/create" class="btn btn-primary mb-3">Thêm tài khoản mới</a>

<?php if (!empty($_SESSION['message'])): ?>
    <div class="alert alert-<?php echo $_SESSION['message_type']; ?>">
        <?php echo $_SESSION['message']; ?>
    </div>
<?php unset($_SESSION['message']); endif; ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên đăng nhập</th>
            <th>Họ tên</th>
            <th>Quyền</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($accounts as $account): ?>
            <tr>
                <td><?php echo $account->id; ?></td>
                <td><?php echo $account->username; ?></td>
                <td><?php echo $account->fullname; ?></td>
                <td><?php 
                    $roles = $accountModel->getRolesByUserId($account->id);
                    echo implode(', ', $roles);
                ?></td>
                <td>
                    <a href="/s4_php/admin/account/edit/<?php echo $account->id; ?>" class="btn btn-warning">Chỉnh sửa</a>
                    <a href="/s4_php/admin/account/delete/<?php echo $account->id; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include 'app/views/shares/footerAdmin.php'; ?>