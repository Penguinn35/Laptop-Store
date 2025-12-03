<?php
// app/models/Laptop.php

require_once __DIR__ . '/../core/Database.php';

class Laptop
{
    private $conn;

    public function __construct()
    {
        // Khởi tạo kết nối mysqli từ Database.php
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    /**
     * Hàm cũ của nhóm trưởng – dùng được luôn với mysqli
     * Ví dụ:
     *   $db = new Database();
     *   $conn = $db->getConnection();
     *   $list = Laptop::all($conn);
     */
    public static function all($conn)
    {
        $sql = "SELECT l.*, b.name AS brand_name
                FROM laptops l
                LEFT JOIN brands b ON l.brand_id = b.id";
        $result = $conn->query($sql);

        $rows = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            $result->free();
        }
        return $rows;
    }

    /**
     * Lấy danh sách laptop cho trang public (có tìm kiếm + phân trang).
     */
    public function getAll($keyword = '', $limit = 12, $offset = 0)
    {
        // Base SQL
        $sql = "SELECT l.*, b.name AS brand_name
                FROM laptops l
                LEFT JOIN brands b ON l.brand_id = b.id
                WHERE 1 = 1";

        $params = [];
        $types  = '';

        if ($keyword !== '') {
            $sql .= " AND (l.name LIKE ? OR b.name LIKE ?)";
            $like   = '%' . $keyword . '%';
            $params[] = $like;
            $params[] = $like;
            $types   .= 'ss';
        }

        $sql .= " ORDER BY l.created_at DESC
                  LIMIT ? OFFSET ?";

        $params[] = (int)$limit;
        $params[] = (int)$offset;
        $types   .= 'ii';

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Query error: " . $this->conn->error);
        }

        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

        $rows = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            $result->free();
        }

        $stmt->close();
        return $rows;
    }

    /**
     * Đếm tổng số laptop (phục vụ phân trang trang public/admin).
     */
    public function countAll($keyword = '')
    {
        $sql = "SELECT COUNT(*) AS total
                FROM laptops l
                LEFT JOIN brands b ON l.brand_id = b.id
                WHERE 1 = 1";

        $params = [];
        $types  = '';

        if ($keyword !== '') {
            $sql .= " AND (l.name LIKE ? OR b.name LIKE ?)";
            $like   = '%' . $keyword . '%';
            $params[] = $like;
            $params[] = $like;
            $types   .= 'ss';
        }

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Query error: " . $this->conn->error);
        }

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $total  = 0;

        if ($result) {
            $row = $result->fetch_assoc();
            $total = (int)$row['total'];
            $result->free();
        }

        $stmt->close();
        return $total;
    }

    /**
     * Tìm 1 laptop theo id (dùng cho trang chi tiết).
     */
    public function findById($id)
    {
        $sql = "SELECT l.*, b.name AS brand_name
                FROM laptops l
                LEFT JOIN brands b ON l.brand_id = b.id
                WHERE l.id = ?";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Query error: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $laptop = $result ? $result->fetch_assoc() : null;

        if ($result) $result->free();
        $stmt->close();

        return $laptop;
    }

    /**
     * Lấy danh sách cho admin (giống getAll nhưng có thể dùng limit lớn hơn).
     */
    public function getAllAdmin($keyword = '', $limit = 20, $offset = 0)
    {
        return $this->getAll($keyword, $limit, $offset);
    }

    /**
     * Thêm laptop mới (dùng trong Admin).
     * $data là mảng:
     * [
     *   'brand_id' => int,
     *   'name' => string,
     *   'description' => string,
     *   'cpu' => string,
     *   'ram' => string,
     *   'storage' => string,
     *   'gpu' => string,
     *   'screen' => string,
     *   'price' => float,
     *   'image' => string,
     *   'stock' => int
     * ]
     */
    public function create($data)
    {
        // Gán mặc định nếu thiếu key
        $brand_id   = isset($data['brand_id'])   ? (int)$data['brand_id']   : null;
        $name       = $data['name']       ?? '';
        $description= $data['description']?? '';
        $cpu        = $data['cpu']        ?? '';
        $ram        = $data['ram']        ?? '';
        $storage    = $data['storage']    ?? '';
        $gpu        = $data['gpu']        ?? '';
        $screen     = $data['screen']     ?? '';
        $price      = isset($data['price']) ? (float)$data['price'] : 0;
        $image      = $data['image']      ?? '';
        $stock      = isset($data['stock']) ? (int)$data['stock'] : 0;

        $sql = "INSERT INTO laptops
                (brand_id, name, description, cpu, ram, storage, gpu, screen, price, image, stock)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Query error: " . $this->conn->error);
        }

        $stmt->bind_param(
            "isssssssdsi",
            $brand_id,
            $name,
            $description,
            $cpu,
            $ram,
            $storage,
            $gpu,
            $screen,
            $price,
            $image,
            $stock
        );

        $ok = $stmt->execute();
        if (!$ok) {
            // Bạn có thể log lỗi, phục vụ báo cáo "bảo mật" (không show cụ thể ra cho user)
            error_log("Create laptop error: " . $stmt->error);
        }

        $stmt->close();
        return $ok;
    }

    /**
     * Cập nhật laptop.
     */
    public function update($id, $data)
    {
        $brand_id   = isset($data['brand_id'])   ? (int)$data['brand_id']   : null;
        $name       = $data['name']       ?? '';
        $description= $data['description']?? '';
        $cpu        = $data['cpu']        ?? '';
        $ram        = $data['ram']        ?? '';
        $storage    = $data['storage']    ?? '';
        $gpu        = $data['gpu']        ?? '';
        $screen     = $data['screen']     ?? '';
        $price      = isset($data['price']) ? (float)$data['price'] : 0;
        $image      = $data['image']      ?? '';
        $stock      = isset($data['stock']) ? (int)$data['stock'] : 0;
        $id         = (int)$id;

        $sql = "UPDATE laptops
                SET brand_id = ?, name = ?, description = ?, cpu = ?, ram = ?, storage = ?,
                    gpu = ?, screen = ?, price = ?, image = ?, stock = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Query error: " . $this->conn->error);
        }

        $stmt->bind_param(
            "issssssdsiii",
            $brand_id,
            $name,
            $description,
            $cpu,
            $ram,
            $storage,
            $gpu,
            $screen,
            $price,
            $image,
            $stock,
            $id
        );

        $ok = $stmt->execute();
        if (!$ok) {
            error_log("Update laptop error: " . $stmt->error);
        }

        $stmt->close();
        return $ok;
    }

    /**
     * Xóa laptop theo id.
     */
    public function delete($id)
    {
        $sql = "DELETE FROM laptops WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Query error: " . $this->conn->error);
        }

        $id = (int)$id;
        $stmt->bind_param("i", $id);
        $ok = $stmt->execute();

        if (!$ok) {
            error_log("Delete laptop error: " . $stmt->error);
        }

        $stmt->close();
        return $ok;
    }
}
