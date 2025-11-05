<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function loginAjax($username, $password) {
        $user = $this->userModel->findByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'fullname' => $user['fullname'],
                'role' => $user['role']
            ];
            return ['status' => 'ok'];
        }
        return ['status' => 'error', 'message' => 'Sai tài khoản hoặc mật khẩu'];
    }

    public function registerAjax($username, $password, $fullname, $email = '', $phone = '', $address = '') {
        if ($this->userModel->findByUsername($username)) {
            return ['status' => 'error', 'message' => 'Tên đăng nhập đã tồn tại'];
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $this->userModel->create($username, $hashedPassword, $fullname, $email, $phone, $address);

        return ['status' => 'ok', 'message' => 'Đăng ký thành công'];
    }
}
