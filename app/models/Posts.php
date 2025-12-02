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

    public function getPostBySlug($slug) {
        $sql = "SELECT * FROM posts 
                WHERE slug = ?"; 

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        
        // Sử dụng get_result() và fetch_assoc() để lấy 1 hàng duy nhất
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Phương thức tăng lượt xem bài viết
    // public function incrementViewCount($postId) {
    //     $sql = "UPDATE posts SET view_count = view_count + 1 WHERE id = ?";
    //     $stmt = $this->db->prepare($sql);
    //     $stmt->bind_param("i", $postId);
    //     $stmt->execute();
    // }
}

?>