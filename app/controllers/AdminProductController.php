<?php
// app/controllers/AdminProductController.php

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../models/Laptop.php';
require_once __DIR__ . '/../core/Database.php'; 
require_once __DIR__ . '/../models/Setting.php';

class AdminProductController
{
    private $laptopModel;
    private $db;

    public function __construct()
    {
        Auth::requireAdmin(); 
        $this->laptopModel = new Laptop();
        $this->db = (new Database())->getConnection();
    }

    // --- BỔ SUNG HÀM LẤY SETTINGS ---
    private function getSettings() {
        $settingModel = new Setting($this->db);
        return $settingModel->all();
    }

    private function getBrands() {
        $sql = "SELECT * FROM brands";
        $result = $this->db->query($sql);
        $brands = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $brands[] = $row;
            }
        }
        return $brands;
    }

    public function index()
    {
        // --- GỌI SETTINGS ĐỂ TRUYỀN XUỐNG FOOTER ---
        $settings = $this->getSettings();

        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
        $page    = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
        $limit   = 10;
        $offset  = ($page - 1) * $limit;

        $total       = $this->laptopModel->countAll($keyword);
        $products    = $this->laptopModel->getAllAdmin($keyword, $limit, $offset);
        $total_pages = ceil($total / $limit);

        $useTabler = true; 
        require_once __DIR__ . '/../views/admin/products/index.php';
    }

    public function create()
    {
        $settings = $this->getSettings(); // <--- Bổ sung
        $brands = $this->getBrands();
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $imageName = 'no-image.jpg';
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $targetDir = "images/products_img/";
                $fileExtension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                $newFileName = uniqid() . '.' . $fileExtension;
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetDir . $newFileName)) {
                    $imageName = $newFileName;
                }
            }
            $data['image'] = $imageName;

            if ($this->laptopModel->create($data)) {
                header('Location: index.php?page=admin_products');
                exit;
            } else {
                $error = "Có lỗi xảy ra khi thêm sản phẩm.";
            }
        }

        $useTabler = true;
        require_once __DIR__ . '/../views/admin/products/create.php';
    }

    public function edit()
    {
        $settings = $this->getSettings(); // <--- Bổ sung
        
        $id = (int)($_GET['id'] ?? 0);
        $product = $this->laptopModel->findById($id);
        $brands = $this->getBrands();
        $error = '';

        if (!$product) {
            echo "Sản phẩm không tồn tại."; return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $data['image'] = $product['image']; 
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $targetDir = "images/products_img/";
                $fileExtension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                $newFileName = uniqid() . '.' . $fileExtension;
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetDir . $newFileName)) {
                    $data['image'] = $newFileName;
                }
            }

            if ($this->laptopModel->update($id, $data)) {
                header('Location: index.php?page=admin_products');
                exit;
            } else {
                $error = "Có lỗi xảy ra khi cập nhật.";
            }
        }

        $useTabler = true;
        require_once __DIR__ . '/../views/admin/products/edit.php';
    }

    public function delete()
    {
        $id = (int)($_GET['id'] ?? 0);
        $this->laptopModel->delete($id);
        header('Location: index.php?page=admin_products');
        exit;
    }
}