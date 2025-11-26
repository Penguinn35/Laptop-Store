<?php
// app/controllers/ProductController.php

require_once __DIR__ . '/../models/Laptop.php';
require_once __DIR__ . '/../core/Database.php';

class ProductController
{
    private $laptopModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Khởi tạo model Laptop
        $this->laptopModel = new Laptop();

        // Khởi tạo giỏ hàng nếu chưa có
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = []; // [laptop_id => quantity]
        }
    }

    /**
     * Trang danh sách sản phẩm
     * Router: ?page=products
     */
    public function index()
    {
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
        $page    = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1; // dùng p để tránh trùng với page=route
        $limit   = 9;
        $offset  = ($page - 1) * $limit;

        $total       = $this->laptopModel->countAll($keyword);
        $products    = $this->laptopModel->getAll($keyword, $limit, $offset);
        $total_pages = ($total > 0) ? ceil($total / $limit) : 1;

        // Truyền data sang view
        $data = [
            'keyword'     => $keyword,
            'page'        => $page,
            'total'       => $total,
            'total_pages' => $total_pages,
            'products'    => $products,
        ];

        // View: app/views/products/index.php (bạn tự tạo)
        include __DIR__ . '/../views/products/index.php';
    }

    /**
     * Trang chi tiết sản phẩm
     * Router: ?page=product_detail&id=...
     */
    public function detail()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) {
            echo "Sản phẩm không hợp lệ";
            return;
        }

        $product = $this->laptopModel->findById($id);
        if (!$product) {
            http_response_code(404);
            echo "Không tìm thấy sản phẩm";
            return;
        }

        $data = [
            'product' => $product
        ];

        // View: app/views/products/detail.php
        include __DIR__ . '/../views/products/details.php';
    }

    /**
     * Thêm sản phẩm vào giỏ (method POST)
     * Router: ?page=cart_add
     */
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

        // Kiểm tra sản phẩm tồn tại
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

    /**
     * Trang giỏ hàng + cập nhật giỏ (POST)
     * Router: ?page=cart
     */
    public function cart()
    {
        // Xử lý POST: cập nhật / xóa / clear giỏ
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

        // Hiển thị giỏ hàng
        $cart_items = [];
        $total      = 0;

        if (!empty($_SESSION['cart'])) {
            $ids = array_map('intval', array_keys($_SESSION['cart']));
            $ids_str = implode(',', $ids);

            $db   = new Database();
            $conn = $db->getConnection();

            $sql  = "SELECT * FROM laptops WHERE id IN ($ids_str)";
            $result = $conn->query($sql);

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $id   = (int)$row['id'];
                    $qty  = (int)$_SESSION['cart'][$id];
                    $price = (float)$row['price']; // nếu sau này có sale_price thì sửa lại
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

        $data = [
            'items' => $cart_items,
            'total' => $total
        ];

        // View: app/views/cart/index.php
        include __DIR__ . '/../views/cart/index.php';
    }

    /**
     * (Tùy chọn) Trang checkout – nếu bạn muốn tạo đơn hàng luôn.
     * Router: ?page=checkout
     * Bạn có thể xử lý dùng model Order ở đây.
     */
    public function checkout()
    {
        // TODO: viết sau nếu cần, dùng model Order để tạo đơn hàng từ $_SESSION['cart']
        echo "Checkout – bạn có thể hiện thực sau.";
    }
}
