<?php
session_start();
require_once '../includes/db_config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['attendance']) || !isset($_POST['selected_gift_id']) || !isset($_SESSION['invitee_id'])) {
    header('Location: ../invitation.php');           //vracanje korisnika nazad na invitation.php ukoliko nisu postavljene sve potrebne promenljive
    exit;
}
$invitee_id = $_SESSION['invitee_id'];
$attendance = $_POST['attendance'];
$gift_id = $_POST['selected_gift_id'];

$stmt = $pdo->prepare("UPDATE invitees SET attendance = ? WHERE invitee_id = ?");           //azuriranje kolone attendance
$stmt->execute([$attendance,$invitee_id]);

$stmt = $pdo->prepare("SELECT event_id, gift_id FROM invitees WHERE invitee_id = ?");
$stmt->execute([$invitee_id]);
$rez = $stmt->fetch();
$event_id = $rez['event_id'];

if($attendance == "ne dolazi" || $gift_id == "none"){                                                                                          //ukoliko je odabrani status zvanice "ne dolazi" automatski se oslobadja poklon
    $stmt = $pdo->prepare("UPDATE invitees SET gift_id = NULL WHERE invitee_id = ? AND event_id = ?");
    if($var = $stmt->execute([$invitee_id,$event_id])) {
        if ($rez['gift_id'] !== null) {
            $stmt = $pdo->prepare("UPDATE gifts SET reserved = 'available' WHERE gift_id = ?");
            $stmt->execute([$rez['gift_id']]);
        }
    }
}
else {
    $stmt = $pdo->prepare("SELECT 1 FROM gifts WHERE gift_id = ? AND event_id = ? AND reserved = 'available'");       //proveravanje da li postoji gift sa tim id-om, da li se nalazi u istom eventu kao i zvanica i da li nije rezervisan
    $stmt->execute([$gift_id, $event_id]);
    if ($stmt->fetch()) {
        if ($rez['gift_id'] !== null) {
            $stmt = $pdo->prepare("UPDATE gifts SET reserved = 'available' WHERE gift_id = ?");          //ukoliko je zvanica prethodno vec rezervisala neki poklon onda se taj poklon oslobadja
            $stmt->execute([$rez['gift_id']]);
        }
        $stmt = $pdo->prepare("UPDATE invitees SET gift_id = ? WHERE invitee_id = ? AND event_id = ?");
        if ($var = $stmt->execute([$gift_id, $invitee_id, $event_id])) {
            $stmt = $pdo->prepare("UPDATE gifts SET reserved = 'reserved' WHERE gift_id = ?");
            $stmt->execute([$gift_id]);
        }
    }
}


if(isset($_POST['token']) && isset($_POST['event_id'])){
    $token = urlencode($_POST['token']);
    $event_id = urlencode($_POST['event_id']);
    header("Location: ../invitation.php?id=$event_id&token=$token");        //vraca se na invitation.php i prenose se potrebne get promenljive
}
exit;