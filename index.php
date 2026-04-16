<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pozovi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css.css">
    <style>
    </style>
</head>
<body style="padding-bottom: 14%; padding-top:11%;  background-image: url('images/bg7.jpg');">
    <?php include 'templates/header.php'; ?>

    <div class="container mt-5 text-center" style="color:#dcedff;">
        <!--div class="bgplavo4"-->
            <!--h1>Dobrodošli u "Pozovi"</h1-->
            <h1 class="mt-5 pt-5 mb-5">Kreiraj događaje na jednostavan i efikasan način.</h1>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="register.php" class="btn btn-primary btn-glow me-3">Registruj se</a>
                <a href="login.php" class="btn btn-outline-info btn-glow">Prijavi se</a>
            <?php else: ?>
                <?php if ($_SESSION['role'] == 'user'): ?><a href="<?php echo ($_SESSION['role'] == 'admin') ? '' : 'dashboard.php'; ?>" class="btn btn-primary btn-glow me-3">Događaji</a><?php endif; ?>
                <a href="logout.php" class="btn btn-outline-info btn-glow">Odjavi se</a>
            <?php endif; ?>
        <!--/div-->
    </div>

    <?php include 'templates/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
