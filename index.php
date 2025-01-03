<?php
session_set_cookie_params(0);     
session_start();

require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CartModel.php');

// -----------------------------------
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'app/helpers/SessionHelper.php';

// Kiểm tra thời gian hoạt động của session
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 60)) {
    session_unset();
    session_destroy();
    header("Location: /S4_php/account/logout");
    exit;
}
$_SESSION['last_activity'] = time();

// Lấy URL và xử lý để phân tích controller và action
$url = $_GET['url'] ?? '';
$url = parse_url($url, PHP_URL_PATH); // Lấy phần đường dẫn, bỏ query string
$url = ltrim($url, '/'); // Loại bỏ dấu "/" ở đầu, nếu có
$url = rtrim($url, '/'); // Loại bỏ dấu "/" ở cuối, nếu có
$url = filter_var($url, FILTER_SANITIZE_URL); // Lọc URL
$url = explode('/', $url); // Tách thành mảng

// Xử lý phần URL nếu là admin
if (isset($url[0]) && $url[0] == 'admin') {
    // Tạo tên controller và action dựa trên URL
    $controllerName = isset($url[1]) && $url[1] != '' ? 
        ucfirst($url[1]) . 'Controller' : 'DashboardController';

    $action = isset($url[2]) && $url[2] != '' ? $url[2] : 'index';

    // Tạo kết nối database
    require_once 'app/config/Database.php';
    $database = new Database();
    $db = $database->getConnection(); // Kết nối đến database

    // Sửa đường dẫn cho đúng với case sensitive
    $controllerFilePath = 'App/Controllers/admin/' . $controllerName . '.php';
    if (!file_exists($controllerFilePath)) {
        die('Controller not found: ' . $controllerFilePath);
    }

    // Bao gồm và khởi tạo controller
    require_once $controllerFilePath;
    $controller = new $controllerName($db); // Truyền kết nối DB vào controller

    // Kiểm tra xem action có tồn tại không
    if (!method_exists($controller, $action)) {
        die('Action not found in admin controller: ' . $action);
    }

    // Gọi action tương ứng
    call_user_func_array([$controller, $action], array_slice($url, 3));
} else {
    $controllerName = isset($url[0]) && $url[0] != '' ? 
        ucfirst($url[0]) . 'Controller' : 'DefaultController';
    $action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';

    // Sửa đường dẫn cho đúng với case sensitive
    if (!file_exists('App/Controllers/' . $controllerName . '.php')) {
        die('Controller not found: App/Controllers/' . $controllerName . '.php');
    }

    require_once 'App/Controllers/' . $controllerName . '.php';
    $controller = new $controllerName();

    if (!method_exists($controller, $action)) {
        die('Action not found in controller: ' . $action);
    }

    call_user_func_array([$controller, $action], array_slice($url, 2));
}