<?php
class AuthController {

    public function logout() {
        session_start();
        $_SESSION = [];
        session_destroy();
        header("Location: /laptop_store/public/index.php?page=home");
        exit;
    }
}
