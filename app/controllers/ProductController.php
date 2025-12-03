<?php
// app/controllers/ProductController.php

require_once __DIR__ . '/../models/Laptop.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../models/Setting.php'; 

class ProductController
{
    private $laptopModel;
    private $db; // Biến để lưu kết nối DB dùng chung

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Tạo kết nối DB
        $this->db = (new Database())->getConnection();

        // Khởi tạo model Laptop
        $this->laptopModel = new Laptop(); // Lưu ý: Laptop model của bạn có thể cần truyền $db vào constructor tùy cách bạn viết

        // Khởi tạo giỏ hàng nếu chưa có
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = []; 
        }
    }

    // Hàm hỗ trợ lấy Settings cho đỡ lặp code
    private function getSettings() {
        $settingModel = new Setting($this->db);
        return $settingModel->all();
    }

    public function index()
    {
        // 2. Gọi hàm lấy settings
        $settings = $this->getSettings(); 

        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
        $page    = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
        $limit   = 9;
        $offset  = ($page - 1) * $limit;

        $total       = $this->laptopModel->countAll($keyword);
        $products    = $this->laptopModel->getAll($keyword, $limit, $offset);
        $total_pages = ($total > 0) ? ceil($total / $limit) : 1;

        $data = [
            'keyword'     => $keyword,
            'page'        => $page,
            'total'       => $total,
            'total_pages' => $total_pages,
            'products'    => $products,
        ];

        // Biến $settings bây giờ đã tồn tại và sẽ được dùng trong footer.php
        include __DIR__ . '/../views/products/index.php';
    }

    public function detail()
    {
        $settings = $this->getSettings(); // Lấy setting cho footer/header
        
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) {
            echo "Sản phẩm không hợp lệ"; return;
        }

        $product = $this->laptopModel->findById($id);
        if (!$product) {
            http_response_code(404); echo "Không tìm thấy sản phẩm"; return;
        }

        // --- CODE MỚI: Lấy 4 sản phẩm ngẫu nhiên làm "Sản phẩm liên quan" ---
        // (Đây là query đơn giản, sau này bạn có thể query theo cùng brand_id)
        $relatedProducts = [];
        $sql = "SELECT * FROM laptops WHERE id != $id ORDER BY RAND() LIMIT 4";
        $result = $this->db->query($sql);
        if($result) {
            while($row = $result->fetch_assoc()) { $relatedProducts[] = $row; }
        }
        // --------------------------------------------------------------------

        // Truyền $product và $relatedProducts sang View
        // Lưu ý: Không cần gói vào mảng $data nếu bạn dùng extract hoặc gọi trực tiếp $product ở view
        // Nhưng để thống nhất với code cũ của bạn (dùng $product trực tiếp), ta chỉ cần include view.
        
        include __DIR__ . '/../views/products/details.php';
    }

    public function addToCart()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=products');
            exit;
        }

        $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        $qty       = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        if ($productId <= 0 || $qty <= 0) {
            header('Location: index.php?page=products');
            exit;
        }

        $product = $this->laptopModel->findById($productId);
        if (!$product) {
            header('Location: index.php?page=products');
            exit;
        }

        if (!isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] = 0;
        }
        $_SESSION['cart'][$productId] += $qty;

        header('Location: index.php?page=cart');
        exit;
    }

    public function cart()
    {
        // 4. Gọi hàm lấy settings cho trang giỏ hàng
        $settings = $this->getSettings();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            if ($action === 'update' && isset($_POST['qty']) && is_array($_POST['qty'])) {
                foreach ($_POST['qty'] as $id => $qty) {
                    $id  = (int)$id;
                    $qty = (int)$qty;

                    if ($qty <= 0) {
                        unset($_SESSION['cart'][$id]);
                    } else {
                        $_SESSION['cart'][$id] = $qty;
                    }
                }
            } elseif ($action === 'clear') {
                $_SESSION['cart'] = [];
            }

            header('Location: index.php?page=cart');
            exit;
        }

        $cart_items = [];
        $total      = 0;

        if (!empty($_SESSION['cart'])) {
            $ids = array_map('intval', array_keys($_SESSION['cart']));
            // Fix lỗi array rỗng khi query
            if (!empty($ids)) {
                $ids_str = implode(',', $ids);
                // Dùng $this->db đã tạo ở constructor
                $sql  = "SELECT * FROM laptops WHERE id IN ($ids_str)";
                $result = $this->db->query($sql);

                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $id   = (int)$row['id'];
                        $qty  = (int)$_SESSION['cart'][$id];
                        $price = (float)$row['price'];
                        $subtotal = $price * $qty;
                        $total   += $subtotal;

                        $cart_items[] = [
                            'id'        => $id,
                            'name'      => $row['name'],
                            'image'     => $row['image'],
                            'price'     => $price,
                            'qty'       => $qty,
                            'subtotal'  => $subtotal
                        ];
                    }
                    $result->free();
                }
            }
        }

        $data = [
            'items' => $cart_items,
            'total' => $total
        ];

        include __DIR__ . '/../views/cart/index.php';
    }

    public function checkout()
    {
        $settings = $this->getSettings();
        echo "Checkout – bạn có thể hiện thực sau.";
    }
}