<?php

require_once('App/config/Database.php');
require_once('App/models/UserModel.php');
require_once('App/controllers/AccountController.php');

class UserController
{
    private $userModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->userModel = new UserModel($this->db);
    }

    public function index(): void
    {
        $accountController = new AccountController();

        if (!isset($_SESSION['user_id'])) {
            if (!$accountController->autoLogin()) {
                echo "Vui lòng đăng nhập lại.";
                header('Location: /s4_php/account/login');
                exit;
            }
        }

        $users = $this->userModel->getUsers();
        $admin_name = $_SESSION['username'] ?? 'Unknown Admin';
        include 'app/views/admin/user/list.php';
    }

    public function add(): void
    {
        if (!isset($_SESSION['user_roles']) || !in_array('Admin', $_SESSION['user_roles'])) {
            $_SESSION['message'] = 'Bạn không có quyền truy cập trang này.';
            $_SESSION['message_type'] = 'danger';
            header('Location: /s4_php/account/login');
            exit;
        }
        $admin_name = $_SESSION['username'] ?? 'Unknown Admin';
        include 'app/views/admin/user/add.php';
    }

    public function show($id): void
    {
        $user = $this->userModel->getUserById($id);
        if ($user) {
            include 'app/views/admin/user/show.php';
        } else {
            echo "Không tìm thấy người dùng.";
        }
    }

    public function edit($id): void
    {
        if (!in_array('Admin', $_SESSION['user_roles'])) {
            $_SESSION['message'] = 'Bạn không có quyền thực hiện chức năng này.';
            $_SESSION['message_type'] = 'danger';
            header('Location:' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $user = $this->userModel->getUserById($id);
        $admin_name = $_SESSION['username'] ?? 'Unknown Admin';

        if ($user) {
            include 'app/views/admin/user/edit.php';
        } else {
            echo "Không tìm thấy người dùng.";
        }
    }

    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $username = $_POST['username'];
            $fullname = $_POST['fullname'];
            $password = $_POST['password'];
            $admin_name = $_SESSION['username'] ?? 'Unknown Admin';

            if ($this->userModel->updateUser($id, $username, $fullname, $password)) {
                header('Location: /s4_php/admin/user/index');
            } else {
                echo "Đã xảy ra lỗi khi lưu người dùng.";
            }
        }
    }

    public function delete($id): void
    {
        if (!in_array('Admin', $_SESSION['user_roles'])) {
            $_SESSION['message'] = 'Bạn không có quyền thực hiện chức năng này.';
            $_SESSION['message_type'] = 'danger';
            header('Location:' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        if ($this->userModel->deleteUser($id)) {
            $_SESSION['message'] = 'Xóa người dùng thành công';
            $_SESSION['message_type'] = 'success';
            header('Location: /s4_php/admin/user/index');
        } else {
            echo "Đã xảy ra lỗi khi xóa người dùng.";
        }
    }

    public function save(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $fullname = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($this->userModel->addUser($username, $fullname, $password)) {
                $_SESSION['message'] = 'Tạo mới thành công người dùng ' . $username;
                $_SESSION['message_type'] = 'success';
                header('Location: /s4_php/admin/user/index');
                exit;
            } else {
                $_SESSION['message'] = 'Đã xảy ra lỗi khi thêm người dùng.';
                $_SESSION['message_type'] = 'danger';
                include 'app/views/admin/user/add.php';
            }
        }
    }
    
}
