<!-- views/category/create.php -->
<h1>Thêm mới loại sản phẩm</h1>
<form method="POST" action="/category/store">
    <label for="name">Tên:</label>
    <input type="text" id="name" name="name" required>
    <label for="description">Mô tả:</label>
    <textarea id="description" name="description"></textarea>
    <button type="submit">Lưu</button>
</form>
