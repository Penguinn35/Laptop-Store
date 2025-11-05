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
}
