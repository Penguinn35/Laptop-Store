<?php
class Laptop {
    public static function all($pdo) {
        $stmt = $pdo->query("SELECT laptops.*, brands.name AS brand_name
                             FROM laptops JOIN brands ON laptops.brand_id = brands.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
