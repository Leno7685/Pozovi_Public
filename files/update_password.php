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

$user_id = $_SESSION['user_id'];

if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['token'])){
    $stmt = $pdo->prepare("SELECT password, expires_at FROM password_resets WHERE token = ? AND user_id = ?");
    $stmt->execute([$_GET['token'], $user_id]);
    if($reset = $stmt->fetch()){
        if (strtotime($reset['expires_at']) < time()) {
            $_SESSION['errorPassword'] = "Link je istekao.";
        } else {
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE user_id = ?");
            $stmt->execute([$reset['password'],$user_id]);
            $_SESSION['success'] = "Uspešno ste promenili lozinku";
        }
        $stmt = $pdo->prepare("DELETE FROM password_resets WHERE token = ?");
        $stmt->execute([$_GET['token']]);
        header('Location: ../user_settings.php');
        exit;
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password']) && isset($_POST['new_password']) && isset($_POST['confirm_new_password'])){
    $password = trim($_POST['password']);
    $new_password = trim($_POST['new_password']);
    $confirm_new_password = trim($_POST['confirm_new_password']);

    if (empty($password) || empty($new_password) || empty($confirm_new_password)) {
        $_SESSION['errorPassword'] = "Niste popunili sva polja.";
        header('Location: ../user_settings.php');
        exit;
    }

    $stmt = $pdo->prepare('SELECT email,password,fname,lname FROM users WHERE user_id = ?');
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    if ($user && !password_verify($password, $user['password'])) {
        $_SESSION['errorPassword'] = "Uneli ste pogrešnu lozinku.";
        header('Location: ../user_settings.php');
        exit;
    }

    if (strlen($new_password) < 6) {
        $_SESSION['errorPassword'] = "Lozinka mora imati najmanje 6 karaktera.";
        header('Location: ../user_settings.php');
        exit;
    }

    if ($new_password !== $confirm_new_password) {
        $_SESSION['errorPassword'] = "Nove lozinke se ne poklapaju.";
        header('Location: ../user_settings.php');
        exit;
    }

    $expires_at = date('Y-m-d H:i:s', time() + 1800);
    $token = bin2hex(random_bytes(32));
    $new_password_hash = password_hash($new_password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO password_resets (user_id,token,password,expires_at) VALUES (?,?,?,?)");
    $stmt->execute([$user_id, $token, $new_password_hash, $expires_at]);

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'lnbuila@gmail.com';
        $mail->Password   = 'fzui nnat eyhl zyiw';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->setFrom('lnbuila@gmail.com', 'Pozovi');
        $mail->addAddress($user['email'], $user['fname'] . ' ' . $user['lname']);
        $mail->isHTML(true);
        $mail->Subject = 'Promena lozinke';
        $invite_link = "https://leon.stud.vts.su.ac.rs/Pozovi/files/update_password.php?token={$token}";
        $mail->Body    = "Zdravo <b>{$user['fname']}</b>,<br><br>Kliknite na link da potvrdite promenu lozinke:<br><a href='$invite_link'>$invite_link</a>";
        $mail->AltBody = "Otvorite ovaj link da potvrdite promenu lozinke: $invite_link";
        $mail->send();
        $_SESSION['success'] = "Verifikacioni link je poslat na vaš mejl.";
    } catch (Exception $e) {
        $_SESSION['errorPassword'] = "Došlo je do greške prilikom slanja emaila: {$mail->ErrorInfo}";
    }

    header('Location: ../user_settings.php');
    exit;
}
?>