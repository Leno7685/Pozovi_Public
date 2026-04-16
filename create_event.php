<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header('Location: index.php');
}
require_once 'includes/db_config.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_title = trim($_POST['event_title']);
    $creator_id = $_SESSION['user_id'];
    $event_description = trim($_POST['event_description']);
    $event_date = trim($_POST['event_date']);
    $event_location = trim($_POST['event_location']);

    if (empty($event_title) || empty($event_date)) {
        $_SESSION['error'] = "Niste popunili sva obavezna polja!";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT event_id FROM events WHERE title = ? AND user_id = ? AND status = 'active'");
            $stmt->execute([$event_title, $creator_id]);

            if ($stmt->fetch()) {
                $_SESSION['error'] = "Već ste kreirali događaj sa ovim nazivom!";
            } else {
                $stmt = $pdo->prepare('INSERT INTO events (title, description, event_date, location, user_id) VALUES (?, ?, ?, ?, ?)');
                $stmt->execute([$event_title, $event_description, $event_date, $event_location, $creator_id]);
                $_SESSION['success'] = "Novi događaj je uspešno kreiran.";
                $_SESSION['event_id'] = $pdo->lastInsertId();
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Došlo je do greške: " . $e->getMessage();
        }
    }

    header('Location: event.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kreiraj događaj</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css.css">
</head>
<body class="bg6">
    <?php include 'templates/header.php'; ?>

    <div class="container mt-5 bgplavo3">
        <h2 class="naslovKreiraj">Kreiraj novi događaj</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php elseif (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <form action="create_event.php" method="post">
            <div class="mb-3">
                <label for="event_title" class="form-label">Naziv događaja:</label>
                <input type="text" id="event_title" name="event_title" class="form-control" minlength="3" maxlength="40" required>
            </div>

            <div class="mb-3">
                <label for="event_description" class="form-label">Opis događaja:</label>
                <textarea id="event_description" name="event_description" class="form-control" rows="4" placeholder="Unesi opis događaja" minlength="3" maxlength="1000"></textarea>
            </div>

            <div class="col-9 col-md-6 col-xxl-4 mb-3">
                <label for="event_date" class="form-label">Datum i vreme događaja:</label>
                <input type="datetime-local" id="event_date" name="event_date" class="form-control" required>
            </div>

            <div class="col-9 col-md-6 col-xxl-4 mb-3">
            <label for="event_location" class="form-label">Lokacija događaja (adresa ili koordinate):</label>
            <input type="text" id="event_location" name="event_location" class="form-control" placeholder="Unesite lokaciju" maxlength="100">
            </div>

            <div id="google-maps-link" class="mt-2" style="display: none;">
                <a href="" id="maps-link" target="_blank" class="btn btn-secondary" style="margin-bottom: 24px;">Google Maps</a>
            </div>

            <button type="submit" class="btn btn-primary">Kreiraj</button>
        </form>
    </div>

    <?php include 'templates/footer.php'; ?>

    <script src="scripts/js1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>







