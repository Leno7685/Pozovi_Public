<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
if (!isset($_SESSION['event_id'])) {
    header('Location: ../dashboard.php');
    exit;
}
require_once '../includes/db_config.php';
$event_id = $_SESSION['event_id'];

if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin' && isset($_SESSION['temp_user_id']))
{
    $user_id = $_SESSION['temp_user_id'];
}
elseif($_SESSION['role'] === 'user'){
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT 1 from events WHERE user_id = ? AND event_id = ? AND status = 'active'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $event_id]);
    if (!$stmt->fetch()) {
        header('Location: ../event.php');
        exit;
    }
}
else{
    header('Location: ../index.php');
    exit;
}

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['gift_name'])) {
    $name = trim($_POST['gift_name']);
    $link = isset($_POST['link']) ? trim($_POST['link']) : NULL;
    if (empty($name)) {
        $_SESSION['error'] = "Unesite naziv želje.";
    } else {
        try {
            $stmt = $pdo->prepare('INSERT INTO gifts (name, link, event_id) VALUES (?, ?, ?)');
            $stmt->execute([$name, $link, $event_id]);
            $_SESSION['success'] = "Želja uspešno dodata.";
        } catch (Exception $e) {
            $_SESSION['error'] = "Došlo je do greške: " . $e->getMessage();
        }
    }
}
header('Location: ../event.php');
exit;