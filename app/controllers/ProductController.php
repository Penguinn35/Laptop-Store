<?php
// app/controllers/ProductController.php

require_once __DIR__ . '/../models/Laptop.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../models/Setting.php';
// 1. NẠP MODEL ORDER
require_once __DIR__ . '/../models/Order.php';

class ProductController
{
    private $laptopModel;
    private $db;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->db = (new Database())->getConnection();
        $this->laptopModel = new Laptop();

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

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

        // Nếu giỏ hàng rỗng, đá về trang sản phẩm
        if (empty($_SESSION['cart'])) {
            header('Location: index.php?page=products');
            exit;
        }

        // Lấy thông tin sản phẩm trong giỏ để hiển thị lại
        $cart_items = [];
        $total = 0;
        
        $ids = array_map('intval', array_keys($_SESSION['cart']));
        if (!empty($ids)) {
            $ids_str = implode(',', $ids);
            $sql = "SELECT * FROM laptops WHERE id IN ($ids_str)";
            $result = $this->db->query($sql);
            
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $qty = $_SESSION['cart'][$id];
                $price = $row['price'];
                $subtotal = $price * $qty;
                $total += $subtotal;

                $cart_items[] = [
                    'id' => $id,
                    'name' => $row['name'],
                    'price' => $price,
                    'qty' => $qty,
                    'subtotal' => $subtotal
                ];
            }
        }

        // Thông tin user nếu đã đăng nhập (để điền sẵn vào form)
        $user = $_SESSION['user'] ?? null;

        require_once __DIR__ . '/../views/cart/checkout.php';
    }

    // --- HÀM MỚI: XỬ LÝ THANH TOÁN ---
    public function processCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=checkout');
            exit;
        }

        if (empty($_SESSION['cart'])) {
            header('Location: index.php?page=products');
            exit;
        }

        // 1. Lấy dữ liệu từ Form
        $fullname = $_POST['fullname'] ?? '';
        $email    = $_POST['email'] ?? '';
        $phone    = $_POST['phone'] ?? '';
        $address  = $_POST['address'] ?? '';
        $note     = $_POST['note'] ?? '';

        // 2. Tính toán lại tổng tiền và chuẩn bị danh sách items
        // (Không tin tưởng dữ liệu giá từ client gửi lên, phải query lại DB)
        $items_for_db = [];
        $total_amount = 0;

        $ids = array_map('intval', array_keys($_SESSION['cart']));
        if (!empty($ids)) {
            $ids_str = implode(',', $ids);
            $sql = "SELECT id, price FROM laptops WHERE id IN ($ids_str)";
            $result = $this->db->query($sql);
            
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $qty = (int)$_SESSION['cart'][$id];
                $price = (float)$row['price'];
                
                $total_amount += ($price * $qty);

                // Cấu trúc item khớp với Model Order::createOrder
                $items_for_db[] = [
                    'laptop_id'  => $id,
                    'quantity'   => $qty,
                    'unit_price' => $price
                ];
            }
        }

        // 3. Chuẩn bị dữ liệu Order
        $orderData = [
            'user_id'      => isset($_SESSION['user']) ? $_SESSION['user']['id'] : null, // Nếu khách vãng lai thì null
            'full_name'    => $fullname,
            'email'        => $email,
            'phone'        => $phone,
            'address'      => $address,
            'note'         => $note,
            'total_amount' => $total_amount,
            'status'       => 'pending'
        ];

        // 4. Gọi Model để lưu
        $orderModel = new Order();
        $orderId = $orderModel->createOrder($orderData, $items_for_db);

        if ($orderId) {
            // Thành công: Xóa giỏ hàng và chuyển hướng
            unset($_SESSION['cart']);
            header('Location: index.php?page=order_success&id=' . $orderId);
            exit;
        } else {
            // Thất bại
            echo "<script>alert('Có lỗi xảy ra khi tạo đơn hàng. Vui lòng thử lại!'); window.history.back();</script>";
        }
    }

    // --- HÀM MỚI: TRANG THÔNG BÁO THÀNH CÔNG ---
    public function orderSuccess()
    {
        $settings = $this->getSettings();
        $orderId = $_GET['id'] ?? 0;
        require_once __DIR__ . '/../views/cart/success.php';
    }
}