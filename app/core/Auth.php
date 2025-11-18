<?php

class Auth {

    public static function requireLogin() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /laptop_store/public/index.php?page=home");
            exit;
        }
    }

    public static function requireAdmin() {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: /laptop_store/public/index.php?page=home");
            exit;
        }
    }
}
