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
        $settings = $this->getSettings();
        $brands   = $this->getBrands();
        $error    = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Thư mục lưu ảnh: /public/images/products_img/
            $uploadDir = __DIR__ . '/../../public/images/products_img/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Mặc định nếu không upload thì dùng no-image.jpg (hoặc để null tùy bạn)
            $imageName = 'no-image.jpg';

            if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $ext  = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

                // Tạo tên file "đẹp" + unique
                $slug = preg_replace('/[^a-z0-9]+/i', '-', strtolower($_POST['name'] ?? 'laptop'));
                $imageName = $slug . '-' . time() . '.' . $ext;

                move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);
            }

            $data = [
                'brand_id'    => $_POST['brand_id'] ?? null,
                'name'        => $_POST['name'] ?? '',
                'description' => $_POST['description'] ?? '',
                'cpu'         => $_POST['cpu'] ?? '',
                'ram'         => $_POST['ram'] ?? '',
                'storage'     => $_POST['storage'] ?? '',
                'gpu'         => $_POST['gpu'] ?? '',
                'screen'      => $_POST['screen'] ?? '',
                'price'       => $_POST['price'] ?? 0,
                'stock'       => $_POST['stock'] ?? 0,
                'image'       => $imageName,
            ];

            if ($this->laptopModel->create($data)) {
                header('Location: index.php?page=admin_products');
                exit;
            } else {
                $error = "Có lỗi xảy ra khi thêm sản phẩm.";
            }
        }

        // GET: chỉ hiển thị form
        $useTabler = true;
        require_once __DIR__ . '/../views/admin/products/create.php';
    }

public function edit()
    {
        $settings = $this->getSettings();
        $brands   = $this->getBrands();
        $error    = '';

        $id = (int)($_GET['id'] ?? 0);
        $product = $this->laptopModel->findById($id);

        if (!$product) {
            echo "Sản phẩm không tồn tại."; return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Đường dẫn thư mục ảnh
            $uploadDir = __DIR__ . '/../../public/images/products_img/';
            
            // 1. Mặc định lấy tên ảnh CŨ trong database
            $imageName = $product['image']; 

            // 2. Kiểm tra nếu người dùng CÓ chọn file mới
            if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                
                // Lấy đuôi file
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                
                // Đặt tên ngẫu nhiên: 65a1b...jpg
                $newFileName = uniqid() . '.' . $ext;

                // Upload file mới
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $newFileName)) {
                    
                    // XÓA ẢNH CŨ (Trừ khi nó là no-image.jpg) để dọn rác
                    $oldImage = $product['image'];
                    if (!empty($oldImage) && $oldImage !== 'no-image.jpg') {
                        $oldPath = $uploadDir . $oldImage;
                        if (file_exists($oldPath)) {
                            unlink($oldPath); // Xóa file cũ đi
                        }
                    }

                    // Gán tên ảnh MỚI để chuẩn bị lưu vào DB
                    $imageName = $newFileName;
                }
            }

            // 3. Chuẩn bị dữ liệu update
            $data = [
                'brand_id'    => $_POST['brand_id'] ?? $product['brand_id'],
                'name'        => $_POST['name'] ?? $product['name'],
                'description' => $_POST['description'] ?? $product['description'],
                'cpu'         => $_POST['cpu'] ?? $product['cpu'],
                'ram'         => $_POST['ram'] ?? $product['ram'],
                'storage'     => $_POST['storage'] ?? $product['storage'],
                'gpu'         => $_POST['gpu'] ?? $product['gpu'],
                'screen'      => $_POST['screen'] ?? $product['screen'],
                'price'       => $_POST['price'] ?? $product['price'],
                'stock'       => $_POST['stock'] ?? $product['stock'],
                'image'       => $imageName, 
            ];

            // 4. Gọi Model để lưu
            if ($this->laptopModel->update($id, $data)) {
                header('Location: index.php?page=admin_products');
                exit;
            } else {
                $error = "Có lỗi xảy ra khi cập nhật vào Database.";
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