<?php

class AdminController {

    public function index() {

        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: /laptop_store/public/index.php?page=home");
            exit;
        }

        include "../app/views/layouts/header.php";
        include "../app/views/admin/dashboard.php";
        include "../app/views/layouts/footer.php";
    }
}
