<?php include 'app/views/shares/headerAdmin.php'; ?>
<div class="container mt-5">
    <h1>Thêm Người dùng</h1>
    <form action="/s4_php/admin/user/save" method="POST">
        <div class="form-group">
            <label for="username">Tên người dùng</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="fullname">Họ và tên</label>
            <input type="text" class="form-control" id="fullname" name="fullname" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Thêm mới</button>
        <a href="/s4_php/admin/user/index" class="btn btn-secondary">Hủy</a>
    </form>
</div>
<?php include 'app/views/shares/footerAdmin.php'; ?>
