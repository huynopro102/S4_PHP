<!-- views/category/edit.php -->
<h1>Chỉnh sửa loại sản phẩm</h1>
<form method="POST" action="/category/update/<?php echo $category->id; ?>">
    <label for="name">Tên:</label>
    <input type="text" id="name" name="name" value="<?php echo $category->name; ?>" required>
    <label for="description">Mô tả:</label>
    <textarea id="description" name="description"><?php echo $category->description; ?></textarea>
    <button type="submit">Cập nhật</button>
</form>
