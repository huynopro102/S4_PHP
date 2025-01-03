<?php include 'app/views/shares/headerAdmin.php'; ?>

<h2>Chỉnh sửa tài khoản</h2>
<form action="/s4_php/admin/account/update/<?php echo $account->id; ?>" method="POST">
    <div class="form-group">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" name="username" id="username" class="form-control" value="<?php echo $account->username; ?>" required>
    </div>
    <div class="form-group">
        <label for="fullname">Họ tên:</label>
        <input type="text" name="fullname" id="fullname" class="form-control" value="<?php echo $account->fullname; ?>" required>
    </div>
    <div class="form-group">
        <label for="password">Mật khẩu mới (bỏ trống nếu không thay đổi):</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>
    <div class="form-group">
        <label for="role_id">Quyền:</label>
        <select name="role_id" id="role_id" class="form-control" required>
            <?php foreach ($roles as $role): ?>
                <option value="<?php echo $role['id']; ?>" 
                    <?php echo ($role['id'] == $current_role) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($role['role_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Cập nhật</button>
    <a href="/s4_php/admin/account" class="btn btn-secondary">Quay lại</a>
</form>

<?php include 'app/views/shares/footerAdmin.php'; ?>