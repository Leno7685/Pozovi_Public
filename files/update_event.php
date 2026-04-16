<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
require_once '../includes/db_config.php';

if (!isset($_POST['event_id'])) {
    header('Location: ../dashboard.php');
    exit;
}

$event_id = $_POST['event_id'];

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


$event_title = trim($_POST['event_title']);
$creator_id = $user_id;
$event_description = trim($_POST['event_description']);
$event_date = trim($_POST['event_date']);
$event_location = trim($_POST['event_location']);

if (empty($event_title) || empty($event_date)) {
    $_SESSION['error'] = "Niste popunili sva obavezna polja!";
}
else {
    try {
        $stmt = $pdo->prepare('UPDATE events SET title = ?, description = ?, event_date = ?, location = ? WHERE event_id = ?');
        $stmt->execute([$event_title, $event_description, $event_date, $event_location, $event_id]);
        $_SESSION['success'] = "Uspešno ste izmenili podatke";
    }
    catch (Exception $e) {
        $_SESSION['error'] = "Došlo je do greške: " . $e->getMessage();
    }
}
header('Location: ../event.php');
exit;
?>