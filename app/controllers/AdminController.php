<?php
require_once "../app/core/Auth.php";
require_once "../app/core/Database.php";
require_once "../app/models/Setting.php";
require_once "../app/models/FAQ.php";
require_once "../app/models/Creator.php";
require_once "../app/models/Posts.php";
require_once "../app/models/Comments.php";
require_once "../app/models/User.php";

class AdminController
{
    private $db;
    public function __construct()
    {
        // KHỞI TẠO KẾT NỐI DATABASE
        $this->db = (new Database())->getConnection();
    }

    public function index()
    {

        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: /laptop_store/public/index.php?page=home");
            exit;
        }
        $pageCss = "adminDashboard";
        include "../app/views/layouts/header.php";
        include "../app/views/admin/dashboard.php";
    }
    public function contacts()
    {
        Auth::requireAdmin();
        $db = (new Database())->getConnection();


        $limit = 10;

        $page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        if ($page < 1) $page = 1;

        $offset = ($page - 1) * $limit;

        $stmt = $db->prepare("SELECT * FROM contacts ORDER BY created_at DESC LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $contacts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $total = $db->query("SELECT COUNT(*) AS total FROM contacts")->fetch_assoc()['total'];

        $totalPages = ceil($total / $limit);
        $pageCss = "contactAdmin";
        include "../app/views/layouts/header.php";
        include "../app/views/admin/contacts.php";
    }

    public function markContact()
    {
        Auth::requireAdmin();
        $id = $_GET['id'];
        $status = $_GET['status'];

        $stmt = $this->db->prepare("UPDATE contacts SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();

        header("Location: /laptop_store/public/index.php?page=admin_contacts");
        exit;
    }
    public function deleteContact()
    {
        Auth::requireAdmin();
        $id = $_GET['id'];

        $stmt = $this->db->prepare("DELETE FROM contacts WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        header("Location: /laptop_store/public/index.php?page=admin_contacts");
        exit;
    }
    public function markContactAjax()
    {
        Auth::requireAdmin();

        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'];
        $status = $data['status'];

        $stmt = $this->db->prepare("UPDATE contacts SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();

        echo json_encode(["success" => true]);
        exit;
    }

    public function deleteContactAjax()
    {
        Auth::requireAdmin();

        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'];

        $stmt = $this->db->prepare("DELETE FROM contacts WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        echo json_encode(["success" => true]);
        exit;
    }

    public function settings()
    {
        Auth::requireAdmin();
        $db = (new Database())->getConnection();
        $settingModel = new Setting($db);
        $settings = $settingModel->all();



        include "../app/views/layouts/header.php";
        include "../app/views/admin/settings.php";
    }

    public function saveSettings()
    {
        Auth::requireAdmin();
        $setting = new Setting($this->db);

        // Save normal text settings
        foreach ($_POST as $key => $val) {
            $setting->update($key, $val);
        }

        // Handle banner image upload
        if (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] === UPLOAD_ERR_OK) {

            $target = __DIR__ . '/../../public/images/banner.jpg';


            move_uploaded_file($_FILES['banner_image']['tmp_name'], $target);
        }

        header("Location: /laptop_store/public/index.php?page=admin_settings");
        exit;
    }

    public function user()
    {
        Auth::requireAdmin();
        $userModel = new User($this->db);
        
        $currentUserId = $_SESSION['user']['id'] ?? 0;  
        // Xử lý Hành động (Khóa, Mở khóa, Reset Mật khẩu, Phân quyền)
        if (isset($_GET['action']) && isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $success = false;
            $action = $_GET['action'];
            $message = "Thao tác thất bại.";

            switch ($action) {
                case 'lock':
                    $success = $userModel->updateStatus($id, 0); // 0: Khóa
                    $message = $success ? "Đã khóa người dùng thành công." : $message;
                    break;
                case 'unlock':
                    $success = $userModel->updateStatus($id, 1); // 1: Mở
                    $message = $success ? "Đã mở khóa người dùng thành công." : $message;
                    break;
                case 'reset_password':
                    $newPassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6); // Tạo mật khẩu 6 ký tự
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $success = $userModel->resetPassword($id, $hashedPassword);
                    
                    if ($success) {
                        // Cần hiển thị mật khẩu mới cho Admin (trong môi trường thực tế nên gửi qua email)
                        $message = "Đã Reset mật khẩu thành công! Mật khẩu mới: **{$newPassword}** (Hãy thông báo cho người dùng).";
                    }
                    break;
                case 'set_admin':
                case 'set_customer':
                    $newRole = ($action === 'set_admin') ? 'admin' : 'customer';
                    $success = $userModel->updateRole($id, $newRole);
                    $message = $success ? "Đã cập nhật vai trò thành {$newRole}." : $message;
                    break;
            }

            if ($success) {
                $_SESSION['admin_message'] = $message;
            }
            
            header("Location: /laptop_store/public/index.php?page=admin_manage"); 
            exit();
        }
        
        // Load Dữ liệu và View
        $pageTitle = "Quản lý Người dùng";
        $useTabler = true;    
        $users = $userModel->getAllUsers($currentUserId);
        
        include "../app/views/layouts/header.php";
        include "../app/views/admin/users.php";
    }

    public function about()
    {
        Auth::requireAdmin();
        $settingModel = new Setting($this->db);
        $settings     = $settingModel->all();
        $creatorModel = new Creator($this->db);
        $creators     = $creatorModel->all();

        $useTabler = true;
        $pageCss = "about";
        include "../app/views/layouts/header.php";
        include "../app/views/admin/about.php";
        include "../app/views/layouts/footer.php";
    }

    public function updateAbout()
    {
        Auth::requireAdmin();
        $settingModel = new Setting($this->db);

        if (isset($_POST['about_title'])) {
            $settingModel->update('about_title', $_POST['about_title']);
        }

        if (isset($_POST['about_subtitle'])) {
            $settingModel->update('about_subtitle', $_POST['about_subtitle']);
        }

        if (isset($_POST['about_mission'])) {
            $settingModel->update('about_mission', $_POST['about_mission']);
        }

        if (isset($_POST['about_values'])) {
            $raw = $_POST['about_values'];
            $processed = normalizeListGroupHtml_helper($raw);
            $settingModel->update('about_values', $processed);
        }

        if (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir  = __DIR__ . '/../../public/images/';
            $targetPath = $uploadDir . 'about_banner.jpg';
            move_uploaded_file($_FILES['banner_image']['tmp_name'], $targetPath);
        }

        if (isset($_POST['creator_id'])) {
            $creatorModel = new Creator($this->db);
            $id           = (int) $_POST['creator_id'];
            $name         = $_POST['name'] ?? '';
            $role         = $_POST['role'] ?? '';
            $bio          = $_POST['bio'] ?? '';

            $creatorModel->update($id, $name, $role, $bio);

            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir  = __DIR__ . '/../../public/images/';
                $staticName = 'creator' . $id . '.jpg';
                $targetPath = $uploadDir . $staticName;
                move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetPath);
            }
        }

        header("Location: /laptop_store/public/index.php?page=admin_about");
        exit;
    }

    public function news(){
        Auth::requireAdmin();
        $postModel = new Posts($this->db);
        $commentModel = new Comments($this->db);

        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
            $id = (int)$_GET['id'];

            $commentModel->deleteCommentsByPostId($id);
            if ($postModel->deletePost($id)) {
                $_SESSION['admin_message'] = "Đã xóa bài viết thành công!";
            } else {
                $_SESSION['admin_message'] = "Lỗi: Không thể xóa bài viết.";
            }
            header("Location: /laptop_store/public/index.php?page=admin_news");
            exit();
        }

        $limit = 5;

        $page = isset($_GET['count']) ? (int)$_GET['count'] : 1;
        if ($page < 1) $page = 1;

        $offset = ($page - 1) * $limit;

        $posts = $postModel->getPosts($limit, $offset);

        $total = $postModel->countPosts();

        $totalPages = ceil($total / $limit);

        $pageTitle = "Quản Lý Bài Viết";
        $useTabler = true;
        include "../app/views/layouts/header.php";
        include "../app/views/admin/news/lists.php";
    }

    public function newsDetail(){
        Auth::requireAdmin();
        $postModel = new Posts($this->db);
        $commentModel = new Comments($this->db);

        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $post = null;
        $postErrors = [];
        $comments = [];

        if ($id && isset($_GET['comment_action']) && isset($_GET['comment_id'])) {
            $commentId = (int)$_GET['comment_id'];
            $success = false;

            if ($_GET['comment_action'] === 'remove') {
                $success = $commentModel->setCommentStatus($commentId, 0); // 0: Gỡ
                $message = "Đã gỡ bình luận thành công.";
            } elseif ($_GET['comment_action'] === 'approve') {
                $success = $commentModel->setCommentStatus($commentId, 1); // 1: Phục hồi
                $message = "Đã phục hồi bình luận thành công.";
            }
            
            if ($success) {
                $_SESSION['admin_message'] = $message;
            } else {
                $_SESSION['admin_message'] = "Thao tác bình luận thất bại.";
            }
            // Chuyển hướng về chính form sửa bài viết để cập nhật danh sách bình luận
            header("Location: /laptop_store/public/index.php?page=admin_news_detail&id=" . $id . "#comment-list"); 
            exit();
        }
        
        if ($id) {
            $post = $postModel->getPostById($id);
            $pageTitle = "Sửa Bài viết: " . ($post['title'] ?? '');
            if (!$post) {
                header("Location: /laptop_store/public/index.php?page=admin_news"); exit();
            }
        } else {
            $pageTitle = "Thêm Bài viết Mới";
        }
        
        // --- Xử lý POST Form ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Lấy dữ liệu
            $data = [
                'title' => trim($_POST['title'] ?? ''),
                'slug' => trim($_POST['slug'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'content' => $_POST['content'] ?? '',
                'keywords' => trim($_POST['keywords'] ?? ''),
                // Thumbnail sẽ được xử lý riêng
                'thumbnail' => $post['thumbnail'] ?? null // Giữ lại ảnh cũ nếu không upload ảnh mới
            ];

            // 2. Validation (PHP thuần)
            if (empty($data['title'])) $postErrors[] = "Tiêu đề không được để trống.";
            if (empty($data['slug'])) $postErrors[] = "Slug không được để trống.";

            // 3. Xử lý Upload Hình ảnh
            if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../public/images/posts_img/'; // Đảm bảo thư mục này tồn tại
                $fileName = time() . '_' . basename($_FILES['thumbnail']['name']);
                $targetFile = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $targetFile)) {
                    $data['thumbnail'] = $fileName;
                    // Xóa ảnh cũ nếu đang sửa và có ảnh cũ
                    if ($id && $post['thumbnail'] && file_exists($uploadDir . $post['thumbnail'])) {
                        unlink($uploadDir . $post['thumbnail']);
                    }
                } else {
                    $postErrors[] = "Lỗi khi upload ảnh đại diện.";
                }
            } else if (!$id && empty($data['thumbnail'])) {
                 $postErrors[] = "Ảnh đại diện là bắt buộc khi thêm mới.";
            }

            // 4. Thực thi CRUD
            if (empty($postErrors)) {
                $result = $id ? $postModel->updatePost($id, $data) : $postModel->createPost($data);

                if ($result) {
                    $_SESSION['admin_message'] = $id ? "Cập nhật bài viết thành công!" : "Thêm bài viết mới thành công!";
                    header("Location: /laptop_store/public/index.php?page=admin_news");
                    exit();
                } else {
                    $postErrors[] = "Lỗi Database: Không thể thực hiện thao tác.";
                }
            }
        }

        if ($id) {
            $comments = $commentModel->getAllCommentsByPostId($id);
        }

        $pageTitle = $id ? "Sửa Bài viết: " . ($post['title'] ?? '') : "Thêm Bài viết Mới";
        $useTabler = true;
        include "../app/views/layouts/header.php";
        include "../app/views/admin/news/detail.php";
    }

    public function faqs()
    {
        Auth::requireAdmin();
        $faqModel = new FAQ($this->db);
        $faqs     = $faqModel->all();
        $settings = (new Setting($this->db))->all();

        $result = $this->db->query("SHOW COLUMNS FROM faqs WHERE Field = 'type'");
        $col    = $result->fetch_assoc();
        preg_match('/enum\((.*)\)/', $col['Type'], $m);
        $types = isset($m[1]) ? array_map(fn($v) => trim($v, "'"), explode(',', $m[1])) : [];

        $useTabler = true;
        $pageCss = "faq";
        include "../app/views/layouts/header.php";
        include "../app/views/admin/faqs.php";
        include "../app/views/layouts/footer.php";
    }

    public function addFaq()
    {
        Auth::requireAdmin();
        $question = $_POST['question'] ?? '';
        $answer   = $_POST['answer'] ?? '';
        $type     = $_POST['type'] ?? '';

        $faqModel = new FAQ($this->db);
        $faqModel->create($question, $answer, $type);

        header("Location: /laptop_store/public/index.php?page=admin_faqs");
        exit;
    }

    public function deleteFaq()
    {
        Auth::requireAdmin();
        if (!isset($_GET['id'])) {
            header("Location: /laptop_store/public/index.php?page=admin_faqs");
            exit;
        }

        $id       = (int) $_GET['id'];
        $faqModel = new FAQ($this->db);
        $faqModel->delete($id);

        header("Location: /laptop_store/public/index.php?page=admin_faqs");
        exit;
    }

    public function updateFaq()
    {
        Auth::requireAdmin();
        $id       = (int) ($_POST['id'] ?? 0);
        $question = $_POST['question'] ?? '';
        $answer   = $_POST['answer'] ?? '';
        $type     = $_POST['type'] ?? '';

        $faqModel = new FAQ($this->db);
        $faqModel->update($id, $question, $answer, $type);

        header("Location: /laptop_store/public/index.php?page=admin_faqs");
        exit;
    }

    public function addFaqType()
    {
        Auth::requireAdmin();
        $type_name = $_POST['type_name'] ?? '';

        if ($type_name === '') {
            header("Location: /laptop_store/public/index.php?page=admin_faqs");
            exit;
        }

        $res = $this->db->query("SHOW COLUMNS FROM faqs WHERE Field = 'type'");
        $col = $res->fetch_assoc();
        preg_match('/enum\((.*)\)/', $col['Type'], $m);
        $existing = isset($m[1]) ? array_map(fn($v) => trim($v, "'"), explode(',', $m[1])) : [];

        if (!in_array($type_name, $existing)) {
            $existing[] = $type_name;
            $enum       = "ENUM('" . implode("','", $existing) . "')";
            $this->db->query("ALTER TABLE faqs MODIFY COLUMN type $enum");
        }

        header("Location: /laptop_store/public/index.php?page=admin_faqs");
        exit;
    }
}

if (!function_exists('normalizeListGroupHtml_helper')) {
    function normalizeListGroupHtml_helper($htmlFragment)
    {
        if (empty($htmlFragment)) return $htmlFragment;
        libxml_use_internal_errors(true);
        $doc = new DOMDocument('1.0', 'UTF-8');
        $loaded = $doc->loadHTML('<?xml encoding="UTF-8"?><div>' . $htmlFragment . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        if (!$loaded) return $htmlFragment;
        $doc->encoding = 'UTF-8';

        foreach (['ul', 'ol'] as $tag) {
            $nodes = $doc->getElementsByTagName($tag);
            for ($i = $nodes->length - 1; $i >= 0; $i--) {
                $n = $nodes->item($i);
                $existing = $n->getAttribute('class');
                $classes = array_filter(array_map('trim', explode(' ', $existing)));
                if (!in_array('list-group', $classes)) $classes[] = 'list-group';
                if (!in_array('list-group-flush', $classes)) $classes[] = 'list-group-flush';
                $n->setAttribute('class', implode(' ', $classes));
            }
        }

        $lis = $doc->getElementsByTagName('li');
        for ($i = $lis->length - 1; $i >= 0; $i--) {
            $li = $lis->item($i);
            $existing = $li->getAttribute('class');
            $classes = array_filter(array_map('trim', explode(' ', $existing)));
            if (!in_array('list-group-item', $classes)) $classes[] = 'list-group-item';
            $li->setAttribute('class', implode(' ', $classes));
        }

        $div = $doc->getElementsByTagName('div')->item(0);
        if ($div) {
            $out = '';
            foreach ($div->childNodes as $child) {
                $out .= $doc->saveHTML($child);
            }
            return $out;
        }
        return $htmlFragment;
    }
}
