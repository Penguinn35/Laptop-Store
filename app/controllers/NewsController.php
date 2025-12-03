<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class NewsController {

    public function index() {
        require_once "../app/core/Database.php";
        require_once "../app/models/Setting.php";
        require_once "../app/models/Posts.php";

        $db = (new Database())->getConnection();
        $settingModel = new Setting($db);
        $postModel = new Posts($db);
        $settings = $settingModel->all();

        // Số lượng bài viết mỗi trang
        $limit = 5;

        // Lấy trang hiện tại
        $page = isset($_GET['count']) ? (int)$_GET['count'] : 1;
        $page = max($page, 1); // tránh page < 1

        // Lấy keyword tìm kiếm
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : "";

        // Tính offset
        $offset = ($page - 1) * $limit;

        // Lấy dữ liệu từ model
        $posts = $postModel->getPosts($limit, $offset, $keyword);
        $totalPosts = $postModel->countPosts($keyword);

        // Tính tổng số trang
        $totalPages = ceil($totalPosts / $limit);

        // Gửi sang view
        $pageCss = "newsList";
        include "../app/views/layouts/header.php";
        include "../app/views/news/news_list.php";
        include "../app/views/layouts/footer.php";
    }

    public function detail() {
        require_once "../app/core/Database.php";
        require_once "../app/models/Setting.php";
        require_once "../app/models/Posts.php";
        require_once "../app/models/Comments.php";

        $db = (new Database())->getConnection();
        $settingModel = new Setting($db);
        $postModel = new Posts($db);
        $commentModel = new Comments($db);
        $settings = $settingModel->all();

        // 1. Lấy slug từ URL
        $slug = isset($_GET['slug']) ? $_GET['slug'] : null;

        if (!$slug) {
            die("Lỗi: Không tìm thấy định danh bài viết.");
        }

        // 2. Gọi Model để lấy dữ liệu
        $post = $postModel->getPostBySlug($slug);

        if (!$post) {
             die("Lỗi: Bài viết không tồn tại.");
        }

        $userId = $_SESSION['user']['id'] ?? null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment']) && $userId) {
            $content = trim($_POST['comment_content']);
            $postId = $post['id'];
            
            // 1. Kiểm tra dữ liệu đầu vào (Validation - Server Side)
            if ($userId && !empty($content) && strlen($content) <= 500) {
                
                if ($commentModel->addComment($userId, $postId, $content)) {
                    // Thành công: Chuyển hướng để tránh gửi lại form
                    header("Location: ?page=news_detail&slug=" . $slug . "#comments");
                    exit();
                } else {
                    $commentError = "Đã xảy ra lỗi khi thêm bình luận.";
                }
            } else {
                $commentError = "Vui lòng nhập nội dung bình luận (tối đa 500 ký tự).";
            }
        }
        
        // --- Lấy Danh sách Bình Luận ---
        $postId = $post['id'];
        $comments = $commentModel->getAllCommentsForClient($postId);

        // 3. Tăng lượt xem (Tùy chọn)
        // $postModel->incrementViewCount($post['id']); 

         // Gửi sang view
        $pageCss = "newsDetail";
        $pageJs = "news";
        include "../app/views/layouts/header.php";
        include "../app/views/news/news_detail.php";
        include "../app/views/layouts/footer.php";
    }
}

?>