<?php
header('Content-Type: application/json; charset=UTF-8');
session_start();
require_once '../../app/core/Database.php';
require_once '../../app/models/User.php';

$db = (new Database())->getConnection();
$userModel = new User($db);

$login = trim($_POST['login'] ?? ''); // có thể là username hoặc email
$password = trim($_POST['password'] ?? '');

if (!$login || !$password) {
  echo json_encode(['status'=>'error','message'=>'Thiếu thông tin đăng nhập']);
  exit;
}

// tìm theo username hoặc email
$user = $userModel->findByUsernameOrEmail($login);

if (!$user) {
  echo json_encode(['status'=>'error','message'=>'Tài khoản không tồn tại']);
  exit;
}

if (!password_verify($password, $user['password'])) {
  echo json_encode(['status'=>'error','message'=>'Sai mật khẩu']);
  exit;
}

$_SESSION['user'] = [
  'id' => $user['id'],
  'username' => $user['username'],
  'fullname' => $user['fullname'],
  'role' => $user['role']
];
echo json_encode(['status'=>'ok']);
