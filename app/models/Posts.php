<?php
require_once "../app/core/Database.php";

class Posts {

    private $db;

    public function __construct($db) {
        // Gọi hàm getConnection() từ lớp cha (Database) để khởi tạo và gán kết nối
        $this->db = $db; 
    }
    
    // Lấy bài viết theo phân trang + tìm kiếm
    public function getPosts($limit, $offset, $keyword = "") {
        $keyword = "%$keyword%";

        $sql = "SELECT * FROM posts 
                WHERE title LIKE ? OR description LIKE ? 
                ORDER BY created_at DESC 
                LIMIT ? OFFSET ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssii", $keyword, $keyword, $limit, $offset);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Đếm tổng số bài viết
    public function countPosts($keyword = "") {
        $keyword = "%$keyword%";

        $sql = "SELECT COUNT(*) as total FROM posts 
                WHERE title LIKE ? OR description LIKE ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $keyword, $keyword);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc()['total'];
    }
}

?>