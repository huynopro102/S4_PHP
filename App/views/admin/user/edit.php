<?php include 'app/views/shares/headerAdmin.php'; ?>

<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-<?= $_SESSION['message_type'] ?> mt-3">
        <?= $_SESSION['message'] ?>
        <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
    </div>
<?php endif; ?>



<div class="container mt-5">
    <h1>Chỉnh sửa Người dùng</h1>
    <?php if ($user): ?>
        <form action="/s4_php/admin/user/update" method="POST">
            <input type="hidden" name="id" value="<?= $user->id ?>">
            <div class="form-group">
                <label for="username">Tên người dùng</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user->username) ?>" required>
            </div>
            <div class="form-group">
                <label for="fullname">Họ và tên</label>
                <input type="text" class="form-control" id="fullname" name="fullname" value="<?= htmlspecialchars($user->fullname) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user->email) ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu mới (nếu muốn đổi)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="/s4_php/admin/user/index" class="btn btn-secondary">Hủy</a>
        </form>
    <?php else: ?>
        <p>Không tìm thấy thông tin người dùng.</p>
    <?php endif; ?>
</div>
<?php include 'app/views/shares/footerAdmin.php'; ?>
