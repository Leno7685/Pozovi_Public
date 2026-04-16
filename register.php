<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'includes/db_config.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$errors = [];

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $fname = trim($_POST['first_name']);
    $lname = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);

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
    if (empty($phone) || !preg_match('/^\+?[0-9]{10,15}$/', $phone)) {
        $errors[] = 'Neispravan format telefona.';
    }

    $stmt = $pdo->prepare('SELECT user_id FROM users WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $errors[] = 'Korisnik sa ovom email adresom već postoji!';
    }

    if (empty($errors)) {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $token = bin2hex(random_bytes(16));

        $stmt = $pdo->prepare('INSERT INTO users (email, password, fname, lname, phone, role, activated, token, registration_date) VALUES (?, ?, ?, ?, ?, "user", 0, ?, NOW())');
        if ($stmt->execute([$email, $password_hash, $fname, $lname, $phone, $token])) {
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
                $mail->addAddress($email, $fname . ' ' . $lname);
                $mail->isHTML(true);
                $mail->Subject = 'Aktivacija naloga';
                $activationLink = "https://leon.stud.vts.su.ac.rs/Pozovi/activate.php?token=" . $token;
                $mail->Body    = "Zdravo <b>$fname</b>,<br><br>Kliknite na link da aktivirate vaš nalog:<br><a href='$activationLink'>$activationLink</a>";
                $mail->AltBody = "Otvorite ovaj link da aktivirate nalog: $activationLink";
                $mail->send();
                $_SESSION['success'] = 'Uspešna registracija. Proverite email za aktivacioni link.';
                header('Location: login.php');
                exit;
            } catch (Exception $e) {
                $errors[] = "Došlo je do greške prilikom slanja emaila: {$mail->ErrorInfo}";
            }
        } else {
            $errors[] = 'Došlo je do greške prilikom registracije.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css.css">
</head>
<body>
<?php include 'templates/header.php'; ?>

<div class="container mt-5">
    <h2>Registracija</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="register.php" method="POST" id="registerForm">
        <div class="mb-3">
            <label for="first_name" class="form-label">Ime</label>
            <input type="text" class="form-control" id="first_name" name="first_name" minlength="2" maxlength="50" required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Prezime</label>
            <input type="text" class="form-control" id="last_name" name="last_name" minlength="2" maxlength="50" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Telefon</label>
            <input type="text" class="form-control" id="phone" name="phone" minlength="8" maxlength="20">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email adresa</label>
            <input type="email" class="form-control" id="email" name="email" maxlength="254" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Lozinka</label>
            <input type="password" class="form-control" id="password" name="password" minlength="6" maxlength="64" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Potvrdi Lozinku</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" minlength="6" maxlength="64" required>
        </div>
        <button type="submit" class="btn btn-primary">Registruj se</button>
    </form>
</div>

<?php include 'templates/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>