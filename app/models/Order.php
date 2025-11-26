<?php
// app/models/Order.php

require_once __DIR__ . '/../core/Database.php';

class Order
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection(); // mysqli connection
    }

    /**
     * Tạo đơn hàng mới + lưu các dòng order_items.
     *
     * $orderData: [
     *   'user_id'      => int|null,
     *   'full_name'    => string,
     *   'email'        => string,
     *   'phone'        => string,
     *   'address'      => string,
     *   'note'         => string,
     *   'total_amount' => float,
     *   'status'       => string ('pending', 'confirmed', ...)
     * ]
     *
     * $items: [
     *   [
     *     'laptop_id'  => int,
     *     'quantity'   => int,
     *     'unit_price' => float
     *   ],
     *   ...
     * ]
     */
    public function createOrder($orderData, $items)
    {
        // Bắt đầu transaction
        $this->conn->begin_transaction();

        try {
            $sql = "INSERT INTO orders
                    (user_id, full_name, email, phone, address, note, total_amount, status)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Prepare order failed: " . $this->conn->error);
            }

            $user_id      = $orderData['user_id'];      // có thể NULL
            $full_name    = $orderData['full_name'];
            $email        = $orderData['email'];
            $phone        = $orderData['phone'];
            $address      = $orderData['address'];
            $note         = $orderData['note'];
            $total_amount = (float)$orderData['total_amount'];
            $status       = $orderData['status'] ?? 'pending';

            // i = int, s = string, d = double
            // user_id (i), full_name (s), email (s), phone (s), address (s), note (s), total_amount (d), status (s)
            $stmt->bind_param(
                "isssssds",
                $user_id,
                $full_name,
                $email,
                $phone,
                $address,
                $note,
                $total_amount,
                $status
            );

            if (!$stmt->execute()) {
                throw new Exception("Insert order failed: " . $stmt->error);
            }

            $orderId = $this->conn->insert_id;
            $stmt->close();

            // Insert order_items
            $sqlItem = "INSERT INTO order_items
                        (order_id, laptop_id, quantity, unit_price)
                        VALUES (?, ?, ?, ?)";

            $stmtItem = $this->conn->prepare($sqlItem);
            if (!$stmtItem) {
                throw new Exception("Prepare order_item failed: " . $this->conn->error);
            }

            foreach ($items as $item) {
                $laptop_id  = (int)$item['laptop_id'];
                $quantity   = (int)$item['quantity'];
                $unit_price = (float)$item['unit_price'];

                $stmtItem->bind_param("iiid", $orderId, $laptop_id, $quantity, $unit_price);

                if (!$stmtItem->execute()) {
                    throw new Exception("Insert order_item failed: " . $stmtItem->error);
                }
            }

            $stmtItem->close();

            // Commit transaction
            $this->conn->commit();
            return $orderId;

        } catch (Exception $e) {
            // Rollback nếu có lỗi
            $this->conn->rollback();
            error_log("createOrder error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Lấy danh sách đơn hàng cho Admin (có lọc trạng thái, phân trang).
     *
     * $status: '', 'pending', 'confirmed', ...
     */
    public function getAll($status = '', $limit = 20, $offset = 0)
    {
        $sql = "SELECT * FROM orders WHERE 1=1";
        $params = [];
        $types  = '';

        if ($status !== '') {
            $sql .= " AND status = ?";
            $params[] = $status;
            $types   .= 's';
        }

        $sql .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";

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

        $orders = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
            $result->free();
        }

        $stmt->close();
        return $orders;
    }

    /**
     * (Tùy chọn) Đếm tổng số đơn hàng – hỗ trợ phân trang.
     */
    public function countAll($status = '')
    {
        $sql = "SELECT COUNT(*) AS total FROM orders WHERE 1=1";
        $params = [];
        $types  = '';

        if ($status !== '') {
            $sql .= " AND status = ?";
            $params[] = $status;
            $types   .= 's';
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
     * Lấy chi tiết 1 đơn hàng + các dòng sản phẩm.
     */
    public function getById($id)
    {
        $id = (int)$id;

        $sql = "SELECT * FROM orders WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Query error: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = $result ? $result->fetch_assoc() : null;

        if ($result) $result->free();
        $stmt->close();

        if (!$order) {
            return null;
        }

        // Lấy danh sách sản phẩm trong đơn
        $sqlItems = "SELECT oi.*, l.name
                     FROM order_items oi
                     JOIN laptops l ON oi.laptop_id = l.id
                     WHERE oi.order_id = ?";

        $stmtItems = $this->conn->prepare($sqlItems);
        if (!$stmtItems) {
            die("Query error: " . $this->conn->error);
        }

        $stmtItems->bind_param("i", $id);
        $stmtItems->execute();
        $resultItems = $stmtItems->get_result();

        $items = [];
        if ($resultItems) {
            while ($row = $resultItems->fetch_assoc()) {
                $items[] = $row;
            }
            $resultItems->free();
        }

        $stmtItems->close();
        $order['items'] = $items;

        return $order;
    }

    /**
     * Cập nhật trạng thái đơn hàng.
     */
    public function updateStatus($id, $status)
    {
        $id = (int)$id;

        $sql = "UPDATE orders SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Query error: " . $this->conn->error);
        }

        $stmt->bind_param("si", $status, $id);
        $ok = $stmt->execute();

        if (!$ok) {
            error_log("updateStatus error: " . $stmt->error);
        }

        $stmt->close();
        return $ok;
    }
}
