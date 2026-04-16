<?php
session_start();
require_once '../includes/db_config.php';

if (!isset($_SESSION['user_id'],$_POST['notification_id'])) {
    header('Location: ../dashboard.php');
    exit;
}

$notification_id = $_POST['notification_id'];

if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin' && isset($_SESSION['temp_user_id']))
{
    $user_id = $_SESSION['temp_user_id'];
}
elseif($_SESSION['role'] === 'user'){
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT 1 from notifications WHERE user_id = ? AND notification_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $notification_id]);
    if (!$stmt->fetch()) {
        header('Location: ../dashboard.php');
        exit;
    }
}
else{
    header('Location: ../index.php');
    exit;
}


$stmt = $pdo->prepare("DELETE FROM notifications WHERE notification_id = ? AND user_id = ?");
$stmt->execute([$notification_id, $user_id]);

header('Location: ../dashboard.php');
exit;
