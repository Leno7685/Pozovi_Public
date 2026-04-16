<?php
session_start();
require_once '../includes/db_config.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['event_id'])) {
    header('Location: ../dashboard_archived.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$event_id = $_POST['event_id'];

if($_SESSION['role'] === 'admin' && isset($_POST['notification_text'])){
    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("SELECT user_id, title FROM events WHERE event_id = ?");
        $stmt->execute([$event_id]);
        $rez = $stmt->fetch();

        $pdo->prepare("DELETE FROM invitees WHERE event_id = ?")->execute([$event_id]);
        $pdo->prepare("DELETE FROM gifts WHERE event_id = ?")->execute([$event_id]);
        $stmt = $pdo->prepare("DELETE FROM events WHERE event_id = ?");
        $stmt->execute([$event_id]);
        $pdo->commit();

        if($rez) {
            $stmt = $pdo->prepare("INSERT INTO notifications (title, text, user_id) VALUES (?, ?, ?)");
            $stmt->execute(['Obrisan je događaj "' . $rez['title'] . '"', 'Razlog: ' . $_POST['notification_text'], $rez['user_id']]);
        }

        $_SESSION['success'] = "Događaj uspešno obrisan.";
    }
    catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['error'] = "Greška prilikom brisanja događaja: " . $e->getMessage();
    }
    header('Location: ../admin_dashboard.php');
    exit;
}
elseif ($_SESSION['role'] === 'user') {
    try {
        $pdo->beginTransaction();
        $sql = "SELECT 1 from events WHERE user_id = ? AND event_id = ? AND status = 'archived'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id, $event_id]);
        if (!$stmt->fetch()) {
            header('Location: ../dashboard.php');
            exit;
        }
        $pdo->prepare("DELETE FROM invitees WHERE event_id = ?")->execute([$event_id]);
        $pdo->prepare("DELETE FROM gifts WHERE event_id = ?")->execute([$event_id]);

        $stmt = $pdo->prepare("DELETE FROM events WHERE event_id = ? AND user_id = ? AND status = 'archived'");
        $stmt->execute([$event_id, $user_id]);

        $pdo->commit();

        $_SESSION['success'] = "Događaj uspešno uklonjen.";
    }
    catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['error'] = "Greška!";
    }

    header('Location: ../dashboard_archived.php');
    exit;
}

unset($_SESSION['event_id']);
header('Location: ../index.php');
exit;