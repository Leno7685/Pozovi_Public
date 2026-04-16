<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

require_once 'vendor/autoload.php';
require_once 'includes/db_config.php';
use Detection\MobileDetect;
$detect = new MobileDetect;

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT user_id, password, fname, lname, role, activated, blocked FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password']) && $user['blocked'] != 1 && $user['activated'] == 1) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['fname'] = $user['fname'];
        $_SESSION['lname'] = $user['lname'];
        $_SESSION['role'] = $user['role'];

        $ip_address = $_SERVER['REMOTE_ADDR'];
        $http_user_agent = $_SERVER['HTTP_USER_AGENT'];
        $device_type = 'computer';
        if ($detect->isMobile()) {
            $device_type = 'phone';
        } elseif ($detect->isTablet()) {
            $device_type = 'tablet';
        }

        $operating_system = 'other';
        if ($detect->isAndroidOS()) {
            $operating_system = 'android';
        } elseif ($detect->isiOS()) {
            $operating_system = 'ios';
        } elseif (strpos($http_user_agent, 'Windows') !== false) {
            $operating_system = 'windows';
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO detects (ip_address, user_id, operating_system, device_type, http_user_agent) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$ip_address, $_SESSION['user_id'], $operating_system, $device_type, $http_user_agent]);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        require_once 'includes/expire_events.php';

        if($_SESSION['role'] == 'admin'){
            //$pdo->prepare("DELETE FROM password_resets WHERE expires_at < NOW()")->execute();            //brisanje svih isteklih linkova za reset lozinke
            header('Location: index.php');
            exit;
        }
        else{
            header('Location: dashboard.php');
            exit;
        }
    }
    else {
        if(!$user) {
            $errors[] = 'Ne postoji nalog sa ovom email adresom.';
        }
        else{
            if(!password_verify($password, $user['password'])){
                $errors[] = 'Lozinka koju ste uneli je pogrešna.';
            }
            elseif ($user['blocked'] == 1) {
                $errors[] = 'Zabranjen vam je pristup na sistem.';
            }
            elseif ($user['activated'] == 0) {
                $errors[] = 'Niste još aktivirali nalog.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prijava</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>

    <div class="container mt-5">
        <h2>Prijava</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>
        <form action="login.php" method="POST" id="loginForm">
            <div class="mb-3">
                <label for="email" class="form-label">Email adresa</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Lozinka</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Prijavi se</button>
        </form>
    </div>

    <?php include 'templates/footer.php'; ?>

    <!--<script src="js2/js2.js"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
