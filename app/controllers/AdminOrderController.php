<?php
// app/controllers/AdminOrderController.php

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Setting.php';

class AdminOrderController
{
    private $orderModel;
    private $db; // <--- Cần thêm thuộc tính này

    public function __construct()
    {
        Auth::requireAdmin();
        $this->db = (new Database())->getConnection(); // <--- Khởi tạo DB
        $this->orderModel = new Order();
    }

    // --- BỔ SUNG HÀM LẤY SETTINGS ---
    private function getSettings() {
        $settingModel = new Setting($this->db);
        return $settingModel->all();
    }

    public function index()
    {
        $settings = $this->getSettings(); // <--- Bổ sung

        $status = isset($_GET['status']) ? $_GET['status'] : '';
        $page   = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
        $limit  = 20;
        $offset = ($page - 1) * $limit;

        $orders = $this->orderModel->getAll($status, $limit, $offset);
        
        require_once __DIR__ . '/../views/admin/orders/index.php';
    }

    public function view()
    {
        $settings = $this->getSettings(); // <--- Bổ sung

        $id = (int)($_GET['id'] ?? 0);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'] ?? '';
            $this->orderModel->updateStatus($id, $status);
            header('Location: index.php?page=admin_order_view&id=' . $id);
            exit;
        }

        $order = $this->orderModel->getById($id);
        
        if (!$order) {
            echo "Không tìm thấy đơn hàng";
            return;
        }

        require_once __DIR__ . '/../views/admin/orders/view.php';
    }
}