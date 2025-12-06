<?php
require_once "../app/core/Database.php";

class Comments {

    private $db;

    public function __construct($db) {
        // Gọi hàm getConnection() từ lớp cha (Database) để khởi tạo và gán kết nối
        $this->db = $db; 
    }
    
    public function getAllCommentsForClient($postId) {
        $sql = "SELECT c.*, u.fullname   
                FROM comments c
                JOIN users u ON c.user_id = u.id
                WHERE c.new_id = ? 
                ORDER BY c.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $postId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllCommentsByPostId($postId) {
    // Sửa lại truy vấn để KHÔNG lọc status, lấy hết bình luận cho Admin
        $sql = "SELECT c.*, u.fullname, p.slug as post_slug
                FROM comments c
                JOIN users u ON c.user_id = u.id
                JOIN posts p ON c.new_id = p.id
                WHERE c.new_id = ?
                ORDER BY c.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $postId);
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

    public function setCommentStatus($commentId, $status) {
        $sql = "UPDATE comments SET status = ? WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $status, $commentId);
        
        return $stmt->execute();
    }

    public function deleteCommentsByPostId($postId) {
        // new_id là cột trỏ đến post
        $sql = "DELETE FROM comments WHERE new_id = ?"; 
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $postId);
        
        // Trả về true nếu thành công, kể cả khi không có bình luận nào để xóa
        return $stmt->execute(); 
    }
}

?>