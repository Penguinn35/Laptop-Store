<?php
// app/controllers/AdminOrderController.php

class AdminOrderController
{
    private $orderModel;

    public function __construct()
    {
        Auth::requireAdmin();
        $this->orderModel = new Order();
    }

    public function index()
    {
        $status = isset($_GET['status']) ? $_GET['status'] : '';
        $page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit  = 20;
        $offset = ($page - 1) * $limit;

        $orders = $this->orderModel->getAll($status, $limit, $offset);
        // tính total nếu cần phân trang kỹ
        require_once __DIR__ . '/../views/admin/orders/index.php';
    }

    public function view()
    {
        $id    = (int)($_GET['id'] ?? 0);
        $order = $this->orderModel->getById($id);
        if (!$order) {
            echo "Không tìm thấy đơn hàng";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'] ?? '';
            $this->orderModel->updateStatus($id, $status);
            header('Location: /admin/orders/view?id=' . $id);
            exit;
        }

        require_once __DIR__ . '/../views/admin/orders/view.php';
    }
}
