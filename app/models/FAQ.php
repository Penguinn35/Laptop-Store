<?php

class FAQ {
    private $db; // mysqli connection

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function all()
    {
        $result = $this->db->query("SELECT id, question, answer, type FROM faqs");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create($question, $answer, $type)
    {
        $stmt = $this->db->prepare("INSERT INTO faqs (question, answer, type) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $question, $answer, $type);
        return $stmt->execute();
    }

    public function update($id, $question, $answer, $type)
    {
        $stmt = $this->db->prepare("UPDATE faqs SET question = ?, answer = ?, type = ? WHERE id = ?");
        $stmt->bind_param("sssi", $question, $answer, $type, $id);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM faqs WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function addTypeEnumColumn($types)
    {
        $typeList = "'" . implode("','", $types) . "'";
        $this->db->query("ALTER TABLE faqs MODIFY COLUMN type ENUM($typeList) DEFAULT 'general'");
    }
}