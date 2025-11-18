<?php
header('Content-Type: application/json; charset=UTF-8');
session_start();
require_once __DIR__ . '/../../../app/core/Database.php';
require_once __DIR__ . '/../../../app/models/User.php';

$db = (new Database())->getConnection();
$userModel = new User($db);

$username = trim($_POST['username'] ?? '');
$fullname = trim($_POST['fullname'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$address = trim($_POST['address'] ?? '');

if (!$username || !$email || !$password) {
    echo json_encode(['status' => 'error', 'message' => 'Thiếu thông tin cần thiết']);
    exit;
}

if ($userModel->findByUsername($username)) {
    echo json_encode(['status' => 'error', 'message' => 'Tên đăng nhập đã tồn tại']);
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
$userModel->create($username, $hashedPassword, $fullname, $email, $phone, $address);

echo json_encode(['status' => 'ok', 'message' => 'Đăng ký thành công']);
