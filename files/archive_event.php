<?php
session_start();
require_once '../includes/db_config.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['event_id'])) {
    header('Location: ../dashboard.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$event_id = $_POST['event_id'];

try {
    $stmt = $pdo->prepare("UPDATE events SET status = 'archived' WHERE event_id = ? AND user_id = ? AND status != 'archived'");
    $stmt->execute([$event_id, $user_id]);
    $_SESSION['success'] = "Događaj uspešno obrisan.";
} catch (Exception $e) {
    $_SESSION['error'] = "Greška: " . $e->getMessage();
}

unset($_SESSION['event_id']);
header('Location: ../dashboard.php');
exit;
