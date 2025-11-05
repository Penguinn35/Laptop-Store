<?php
require __DIR__ . '/../models/Laptop.php';
$laptops = Laptop::all($pdo);
require __DIR__ . '/../views/home.php';
?>
