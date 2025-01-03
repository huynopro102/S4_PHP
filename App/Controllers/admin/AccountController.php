<?php
require_once 'app/models/AccountModel.php';
require_once 'app/controllers/admin/AccountController.php'; // Đảm bảo không khai báo lại class

// Tạo đối tượng Database để lấy kết nối
$database = new Database();
$db = $database->getConnection(); // Kết nối đến cơ sở dữ liệu

// Tạo đối tượng AccountController và truyền đối số $db
$accountController = new AccountController($db);

class AccountController
{
  
    private $accountModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();  // Get DB connection here
        $this->accountModel = new AccountModel($this->db);  // Pass DB to model
    }

    public function index() {
        $accounts = $this->accountModel->getAllAccounts();
        $admin_name = $_SESSION['username'] ?? 'Unknown Admin';
        $accountModel = $this->accountModel; // Thêm dòng này
        include 'app/views/admin/account/list.php';
    }




 

    // Hiển thị form tạo tài khoản
    public function create()
    {
        $admin_name =  $_SESSION['username'] ?? 'Unknown Admin';
        include 'app/views/admin/account/add.php';  // Đảm bảo đúng đường dẫn
    }



    // Lưu tài khoản mới
    public function store()
    {
        $username = $_POST['username'] ?? '';
        $fullname = $_POST['fullname'] ?? '';
        $password = password_hash($_POST['password'] ?? '', PASSWORD_BCRYPT);
        $role_id = $_POST['role_id'] ?? 1;

        if ($this->accountModel->save($username, $fullname, $password, $role_id)) {
            $_SESSION['message'] = 'Tài khoản được tạo thành công.';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Lỗi khi tạo tài khoản.';
            $_SESSION['message_type'] = 'danger';
        }

        header('Location: /s4_php/admin/account');
    }




    // Hiển thị thông tin chi tiết tài khoản
    public function show($id)
    {
        $account = $this->accountModel->getAccountById($id); // Viết thêm hàm này trong model
        include 'app/views/admin/account/show.php';
    }






    public function edit($id)
{
    $admin_name = $_SESSION['username'] ?? 'Unknown Admin';
    $account = $this->accountModel->getAccountById($id); // Lấy thông tin tài khoản
    $roles = $this->accountModel->getAllRoles(); // Lấy danh sách các quyền từ model
    include 'app/views/admin/account/edit.php';  // Đảm bảo đúng đường dẫn
}







public function update($id)
{
    $username = $_POST['username'] ?? '';
    $fullname = $_POST['fullname'] ?? '';
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;
    $role_id = $_POST['role_id'] ?? 1; // Lấy role_id từ form

    if ($this->accountModel->update($id, $username, $fullname, $password, $role_id)) { // Sửa phương thức update
        $_SESSION['message'] = 'Cập nhật tài khoản thành công.';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Lỗi khi cập nhật tài khoản.';
        $_SESSION['message_type'] = 'danger';
    }

    header('Location: /s4_php/admin/account');
    exit;
}




public function delete($id)
{
    // Xóa từ bảng user_roles
    $query = "DELETE FROM user_roles WHERE user_id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Xóa từ bảng orders và order_details liên quan
    $query = "DELETE FROM order_details WHERE order_id IN (SELECT id FROM orders WHERE user_id = :id)";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $query = "DELETE FROM orders WHERE user_id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Xóa từ bảng carts
    $query = "DELETE FROM carts WHERE user_id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Xóa từ bảng favorites
    $query = "DELETE FROM favorites WHERE user_id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Xóa tài khoản từ bảng accounts
    $query = "DELETE FROM accounts WHERE id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Chuyển hướng sau khi xóa thành công
    header('Location: /s4_php/admin/Account/index');
    exit; // Dừng thực thi các mã tiếp theo
}




    // Gán quyền cho tài khoản
    public function assignRole()
    {
        $user_id = $_POST['user_id'];
        $role_id = $_POST['role_id'];

        if ($this->accountModel->assignRoleToUser($user_id, $role_id)) { // Viết thêm hàm này
            $_SESSION['message'] = 'Gán quyền thành công.';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Lỗi khi gán quyền.';
            $_SESSION['message_type'] = 'danger';
        }

        header('Location: /s4_php/admin/account/edit/' . $user_id);
    }
}
