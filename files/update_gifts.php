<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
if (!isset($_SESSION['event_id'])) {
    header('Location: ../dashboard.php');
    exit;
}
require_once '../includes/db_config.php';


if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin' && isset($_SESSION['temp_user_id']))
{
    $user_id = $_SESSION['temp_user_id'];
}
elseif($_SESSION['role'] === 'user'){
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT 1 from events WHERE user_id = ? AND event_id = ? AND status = 'active'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $_SESSION['event_id']]);
    if (!$stmt->fetch()) {
        header('Location: ../event.php');
        exit;
    }
}
else{
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['gift_id']) && isset($_POST['name'])) {
    $gift_id = $_POST['gift_id'];
    $name = trim($_POST['name']);
    $link = trim($_POST['link']);

    if (!empty($name)) {
        $stmt = $pdo->prepare("UPDATE gifts SET name = ?, link = ? WHERE gift_id = ? AND event_id = ?");
        $stmt->execute([$name, $link, $gift_id, $_SESSION['event_id']]);
        $_SESSION['success'] = "Želja je uspešno izmenjena.";
    } else {
        $_SESSION['error'] = "Naziv ne sme biti prazan.";
    }
}

header("Location: ../event.php");
exit;
