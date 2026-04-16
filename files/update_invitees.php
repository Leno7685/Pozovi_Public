<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
require_once '../includes/db_config.php';
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['event_id'])) {
    header('Location: ../dashboard.php');
    exit;
}
$event_id = $_SESSION['event_id'];

if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin' && isset($_SESSION['temp_user_id'])) {
    $user_id = $_SESSION['temp_user_id'];
} elseif($_SESSION['role'] === 'user'){
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT 1 from events WHERE user_id = ? AND event_id = ? AND status = 'active'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $event_id]);
    if (!$stmt->fetch()) {
        header('Location: ../event.php');
        exit;
    }
} else {
    header('Location: ../index.php');
    exit;
}

class Invitee {
    public $id;
    public $name;
    public $email;
    public $old_email;

    public function __construct($id, $name, $email, $old_email) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->old_email = $old_email;
    }
}

$stmt = $pdo->prepare("SELECT * FROM invitees WHERE event_id = ?");
$stmt->execute([$event_id]);
$invitees_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
$invitees_old = [];
foreach($invitees_data as $inv) {
    $invitees_old[$inv['invitee_id']] = $inv['email'];
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edited_ids']) && isset($_POST['name']) && isset($_POST['email'])) {
    $invitees = [];
    for ($i = 0; $i < count($_POST['edited_ids']); $i++) {
        $email = trim($_POST['email'][$i]);
        $name = trim($_POST['name'][$i]);
        $invitee_id = $_POST['edited_ids'][$i];
        $old_email = $invitees_old[$invitee_id] ?? '';
        if (empty($name) || empty($email)) {
            $_SESSION['errorInvitees'] = "Ime i email ne smeju biti prazni.";
            header('Location: ../event.php');
            exit;
        }
        $sql = "SELECT 1 from invitees WHERE invitee_id = ? AND event_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$invitee_id, $event_id]);
        if (!$stmt->fetch()) {
            continue;
        }
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM invitees WHERE event_id = ? AND email = ? AND invitee_id != ?');
        $stmt->execute([$event_id, $email, $invitee_id]);
        $count = $stmt->fetchColumn();
        if ($count > 0) {
            $_SESSION['errorInvitees'] = "Zvanica sa email-om: \"" . $email . "\" već postoji!";
            header('Location: ../event.php');
            exit;
        }
        $invitees[] = new Invitee($invitee_id, $name, $email, $old_email);
    }

    foreach ($invitees as $invitee) {
        $stmt = $pdo->prepare("UPDATE invitees SET name = ?, email = ? WHERE invitee_id = ?");
        $stmt->execute([$invitee->name, $invitee->email, $invitee->id]);

        if ($invitee->email !== $invitee->old_email) {
            $token = bin2hex(random_bytes(32));
            $stmt = $pdo->prepare("UPDATE invitees SET token = ? WHERE invitee_id = ?");
            $stmt->execute([$token, $invitee->id]);
            $invite_link = "https://leon.stud.vts.su.ac.rs/Pozovi/invitation.php?id={$event_id}&token={$token}";

            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'lnbuila@gmail.com';
                $mail->Password   = 'fzui nnat eyhl zyiw';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;
                $mail->setFrom('lnbuila@gmail.com', 'Pozovi');
                $mail->addAddress($invitee->email, $invitee->name);
                $mail->isHTML(true);
                $mail->Subject = "Poziv na događaj: " . $event['title'];
                $mail->Body    = "Zdravo <b>{$invitee->name}</b>,<br><br>Vaš email je ažuriran za događaj <b>{$event['title']}</b> koji se održava: {$event['event_date']}.<br>Kliknite na link da potvrdite prisustvo:<br><a href='$invite_link'>$invite_link</a>";
                $mail->AltBody = "Otvorite ovaj link da potvrdite prisustvo: $invite_link";
                $mail->send();
            } catch (Exception $e) {
                $_SESSION['errorInvitees'] = "Došlo je do greške prilikom slanja mejla: {$mail->ErrorInfo}";
            }
        }
    }
    $_SESSION['successInvitee'] = "Sve izmene su uspešno sačuvane.";
}

if (isset($_POST['deleted_invitees'])) {
    $deleted_ids = json_decode($_POST['deleted_invitees'], true);
    if (is_array($deleted_ids)) {
        foreach ($deleted_ids as $id) {
            $sql = "SELECT 1 from invitees WHERE invitee_id = ? AND event_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id, $event_id]);
            if (!$stmt->fetch()) {
                continue;
            }
            $stmt = $pdo->prepare("DELETE FROM invitees WHERE invitee_id = ? AND event_id = ?");
            $stmt->execute([$id, $event_id]);
        }
    }
}

header("Location: ../event.php");
exit;
?>