<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
require_once('app/models/FavoriteModel.php');
require_once('app/controllers/AccountController.php');

class BlogController
{ 
    private $productModel;
    private $favoriteModel;
    private $db;
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new productModel($this->db);
        $this->favoriteModel = new favoriteModel($this->db);
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
    
        $user_id = $_SESSION['user_id'] ?? null;
        $favorite_product_ids = [];
        if ($user_id) {
            $favorites = $this->favoriteModel->getUserFavorites($user_id);
            $favorite_product_ids = array_map(fn($favorite) => $favorite['id'], $favorites);
        }
    
        // Phân trang
        $limit = 9; // Số sản phẩm mỗi trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
    
        $products = $this->productModel->getProductsPaginated($limit, $offset);
    
        // Tổng số sản phẩm
        $totalProducts = count($this->productModel->getproducts());
        $totalPages = ceil($totalProducts / $limit);
    
        include 'app/views/blog/index.php';
    }
}