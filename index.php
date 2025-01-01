<?php
// ini_set('session.gc_maxlifetime', 60); // 1 phút
session_set_cookie_params(0);     
session_start();

// Bật hiển thị lỗi
ini_set('display_errors', 1);
error_reporting(error_level: E_ALL);

// require_once 'app/models/ProductModel.php';
// require_once 'app/models/CartModel.php';
require_once 'app/helpers/SessionHelper.php';

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 60)) {
    session_unset();
    session_destroy();
    header("Location: /s4_php/account/logout");
    exit;
}
$_SESSION['last_activity'] = time();

// product/add
$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// --------------------check admin-------------------------

$controllerName = isset($url[0]) && $url[0] == 'admin' ? 
    'Admin\\' . ucfirst($url[1]) . 'Controller' : 
    (isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' : 'DefaultController');

// Xác định action
$action = isset($url[2]) && $url[2] != '' ? $url[2] : 'index';

// --------------------/check admin------------------------

// Kiểm tra phần đầu tiên của URL để xác định controller
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' :  'DefaultController';
// Kiểm tra phần thứ hai của URL để xác định action
$action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';

// die ("controller=$controllerName - action=$action");
// Kiểm tra xem controller và action có tồn tại không
if (!file_exists('app/controllers/' . $controllerName . '.php')) {
    // Xử lý không tìm thấy controller
    die('Controller not found');
}

require_once 'app/controllers/' . $controllerName . '.php';

$controller = new $controllerName();

if (!method_exists($controller, $action)) {
    // Xử lý không tìm thấy action
    die('Action not found');
}

// Gọi action với các tham số còn lại (nếu có)
call_user_func_array([$controller, $action], array_slice($url, 2));
