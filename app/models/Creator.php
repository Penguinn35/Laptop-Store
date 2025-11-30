<?php
class Creator {
    private $db;
    public function __construct($db) { $this->db = $db; }

    public function all() {
        $result = $this->db->query("SELECT id, name, bio, role, profile_image FROM creators ORDER BY id ASC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function update($id, $name, $role, $bio) {
        $stmt = $this->db->prepare("UPDATE creators SET name = ?, role = ?, bio = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $role, $bio, $id);
        return $stmt->execute();
    }
}
