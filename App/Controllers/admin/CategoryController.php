<?php
// Bao gồm model CategoryModel trước khi sử dụng
require_once 'app/models/CategoryModel.php';
class CategoryController
{
    private $categoryModel;

    public function __construct($db)
    {
        $this->categoryModel = new CategoryModel($db); // Đảm bảo đã bao gồm model
    }

    public function index()
    {
        $categories = $this->categoryModel->getCategories();
        // var_dump($categories);  // Kiểm tra kết quả trả về từ database
        include 'app/views/admin/category/index.php';
    }
    
    // Hiển thị form thêm mới danh mục
    public function create()
    {
        include 'app/views/admin/category/create.php';
    }

    // Xử lý việc thêm mới danh mục
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            if ($this->categoryModel->createCategory($name, $description)) {
                header('Location: /app/views/admin/category/index.php');
                exit;
            }
        }
    }

    // Hiển thị form chỉnh sửa danh mục
    public function edit($id)
    {
        $category = $this->categoryModel->getCategoryById($id);
        include '/app/views/admin/category/edit.php';
    }

    // Xử lý việc cập nhật danh mục
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            if ($this->categoryModel->updateCategory($id, $name, $description)) {
                header('Location: /app/views/admin/category/index.php');
                exit;
            }
        }
    }

    // Xử lý việc xóa danh mục
    public function delete($id)
    {
        if ($this->categoryModel->deleteCategory($id)) {
            header('Location: /app/views/admin/category/index.php');
            exit;
        }
    }
}
?>
