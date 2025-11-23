<?php
require_once "../app/core/Auth.php";
require_once "../app/core/Database.php";
require_once "../app/models/Setting.php";
require_once "../app/models/FAQ.php";
require_once "../app/models/Creator.php";

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

        include "../app/views/layouts/header.php";
        include "../app/views/admin/dashboard.php";
        include "../app/views/layouts/footer.php";
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

        include "../app/views/layouts/header.php";
        include "../app/views/admin/contacts.php";
        include "../app/views/layouts/footer.php";
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

    public function settings()
    {
        Auth::requireAdmin();
        $db = (new Database())->getConnection();

       
        $query = $db->query("SELECT * FROM settings LIMIT 1");
        $settings = $query->fetch_assoc(); 



        include "../app/views/layouts/header.php";
        include "../app/views/admin/settings.php";
        include "../app/views/layouts/footer.php";
    }

    public function saveSettings()
    {
        Auth::requireAdmin();
        $setting = new Setting($this->db);

        foreach ($_POST as $key => $val) {
            $setting->update($key, $val);
        }

        header("Location: /laptop_store/public/index.php?page=admin_settings");
    }

    public function about()
    {
        Auth::requireAdmin();
        $settingModel = new Setting($this->db);
        $settings     = $settingModel->all();
        $creatorModel = new Creator($this->db);
        $creators     = $creatorModel->all();

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

    public function faqs()
    {
        Auth::requireAdmin();
        $faqModel = new FAQ($this->db);
        $faqs     = $faqModel->all();

        $result = $this->db->query("SHOW COLUMNS FROM faqs WHERE Field = 'type'");
        $col    = $result->fetch_assoc();
        preg_match('/enum\((.*)\)/', $col['Type'], $m);
        $types = isset($m[1]) ? array_map(fn($v) => trim($v, "'"), explode(',', $m[1])) : [];

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
        libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        $doc->loadHTML('<?xml encoding="utf-8" ?>' . $htmlFragment, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        foreach (['ul', 'ol'] as $tag) {
            $nodes = $doc->getElementsByTagName($tag);
            for ($i = 0; $i < $nodes->length; $i++) {
                $n = $nodes->item($i);
                $existing = $n->getAttribute('class');
                $classes = array_filter(array_map('trim', explode(' ', $existing)));
                if (!in_array('list-group', $classes)) $classes[] = 'list-group';
                if (!in_array('list-group-flush', $classes)) $classes[] = 'list-group-flush';
                $n->setAttribute('class', implode(' ', $classes));
            }
        }

        $lis = $doc->getElementsByTagName('li');
        for ($i = 0; $i < $lis->length; $i++) {
            $li = $lis->item($i);
            $existing = $li->getAttribute('class');
            $classes = array_filter(array_map('trim', explode(' ', $existing)));
            if (!in_array('list-group-item', $classes)) $classes[] = 'list-group-item';
            $li->setAttribute('class', implode(' ', $classes));
        }

        $body = $doc->getElementsByTagName('body')->item(0);
        $out = '';
        foreach ($body->childNodes as $child) {
            $out .= $doc->saveHTML($child);
        }
        return $out;
    }
}
