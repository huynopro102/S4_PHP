<?php

namespace Admin;

// Thêm các use để sử dụng các lớp từ các namespace khác
use Database;
use App\Models\ProductModel; // Chú ý đúng tên lớp, đúng namespace
use App\Models\CategoryModel;
use App\Models\FavoriteModel; // Chỉnh sửa từ favoriteModel thành FavoriteModel (viết hoa chữ cái đầu)
use App\Controllers\Admin\AccountController;


// Require các file cần thiết
require_once('app/config/database.php');
require_once('App/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
require_once('app/models/FavoriteModel.php');
require_once('app/controllers/AccountController.php');


class ProductController
{
    public function index(): void
    {

        // Kiểm tra xem người dùng có quyền truy cập dashboard hay không
        if (!isset($_SESSION['user_roles']) || !in_array('Admin', $_SESSION['user_roles'])) {
            $_SESSION['message'] = 'Bạn không có quyền truy cập trang này.';
            $_SESSION['message_type'] = 'danger';
            header('Location: /s4_php/account/login');
            exit;
        }

        $admin_name =  $_SESSION['username'] ?? 'Unknown Admin';

        include 'app/views/admin/product/add.php';
    }
}
