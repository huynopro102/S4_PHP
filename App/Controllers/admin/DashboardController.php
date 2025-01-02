<?php


// Require necessary files
require_once('app/config/database.php');
require_once('app/helpers/SessionHelper.php');
require_once('app/models/AccountModel.php'); // Sử dụng ActionModel thay vì UserModel

class DashboardController
{


    public function index()
    {
        // Kiểm tra xem người dùng có quyền truy cập dashboard hay không
        if (!isset($_SESSION['user_roles']) || !in_array('Admin', $_SESSION['user_roles'])) {
            $_SESSION['message'] = 'Bạn không có quyền truy cập trang này.';
            $_SESSION['message_type'] = 'danger';
            header('Location: /s4_php/account/login');
            exit;
        }

        $admin_name =  $_SESSION['username'] ?? 'Unknown Admin';

        // Truyền dữ liệu đến view
        include 'App/views/admin/dashboard/index.php';
    }

}
