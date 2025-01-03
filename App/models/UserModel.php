<?php
class UserModel
{
    private $conn;
    private $table_name = "users";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy thông tin người dùng bằng ID
    public function getUserById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Thêm người dùng mới
    public function addUser($username, $fullname, $password, $email = null, $role_id = 1)
    {
        try {
            $this->conn->beginTransaction();

            $query = "INSERT INTO " . $this->table_name . " (username, fullname, password, email) VALUES (:username, :fullname, :password, :email)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':email', $email);

            if ($stmt->execute()) {
                $user_id = $this->conn->lastInsertId();

                $role_query = "INSERT INTO user_roles (user_id, role_id) VALUES (:user_id, :role_id)";
                $role_stmt = $this->conn->prepare($role_query);

                $role_stmt->bindParam(':user_id', $user_id);
                $role_stmt->bindParam(':role_id', $role_id);

                if ($role_stmt->execute()) {
                    $this->conn->commit();
                    return true;
                }
            }

            $this->conn->rollBack();
            return false;
        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Error adding user: " . $e->getMessage());
            return false;
        }
    }

    // Lấy danh sách người dùng
    public function getUsers()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Cập nhật thông tin người dùng
    public function updateUser($id, $username, $fullname, $password = null, $email = null)
    {
        try {
            $query = "UPDATE " . $this->table_name . " 
                      SET username = :username, fullname = :fullname, email = :email" .
                ($password ? ", password = :password" : "") . 
                " WHERE id = :id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':email', $email);
            if ($password) {
                $stmt->bindParam(':password', $password);
            }

            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error updating user: " . $e->getMessage());
            return false;
        }
    }

    // Xóa người dùng
    public function deleteUser($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Lấy danh sách vai trò của người dùng
    public function getRolesByUserId($user_id)
    {
        $sql = "SELECT r.role_name 
                FROM user_roles ur 
                JOIN roles r ON ur.role_id = r.id 
                WHERE ur.user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
