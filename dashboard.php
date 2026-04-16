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

$stmt = $pdo->prepare("SELECT notification_id, title, text FROM notifications WHERE user_id = ?");
$stmt->execute([$user_id]);
$notifications = $stmt->fetchAll();
$exists = count($notifications)>0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Događaji</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-4 buttons">
            <a href="dashboard_archived.php" class="btn btn-outline-info">Arhiva</a>
            <button class="btn btn-primary" type="button" id="notification" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                <img src="<?php  echo $exists ? 'images/notification1.png' : 'images/notification0.png';?>" alt="notification" width="25px" height="25px">
            </button>
            <?php
                if($exists){?>
            <ul id="notificationList" class="dropdown-menu dropdown-menu-end" aria-labelledby="notification">
                <?php
                    foreach ($notifications as $row){
                ?>
                <li class="dropdown-item" onclick="openNotification(event, this)">
                    <div class="d-flex justify-content-end">
                        <button class="notificationX" title="Ukloni notifikaciju" onclick="deleteNotification(this,<?php echo htmlspecialchars($row['notification_id']); ?>)">&#x2715;</button>
                    </div>
                    <div class="fw-bold" data-fulltitle="<?php echo htmlspecialchars($row['title']); ?>"><?php echo htmlspecialchars(mb_strimwidth($row['title'], 0, 44, "...")); ?></div>
                    <br>
                    <small class="text-muted"data-fulltext="<?php echo htmlspecialchars($row['text']); ?>"><?php echo htmlspecialchars(mb_strimwidth($row['text'], 0, 37, "...")); ?></small>
                </li>
                <?php
                    }
                ?>
            </ul>
            <?php }?>
        </div>
    </div>

    <div class="container mt-5">
        <!--eror -->
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
            $sql = "SELECT event_id, title, description, event_date, status FROM events WHERE user_id = ? and status != 'archived'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user_id]);

            $events = $stmt->fetchAll();

            if (count($events) > 0) {
                foreach ($events as $row) {
                    ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <?php $isBlocked = ($row['status'] === 'blocked'); ?>
                        <form action="<?php echo $isBlocked ? 'event_archived.php' : 'event.php';?>" method="POST">
                            <input type="hidden" name="event_id" value="<?php echo $row['event_id']; ?>">
                            <div class="modal-header align-items-start">
                            <button id="eventCard" type="submit" class="card h-100 shadow-sm text-start <?php echo $isBlocked ? 'blocked-card' : ''; ?>" style="width: 100%; background: none;">
                                <div class="card-body">
                                    <?php if ($isBlocked): ?>
                                        <div class="blokirano-text">Blokirano</div>
                                    <?php endif; ?>
                                    <h5 class="card-title fw-bold"><?php echo htmlspecialchars($row['title']); ?></h5>
                                    <p class="card-text text-muted"><?php echo htmlspecialchars(mb_strimwidth($row['description'], 0, 27, "...")); ?></p>
                                    <p class="card-text"><small class="text-muted"><?php echo htmlspecialchars($row['event_date']); ?></small></p>
                                </div>
                            </button>
                        </form>
                        <form action="files/archive_event.php" method="post" onsubmit="return confirm('Da li ste sigurni da želite da obrišete događaj?')">
                            <input type="hidden" name="event_id" value="<?php echo $row['event_id']; ?>">
                            <button id="buttonX" type="submit" class="btn-close" aria-label="Obriši događaj" title="Obriši događaj"></button>
                        </form>
                            </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>Nema događaja za prikaz.</p>";
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        function deleteNotification(button,id){
            const notification = button.closest("li");
            $.ajax({
                url: 'files/delete_notification.php',
                type: 'POST',
                data: {
                    notification_id: id,
                },
                success: function (response) {
                    notification.style.display = 'none';
                },
            });
        }

        function openNotification(event, element) {
            if (event.target.classList.contains('notificationX')) return;

            const title = element.querySelector('.fw-bold')?.dataset.fulltitle;
            const text = element.querySelector('small')?.dataset.fulltext;
            document.getElementById('notificationTitle').textContent = title;
            document.getElementById('notificationText').textContent = text;

            const notification_modal = new bootstrap.Modal(document.getElementById('notificationModal'));
            notification_modal.show();
        }

    </script>

    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="word-break: break-word;" class="modal-title" id="notificationTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body notificationText" id="notificationText"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zatvori</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>







