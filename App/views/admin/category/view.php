<?php include 'app/views/shares/headerAdmin.php'; ?>




<h1>Danh sách các loại sản phẩm</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Mô tả</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $category): ?>
        <tr>
            <td><?php echo $category->id; ?></td>
            <td><?php echo $category->name; ?></td>
            <td><?php echo $category->description; ?></td>
            <td>
                <a href="/category/edit/<?php echo $category->id; ?>">Sửa</a>
                <a href="/category/delete/<?php echo $category->id; ?>">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a href="/category/create">Thêm mới</a>



<?php include 'app/views/shares/footerAdmin.php'; ?>