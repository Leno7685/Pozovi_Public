<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once 'includes/db_config.php';

$stmt = $pdo->prepare("SELECT email, password, phone, fname, lname from users WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
if(!$user = $stmt->fetch()){
    $_SESSION['error'] = "Greška";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Podešavanje naloga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css.css">
</head>
<body class="bg6" style="padding-bottom: 4%">
<?php include 'templates/header.php'; ?>

<h2 class="text-center mt-4">Podešavanje naloga</h2>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger mt-4">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<div class="container mt-5 bgplavo3">
    <form action="files/update_user.php" method="POST">
        <div class="mb-3">
            <label for="first_name" class="form-label">Ime</label>
            <input type="text" value="<?= $user['fname'] ?>" class="form-control" id="first_name" name="first_name" minlength="2" maxlength="50" required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Prezime</label>
            <input type="text" value="<?= $user['lname'] ?>" class="form-control" id="last_name" name="last_name" minlength="2" maxlength="50" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Telefon</label>
            <input type="text" value="<?= $user['phone'] ?>" class="form-control" id="phone" name="phone" minlength="8" maxlength="20" >
        </div>
        <button type="submit" class="btn btn-primary">Sačuvaj promene</button>
    </form>
</div>

<div class="container mt-5 bgplavo3">
    <form action="files/update_password.php" method="POST">
        <?php if (isset($_SESSION['errorPassword'])): ?>
            <div class="alert alert-danger mt-4">
                <?= $_SESSION['errorPassword']; unset($_SESSION['errorPassword']); ?>
            </div>
        <?php elseif (isset($_SESSION['success'])): ?>
            <div class="alert alert-success mt-4">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="password" class="form-label">Trenutna lozinka</label>
            <input type="password" class="form-control" id="password" name="password" minlength="6" maxlength="64" required>
        </div>
        <div class="mb-3">
            <label for="new_password" class="form-label">Nova lozinka</label>
            <input type="password" class="form-control" id="new_password" name="new_password" minlength="6" maxlength="64" required>
        </div>
        <div class="mb-3">
            <label for="confirm_new_password" class="form-label">Potvrdi novu lozinku</label>
            <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" minlength="6" maxlength="64" required>
        </div>
        <button type="submit" class="btn btn-primary">Sačuvaj i verifikuj</button>
    </form>
</div>

<?php include 'templates/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

