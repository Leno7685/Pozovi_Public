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
require_once 'includes/expire_events.php';


$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arhivirani događaji</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css.css">
</head>
<body>
<?php include 'templates/header.php'; ?>

<div class="container mt-5 position-relative">
    <div class="d-flex justify-content-between mb-4 buttons">
        <a href="dashboard.php" class="btn btn-outline-info"><i class="bi bi-arrow-left"></i>Vrati se nazad</a>
    </div>
    <h3 class="text-center">Arhiva obrisanih događaja</h3>
</div>

<div class="container mt-5">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php elseif (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <?php
        $sql = "SELECT event_id, title, description, event_date FROM events WHERE user_id = ? and status = 'archived'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id]);

        $events = $stmt->fetchAll();

        if (count($events) > 0) {
        foreach ($events as $row) {
        ?>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <form action="event_archived.php" method="POST">
                <input type="hidden" name="event_id" value="<?php echo $row['event_id']; ?>">
                <div class="modal-header align-items-start">
                    <button id="eventCard" type="submit" class="card h-100 shadow-sm text-start" style="width: 100%; background: none;">
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p class="card-text text-muted"><?php echo htmlspecialchars(mb_strimwidth($row['description'], 0, 27, "...")); ?></p>
                            <p class="card-text"><small class="text-muted"><?php echo htmlspecialchars($row['event_date']); ?></small></p>
                        </div>
                    </button>
            </form>
            <form action="files/delete_event.php" method="post" onsubmit="return confirm('Da li ste sigurni da želite da uklonite događaj - <?php echo htmlspecialchars($row['title']); ?> ?')">
                <input type="hidden" name="event_id" value="<?php echo $row['event_id']; ?>">
                <button id="buttonX" type="submit" class="btn-close" aria-label="Obriši događaj" title="Obriši događaj"></button>
            </form>
        </div>
    </div>
<?php
}
} else {
    echo "<p>Nema arhiviranih događaja.</p>";
}
?>
</div>
</div>



<?php include 'templates/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>







