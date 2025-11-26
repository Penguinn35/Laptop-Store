<?php
// app/controllers/AdminProductController.php

class AdminProductController
{
    private $laptopModel;

    public function __construct()
    {
        Auth::requireAdmin(); // giả sử Auth có hàm này
        $this->laptopModel = new Laptop();
    }

    public function index()
    {
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
        $page    = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit   = 20;
        $offset  = ($page - 1) * $limit;

        $total       = $this->laptopModel->countAll($keyword); // dùng lại hoặc viết riêng countAllAdmin
        $products    = $this->laptopModel->getAllAdmin($keyword, $limit, $offset);
        $total_pages = ceil($total / $limit);

        require_once __DIR__ . '/../views/admin/products/index.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // validate + upload ảnh
            // gọi $this->laptopModel->create($data);
            // redirect về index
        }

        require_once __DIR__ . '/../views/admin/products/create.php';
    }

    public function edit()
    {
        $id = (int)($_GET['id'] ?? 0);
        // load laptop, xử lý POST update, upload ảnh mới nếu có
        require_once __DIR__ . '/../views/admin/products/edit.php';
    }

    public function delete()
    {
        $id = (int)($_GET['id'] ?? 0);
        $this->laptopModel->delete($id);
        header('Location: /admin/products');
        exit;
    }
}
