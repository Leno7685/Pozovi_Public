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
/*if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['event_id'])) {
    header('Location: dashboard.php');
    exit;
}*/
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $_SESSION['event_id'] = $_POST['event_id'];
} elseif (!isset($_SESSION['event_id'])) {
    header('Location: dashboard.php');
    exit;
}

$event_id = $_SESSION['event_id'];
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM events WHERE event_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$event_id]);
$event = $stmt->fetch();
if (!$event) {
    header('Location: dashboard.php');
    exit;
}

$sql = "SELECT 1 from events WHERE user_id = ? AND event_id = ? AND status != 'active'";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id, $event_id]);
if (!$stmt->fetch()) {
    header('Location: dashboard.php');
    exit;
}
if (isset($_POST['add_invitee']) && $_POST['add_invitee'] === '1') {
    $invitee_name = trim($_POST['invitee_name']);
    $invitee_email = trim($_POST['invitee_email']);

    if (empty($invitee_name) || empty($invitee_email)) {
        $_SESSION['error'] = "Morate uneti ime i email zvanice.";
    }
    if (!filter_var($invitee_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Neispravan format email adrese.';
    }else {
        try {
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM invitees WHERE event_id = ? and email = ?');
            $stmt->execute([$event_id, $invitee_email]);
            $count = $stmt->fetchColumn();
            if ($count > 0) {
                $_SESSION['error'] = "Zvanica sa ovim email-om već postoji!";
            } else {
                $token = bin2hex(random_bytes(32));
                try {
                    $stmt = $pdo->prepare('INSERT INTO invitees (name, email, event_id, token) VALUES (?, ?, ?, ?)');
                    $stmt->execute([$invitee_name, $invitee_email, $event_id, $token]);
                    $_SESSION['success'] = "Zvanica uspešno dodata.";
                } catch (Exception $e) {
                    $_SESSION['error'] = "Došlo je do greške: " . $e->getMessage();     //DEL
                }
            }
        }catch (Exception $e) {
            $_SESSION['error'] = "Došlo je do greške: " . $e->getMessage();     //DEL
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
    <title>Izmeni događaj</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="css.css">
</head>
<body style="padding-bottom: 14%; background-image: url('images/bg4.png');">
<?php include 'templates/header.php'; ?>

<div class="container mt-5">
    <div id="bgplavo">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php elseif (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>


        <div class="mb-3">
            <label for="event_title" class="form-label">Naziv događaja:</label>
            <input type="text" value="<?php echo $event['title'] ?>" id="event_title" name="event_title" class="form-control" disabled>
        </div>

        <div class="mb-3">
            <label for="event_description" class="form-label">Opis događaja:</label>
            <textarea id="event_description" name="event_description" class="form-control" rows="4" disabled><?php echo $event['description'] ?></textarea>
        </div>

        <div class="mb-3 col-12 col-md-5">
            <label for="event_date" class="form-label">Datum i vreme događaja:</label>
            <input type="datetime-local" value="<?php echo $event['event_date'] ?>" id="event_date" name="event_date" class="form-control" disabled>
        </div>

        <div class="mb-3 col-12 col-sm-11 col-md-7 col-lg-5">
            <label for="event_location" class="form-label">Lokacija događaja (adresa ili koordinate):</label>
            <input type="text" id="event_location" value="<?php echo $event['location'] ?>" name="event_location" class="form-control" disabled>
        </div>

        <div id="google-maps-link" class="mt-2" style="display: none;">
            <a href="" id="maps-link" target="_blank" class="btn btn-secondary" style="margin-bottom: 24px;">View on Google Maps</a>
        </div>
    </div>

    <div id="bgplavo">
        <div class="row">
            <h4 class="text-center">Lista zvanica:</h4>
            <!----------------------------------------------------------------------------------------------------->
                <table id="inviteesTable" class="display table table-striped" style="width:100%; font-size: 14px; margin-bottom:0px;">
                    <div class="mb-3" style="margin-bottom: 0px; padding-bottom: 0px;">
                        <label for="attendanceFilter" class="form-label">Filter:</label>
                        <select id="attendanceFilter" class="form-select" style="width: 200px;">
                            <option value="">Sve zvanice</option>
                            <option value="dolazi">Dolazi</option>
                            <option value="ne dolazi">Ne dolazi</option>
                            <option value="možda dolazi">Možda dolazi</option>
                        </select>
                    </div>

                    <thead>
                    <tr>
                        <th>Ime</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Datum poziva</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    try {
                        $stmt = $pdo->prepare("SELECT * FROM invitees WHERE event_id = ?");
                        $stmt->execute([$event_id]);

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr data-invitee-id='" . htmlspecialchars($row['invitee_id']) . "'>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['attendance']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                            echo "</tr>";
                        }
                    } catch (Exception $e) {
                        echo "Greška u povezivanju sa bazom: " . $e->getMessage();
                    }
                    ?>
                    </tbody>
                </table>
        </div>
        <hr class="mt-5 mb-5">
        <div class="row">
            <div class="col">
                <h4 class="text-center">Lista želja:</h4>
                <div id="lista" class="row g-4">
                    <?php
                    $sql = "SELECT gift_id, name, link, reserved FROM gifts WHERE event_id = ?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$event_id]);

                    $gifts = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if (count($gifts) > 0) {
                        foreach ($gifts as $row) {?>
                            <div class="col-auto">
                                <div id="gift" class="modal-header" style="padding-right:7px;" onclick="showGiftPopup(event, 'gift-popup', '<?php echo htmlspecialchars($row['name']); ?>', '<?php echo htmlspecialchars($row['link']); ?>', '<?php echo htmlspecialchars($row['reserved']); ?>', '<?php echo htmlspecialchars($row['gift_id']); ?>')">
                                    <h5 class="card-title fw-medium"><?php echo htmlspecialchars($row['name']); ?></h5>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    else {
                        echo "<p>Nema želja.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="gift-popup" class="popup">
    <div class="popup-content">
        <button class="close-btn" onclick="closePopup('gift-popup')">&#x2715;</button>

        <div class="mb-2">
            <label for="popup-name-input2" class="form-label">Naziv:</label>
            <input type="text" name="name" id="popup-name-input2" class="form-control" disabled>
        </div>

        <div class="mb-2">
            <label for="popup-link-input" class="form-label">Link:</label>
            <input type="text" name="link" id="popup-link-input" class="form-control" disabled>
        </div>

        <p id="popup-reserved" class="mt-4 fw-bold"></p>
    </div>
</div>
<script src="scripts/invitees.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="scripts/js1.js"></script>
<script src="scripts/js2.js"></script>
<script>
    const giftsData = <?php echo json_encode(array_column($gifts, 'gift_id')); ?>;
</script>

</body>
</html>







