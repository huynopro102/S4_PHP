<?php
session_set_cookie_params(0);     
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'app/helpers/SessionHelper.php';

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 60)) {
    session_unset();
    session_destroy();
    header("Location: /account/logout");
    exit;
}
$_SESSION['last_activity'] = time();




$url = $_GET['url'] ?? '';
$url = parse_url($url, PHP_URL_PATH); // Lấy phần đường dẫn, bỏ query string
$url = ltrim($url, '/'); // Loại bỏ dấu "/" ở đầu, nếu có
$url = rtrim($url, '/'); // Loại bỏ dấu "/" ở cuối, nếu có
$url = filter_var($url, FILTER_SANITIZE_URL); // Lọc URL
$url = explode('/', $url); // Tách thành mảng

var_dump($_GET);

if(isset($url[0])){
    var_dump("[0] rong");
    var_dump($url[0]);
}
if (isset($url[0]) && $url[0] == 'admin') {
    $controllerName = isset($url[1]) && $url[1] != '' ? 
        ucfirst($url[1]) . 'Controller' : 'DashboardController';

    $action = isset($url[2]) && $url[2] != '' ? $url[2] : 'index';

    // Sửa đường dẫn cho đúng với case sensitive
    if (!file_exists('App/Controllers/admin/' . $controllerName . '.php')) {
        die('Controller not found: App/Controllers/admin/' . $controllerName . '.php');
    }

    require_once 'App/Controllers/admin/' . $controllerName . '.php';
    $controller = new $controllerName();

    if (!method_exists($controller, $action)) {
        die('Action not found in admin controller: ' . $action);
    }

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