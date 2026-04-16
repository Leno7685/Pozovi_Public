<?php
session_start();
require_once 'includes/db_config.php';

if (!isset($_GET['token'])) {
    $_SESSION['error'] = 'Nedostaje token za aktivaciju.';
    header('Location: login.php');
    exit;
}

$token = $_GET['token'];

$stmt = $pdo->prepare('SELECT user_id FROM users WHERE token = ? AND activated = 0');
$stmt->execute([$token]);
$user = $stmt->fetch();

if ($user) {
    $stmt = $pdo->prepare('UPDATE users SET activated = 1, token = NULL WHERE user_id = ?');
    if ($stmt->execute([$user['user_id']])) {
        $_SESSION['success'] = 'Vaš nalog je uspešno aktiviran. Sada se možete prijaviti.';
    } else {
        $_SESSION['error'] = 'Došlo je do greške prilikom aktivacije.';
    }
} else {
    $_SESSION['error'] = 'Nevažeći ili već iskorišćen token.';
}

header('Location: login.php');
exit;
?>
