<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
require_once '../includes/db_config.php';

$user_id = $_SESSION['user_id'];

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['first_name']) && isset($_POST['last_name'])){
    $fname = trim($_POST['first_name']);
    $lname = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);
    if (empty($fname) || empty($lname)) {
        $_SESSION['error'] = "Ime i prezime ne smeju biti prazni.";
        header('Location: ../user_settings.php');
        exit;
    }
    if (!preg_match('/^\+?[0-9]{10,15}$/', $phone)) {
        $_SESSION['error'] = "Neispravan format telefona.";
        header('Location: ../user_settings.php');
        exit;
    }
    $stmt = $pdo->prepare("UPDATE users SET fname = ?, lname = ?, phone = ? WHERE user_id = ?");
    $stmt->execute([$fname,$lname,$phone,$user_id]);
}


header('Location: ../user_settings.php');
exit;