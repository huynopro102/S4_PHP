<?php include 'app/views/shares/headerAdmin.php'; ?>

<form method="POST" action="/s4_php/account/assignRole">
    <label for="role">Chọn quyền:</label>
    <select name="role_id" id="role">
        <option value="1">User</option>
        <option value="2">Admin</option>
        <!-- Thêm các quyền khác nếu cần -->
    </select>
    <input type="hidden" name="user_id" value="<?php echo $account->id; ?>" />
    <button type="submit">Gán quyền</button>
</form>


<?php include 'app/views/shares/footerAdmin.php'; ?>
