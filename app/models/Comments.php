<?php
require_once "../app/core/Database.php";

class Comments {

    private $db;

    public function __construct($db) {
        // Gọi hàm getConnection() từ lớp cha (Database) để khởi tạo và gán kết nối
        $this->db = $db; 
    }
    
    public function getCommentsByPostId($postId) {
        $sql = "SELECT c.*, u.fullname   
                FROM comments c
                JOIN users u ON c.user_id = u.id
                WHERE c.new_id = ? AND c.status = ?
                ORDER BY c.created_at DESC";

        $initial_status = 1;
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $postId, $initial_status);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function addComment($userId, $postId, $content) {
        $sql = "INSERT INTO comments (user_id, new_id, content, status) 
                VALUES (?, ?, ?, 1)"; 

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iis", $userId, $postId, $content);
        
        return $stmt->execute();
    }
}

?>