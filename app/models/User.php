<?php
class User
{
  private $conn;
  public function __construct($db)
  {
    $this->conn = $db;
  }
public function findByUsernameOrEmail($login) {
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE username=? OR email=? LIMIT 1");
    $stmt->bind_param("ss", $login, $login);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

  public function findByUsername($username)
  {
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  public function create($username, $password, $fullname, $email, $phone, $address)
  {
    $stmt = $this->conn->prepare("INSERT INTO users (username, password, fullname, email, phone, address) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssss', $username, $password, $fullname, $email, $phone, $address);
    $stmt->execute();
  }

  public function getAllUsers($currentUserId) {
    // Truy vấn để hiển thị tất cả người dùng, loại trừ Admin hiện đang đăng nhập
    $sql = "SELECT id, username, fullname, email, phone, role, status 
            FROM users 
            WHERE id != ? 
            ORDER BY created_at DESC";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $currentUserId);
    $stmt->execute();

    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  }

  public function resetPassword($id, $newHashedPassword) {
    $sql = "UPDATE users SET password = ? WHERE id = ?";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("si", $newHashedPassword, $id);
    
    return $stmt->execute();
  }

  public function updateStatus($id, $status) {
    $sql = "UPDATE users SET status = ? WHERE id = ?";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ii", $status, $id);
    
    return $stmt->execute();
  }
  
  public function updateRole($id, $role) {
    $sql = "UPDATE users SET role = ? WHERE id = ?";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("si", $role, $id);
    
    return $stmt->execute();
  }
}