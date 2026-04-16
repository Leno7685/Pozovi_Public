<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}
require_once '../includes/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id']) && isset($_POST['status'])) {
    $eventId = $_POST['event_id'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE events SET status = ? WHERE event_id = ?");
    $stmt->execute([$status, $eventId]);
}
?>
