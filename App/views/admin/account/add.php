<?php include 'app/views/shares/headerAdmin.php'; ?>

<h2>Thêm tài khoản mới</h2>
<form action="/s4_php/admin/account/store" method="POST">
    <div class="form-group">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" name="username" id="username" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="fullname">Họ tên:</label>
        <input type="text" name="fullname" id="fullname" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="role_id">Quyền:</label>
        <select name="role_id" id="role_id" class="form-control">
            <option value="1">User</option>
            <option value="2">Admin</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Thêm</button>
    <a href="/s4_php/admin/account" class="btn btn-secondary">Quay lại</a>
</form>

<?php include 'app/views/shares/footerAdmin.php'; ?>
