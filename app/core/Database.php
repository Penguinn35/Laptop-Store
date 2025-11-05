<?php
class Database {
  private $host = "localhost";
  private $user = "root";
  private $pass = "";
  private $db = "laptop_store";
  private $conn;

  public function getConnection() {
    $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
    if ($this->conn->connect_error) {
      die("Kết nối thất bại: " . $this->conn->connect_error);
    }
    $this->conn->set_charset("utf8mb4");
    return $this->conn;
  }
}
