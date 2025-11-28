<?php
header('Content-Type: application/json; charset=UTF-8');
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once __DIR__ . '/../../../app/core/Database.php';
require_once __DIR__ . '/../../../app/models/User.php';
$db = (new Database())->getConnection();
$userModel = new User($db);

$login = trim($_POST['login'] ?? ''); // có thể là username hoặc email
$password = trim($_POST['password'] ?? '');

if (!$login || !$password) {
  echo json_encode(['status' => 'error', 'message' => 'Thiếu thông tin đăng nhập']);
  exit;
}

// tìm theo username hoặc email
$user = $userModel->findByUsernameOrEmail($login);

if (!$user) {
  echo json_encode(['status' => 'error', 'message' => 'Tài khoản không tồn tại']);
  exit;
}

if (!password_verify($password, $user['password'])) {
  echo json_encode(['status' => 'error', 'message' => 'Sai mật khẩu']);
  exit;
}

// Store full user info into session for profile display
$_SESSION['user'] = [
  'id' => $user['id'],
  'username' => $user['username'],
  'fullname' => $user['fullname'] ?? '',
  'email' => $user['email'] ?? '',
  'phone' => $user['phone'] ?? '',
  'address' => $user['address'] ?? '',
  'role' => $user['role'] ?? '',
  'avatar' => $user['avatar'] ?? ''
];
if ($user['role'] === 'admin') {
  echo json_encode(['status' => 'admin']);
} else {
  echo json_encode(['status' => 'ok']);
}
