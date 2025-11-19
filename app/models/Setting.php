<?php

class Setting {

    private $db; // mysqli connection

    public function __construct($db) {
        $this->db = $db;
    }

    public function get($key) {
        $stmt = $this->db->prepare("SELECT value FROM settings WHERE `key` = ?");
        $stmt->bind_param("s", $key);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? $result['value'] : null;
    }

    public function all() {
        $result = $this->db->query("SELECT `key`, `value` FROM settings");

        $settings = [];
        while ($row = $result->fetch_assoc()) {
            $settings[$row['key']] = $row['value'];
        }

        return $settings;
    }

    public function update($key, $value) {
        $stmt = $this->db->prepare("UPDATE settings SET value = ? WHERE `key` = ?");
        $stmt->bind_param("ss", $value, $key);
        return $stmt->execute();
    }
}
