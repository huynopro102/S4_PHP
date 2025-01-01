<!-- 
đây là dữ liệu của hàm getRolesByUserId , trả về mảng 
Array
(
    [user_id] => 1
    [username] => admin
    [role] => admin
)
 -->

<?php
class SessionHelper
{
    public static function isLoggedIn(): bool {
        return isset($_SESSION['user_id']); // Kiểm tra session đăng nhập
    }

    public static function isAdmin(): bool {
        return isset($_SESSION['user_roles']) && in_array('Admin', $_SESSION['user_roles'], true);
    }
    
    


       // Hàm mới để hiển thị các Superglobal
       public static function displaySuperglobals() {
        echo "<h3>PHP Superglobal Variables:</h3>";
        
        // $_SESSION - Biến phiên làm việc
        echo "<h4>1. \$_SESSION:</h4>";
        echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";

        // $_GET - Dữ liệu từ URL
        echo "<h4>2. \$_GET:</h4>";
        echo "<pre>";
        print_r($_GET);
        echo "</pre>";

        // $_POST - Dữ liệu từ form method POST
        echo "<h4>3. \$_POST:</h4>";
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";

        // $_COOKIE - Cookie của trình duyệt
        echo "<h4>4. \$_COOKIE:</h4>";
        echo "<pre>";
        print_r($_COOKIE);
        echo "</pre>";

        // $_SERVER - Thông tin về máy chủ
        echo "<h4>5. \$_SERVER:</h4>";
        echo "<pre>";
        print_r($_SERVER);
        echo "</pre>";

        // $_FILES - File được upload
        echo "<h4>6. \$_FILES:</h4>";
        echo "<pre>";
        print_r($_FILES);
        echo "</pre>";

        // $_ENV - Biến môi trường
        echo "<h4>7. \$_ENV:</h4>";
        echo "<pre>";
        print_r($_ENV);
        echo "</pre>";

        // $_REQUEST - Kết hợp của $_GET, $_POST và $_COOKIE
        echo "<h4>8. \$_REQUEST:</h4>";
        echo "<pre>";
        print_r($_REQUEST);
        echo "</pre>";

        // $GLOBALS - Chứa tất cả các biến toàn cục
        echo "<h4>9. \$GLOBALS:</h4>";
        echo "<pre>";
        print_r($GLOBALS);
        echo "</pre>";
    }



}
