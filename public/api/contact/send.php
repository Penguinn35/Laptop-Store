<?php
header("Content-Type: application/json");
require_once "../../../app/core/Database.php";

$db = (new Database())->getConnection();

$stmt = $db->prepare("INSERT INTO contacts(name, email, subject, message) VALUES (?,?,?,?)");
$stmt->execute([
    $_POST['name'], 
    $_POST['email'],
    $_POST['subject'],
    $_POST['message']
]);

echo json_encode([
    "status" => true,
    "message" => "Gửi liên hệ thành công! Chúng tôi sẽ phản hồi sớm."
]);
exit;
?>