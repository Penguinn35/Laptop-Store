<?php
require_once "../app/core/Auth.php";
require_once "../app/core/Database.php";
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
}
