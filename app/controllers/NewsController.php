<?php



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
        include "../app/views/layouts/header.php";
        include "../app/views/news_list.php";
        include "../app/views/layouts/footer.php";
    }
}

?>