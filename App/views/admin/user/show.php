<?php include 'app/views/shares/headerAdmin.php'; ?>
<div class="container mt-5">
    <h1>Thông tin Người dùng</h1>
    <?php if ($user): ?>
        <p><strong>ID:</strong> <?= $user->id ?></p>
        <p><strong>Tên người dùng:</strong> <?= htmlspecialchars($user->username) ?></p>
        <p><strong>Họ và tên:</strong> <?= htmlspecialchars($user->fullname) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user->email) ?></p>
        <a href="/s4_php/admin/user/index" class="btn btn-secondary">Quay lại</a>
    <?php else: ?>
        <p>Không tìm thấy thông tin người dùng.</p>
    <?php endif; ?>
</div>
<?php include 'app/views/shares/footerAdmin.php'; ?>
