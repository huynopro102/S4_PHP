<?php

class Database
{
    private $host = "15.235.197.40";
    private $db_name = "my_store";
    private $username = "root";
    private $password = "5Yn01pC8X8noLQOt7jUXtsLSBh3";
    public $conn;
    private $socket = "/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock"; // Thêm socket nếu cần
    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name};unix_socket={$this->socket}", $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
