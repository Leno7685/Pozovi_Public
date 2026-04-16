<?php
header("Content-Type: application/json; charset=UTF-8");
require_once '../includes/db_config.php';
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$data = json_decode(file_get_contents("php://input"));
$errors = [];

if (!isset($data->email, $data->password, $data->confirm_password, $data->first_name, $data->last_name, $data->phone)) {
    http_response_code(400);
    echo json_encode(["error" => "Sva polja su obavezna."]);
    exit;
}

$email = trim($data->email);
$password = $data->password;
$confirm_password = $data->confirm_password;
$fname = trim($data->first_name);
$lname = trim($data->last_name);
$phone = trim($data->phone);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Neispravan format email adrese.';
}

if (strlen($password) < 6) {
    $errors[] = 'Lozinka mora imati najmanje 6 karaktera.';
}

if ($password !== $confirm_password) {
    $errors[] = 'Lozinke se ne poklapaju.';
}

if (empty($fname) || empty($lname)) {
    $errors[] = 'Ime i prezime su obavezni.';
}

if (!empty($phone) && !preg_match('/^\+?[0-9]{10,15}$/', $phone)) {
    $errors[] = 'Neispravan format telefona.';
}

$stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    $errors[] = 'Korisnik sa ovom email adresom već postoji!';
}

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(["errors" => $errors]);
    exit;
}

$password_hash = password_hash($password, PASSWORD_BCRYPT);
$token = bin2hex(random_bytes(16));

$stmt = $pdo->prepare("INSERT INTO users (email, password, fname, lname, phone, role, activated, token, registration_date) VALUES (?, ?, ?, ?, ?, 'user', 0, ?, NOW())");

if ($stmt->execute([$email, $password_hash, $fname, $lname, $phone, $token])) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'PRIVATE';
        $mail->Password   = 'PRIVATE';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->setFrom('PRIVATE', 'Pozovi');
        $mail->addAddress($email, $fname . ' ' . $lname);
        $mail->isHTML(true);
        $mail->Subject = 'Aktivacija naloga';
        $activationLink = "https://leon.stud.vts.su.ac.rs/Pozovi/activate.php?token=" . $token;
        $mail->Body    = "Zdravo <b>$fname</b>,<br><br>Kliknite na link da aktivirate vaš nalog:<br><a href='$activationLink'>$activationLink</a>";
        $mail->AltBody = "Otvorite ovaj link da aktivirate nalog: $activationLink";
        $mail->send();
        http_response_code(201);
        echo json_encode(["message" => "Uspešna registracija. Proverite email za aktivacioni link."]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => "Došlo je do greške prilikom slanja emaila: {$mail->ErrorInfo}"]);
    }
} else {
    http_response_code(500);
    echo json_encode(["error" => "Došlo je do greške prilikom registracije."]);
}
?>