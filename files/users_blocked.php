<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}
require_once '../includes/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'] ?? null;
    $blocked = $_POST['blocked'] ?? null;

    if ($userId !== null && ($blocked === '0' || $blocked === '1')) {
        $stmt = $pdo->prepare("UPDATE users SET blocked = :blocked WHERE user_id = :user_id");
        $stmt->execute(['blocked' => $blocked, 'user_id' => $userId]);
        echo "OK";
    } else {
        http_response_code(400);
        echo "Invalid input";
    }
}
?>
