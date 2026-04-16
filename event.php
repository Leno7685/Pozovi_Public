<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once 'includes/db_config.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SESSION['role'] === 'admin') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
        $stmt = $pdo->prepare("SELECT user_id from events WHERE event_id = ?");
        $stmt->execute([$_POST['event_id']]);
        $user_id = $stmt->fetchColumn();
        $sql = "SELECT 1 from events WHERE user_id = ? AND event_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id, $_POST['event_id']]);
        if (!$stmt->fetch()) {
            header('Location: admin_dashboard.php');
            exit;
        }
        $_SESSION['temp_user_id'] = $user_id;
        $_SESSION['event_id'] = $_POST['event_id'];
        header('Location: event.php');
    } elseif (!isset($_SESSION['event_id'])) {
        header('Location: dashboard.php');
        exit;
    }
} elseif ($_SESSION['role'] === 'user') {
    $user_id = $_SESSION['user_id'];
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
        $sql = "SELECT 1 from events WHERE user_id = ? AND event_id = ? AND status = 'active'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id, $_POST['event_id']]);
        if (!$stmt->fetch()) {
            header('Location: dashboard.php');
            exit;
        }
        $_SESSION['event_id'] = $_POST['event_id'];
        header('Location: event.php');
    } elseif (!isset($_SESSION['event_id'])) {
        header('Location: dashboard.php');
        exit;
    }
} else {
    header('Location: login.php');
    exit;
}

$event_id = $_SESSION['event_id'];
$sql = "SELECT * FROM events WHERE event_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$event_id]);
$event = $stmt->fetch();
if (!$event) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['invitee_name']) && isset($_POST['invitee_email'])) {
    $invitee_name = trim($_POST['invitee_name']);
    $invitee_email = trim($_POST['invitee_email']);
    if (empty($invitee_name) || empty($invitee_email)) {
        $_SESSION['errorInviteeAdd'] = "Morate uneti ime i email zvanice.";
    } elseif (!filter_var($invitee_email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errorInviteeAdd'] = 'Neispravan format email adrese.';
    } else {
        try {
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM invitees WHERE event_id = ? and email = ?');
            $stmt->execute([$event_id, $invitee_email]);
            $count = $stmt->fetchColumn();
            if ($count > 0) {
                $_SESSION['errorInviteeAdd'] = "Zvanica sa ovim email-om već postoji!";
            } else {
                $token = bin2hex(random_bytes(32));
                $invite_link = "https://leon.stud.vts.su.ac.rs/Pozovi/invitation.php?id={$event_id}&token={$token}";
                $_SESSION['fafa'] = $invite_link;
                $stmt = $pdo->prepare('INSERT INTO invitees (name, email, event_id, token) VALUES (?, ?, ?, ?)');
                $stmt->execute([$invitee_name, $invitee_email, $event_id, $token]);

                try {
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'lnbuila@gmail.com';
                    $mail->Password   = 'fzui nnat eyhl zyiw';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;
                    $mail->setFrom('lnbuila@gmail.com', 'Pozovi');
                    $mail->addAddress($invitee_email, $invitee_name);
                    $mail->isHTML(true);
                    $mail->Subject = "Poziv na događaj: " . $event['title'];
                    $mail->Body    = "Zdravo <b>$invitee_name</b>,<br><br>Vi ste pozvani na događaj <b>{$event['title']}</b> koji se održava: {$event['event_date']}.<br>Kliknite na link da potvrdite prisustvo:<br><a href='$invite_link'>$invite_link</a>";
                    $mail->AltBody = "Otvorite ovaj link da potvrdite prisustvo: $invite_link";
                    $mail->send();
                } catch (Exception $e) {
                    $_SESSION['errorInviteeAdd'] = "Došlo je do greške prilikom slanja mejla: {$mail->ErrorInfo}";
                }

                $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ? AND activated = '1' AND role = 'user'");
                $stmt->execute([$invitee_email]);
                if($invitee_user_id = $stmt->fetchColumn()){
                    $notificationText = "Zdravo " . $invitee_name . "! " . $_SESSION['fname'] . " " . $_SESSION['lname'] . " vas poziva na događaj " . $event['title'] . " koji se održava: " . $event['event_date'] . ". Proverite vaš mejl.";
                    $stmt = $pdo->prepare("INSERT INTO notifications (title, text, user_id) VALUES (?, ?, ?)");
                    $stmt->execute(['Pozvani se na događaј "' . $event['title'] . '"', $notificationText, $invitee_user_id]);
                }
            }
        } catch (Exception $e) {
            $_SESSION['errorInviteeAdd'] = "Došlo je do greške: " . $e->getMessage();
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
            <h2 class="text-center">Izmeni događaj</h2>
            <?php echo $_SESSION['fafa'] ?? ''; ?>
            <hr>
            <h4 class="naslovKreiraj"><?php echo $event['title'] ?></h4>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php elseif (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <form action="files/update_event.php" method="post">
                <div class="mb-3">
                    <label for="event_title" class="form-label">Naziv događaja:</label>
                    <input type="text" value="<?php echo $event['title'] ?>" id="event_title" name="event_title" class="form-control" minlength="3" maxlength="40" required>
                </div>

                <div class="mb-3">
                    <label for="event_description" class="form-label">Opis događaja:</label>
                    <textarea id="event_description" name="event_description" class="form-control" rows="4" placeholder="Unesi opis događaja" minlength="3" maxlength="1000"><?php echo $event['description'] ?></textarea>
                </div>

                <div class="mb-3 col-12 col-md-5">
                    <label for="event_date" class="form-label">Datum i vreme događaja:</label>
                    <input type="datetime-local" value="<?php echo $event['event_date'] ?>" id="event_date" name="event_date" class="form-control" required>
                </div>

                <div class="mb-3 col-12 col-sm-11 col-md-7 col-lg-5">
                <label for="event_location" class="form-label">Lokacija događaja (adresa ili koordinate):</label>
                <input type="text" id="event_location" value="<?php echo $event['location'] ?>" name="event_location" class="form-control" maxlength="100" placeholder="Unesite lokaciju">
                </div>

                <div id="google-maps-link" class="mt-2" style="display: none;">
                    <a href="" id="maps-link" target="_blank" class="btn btn-secondary" style="margin-bottom: 24px;">Google Maps</a>
                </div>
                <input type="hidden" name="event_id" value="<?php echo $event_id ?>">
                <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
            </form>
        </div>

        <div id="bgplavo">
            <h1 class="text-center">Pozivnica</h1>
            <div class="row">
                <hr>
                <div class="col-12 col-lg-8">
                    <?php if (isset($_SESSION['errorInviteeAdd'])): ?>
                        <div class="alert alert-danger">
                            <?= $_SESSION['errorInviteeAdd']; unset($_SESSION['errorInviteeAdd']); ?>
                        </div>
                    <?php endif; ?>
                    <form action="event.php" method="post">
                        <h3>Dodaj zvanicu</h3>
                        <div class="col-12 col-sm-8 col-md-6 mb-3">
                            <label for="invitee_name" class="form-label">Ime zvanice:</label>
                            <input type="text" id="invitee_name" name="invitee_name" class="form-control" minlength="2" maxlength="50" required>
                        </div>

                        <div class="col-12 col-sm-8 col-md-6 mb-3">
                            <label for="invitee_email" class="form-label">Email zvanice:</label>
                            <input type="email" id="invitee_email" name="invitee_email" class="form-control" maxlength="254" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Pozovi</button>
                    </form>
                </div>
                <hr class="mt-2">
                    <h4 class="text-center">Lista zvanica:</h4>
                    <!----------------------------------------------------------------------------------------------------->
                    <form action="files/update_invitees.php" method="POST" style="overflow-x:auto;">
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
                            <?php if (isset($_SESSION['errorInvitees'])): ?>
                                <div class="alert alert-danger">
                                    <?= $_SESSION['errorInvitees']; unset($_SESSION['errorInvitees']); ?>
                                </div>
                            <?php elseif (isset($_SESSION['successInvitees'])): ?>
                                <div class="alert alert-success">
                                    <?= $_SESSION['successInvitees']; unset($_SESSION['successInvitees']); ?>
                                </div>
                            <?php endif; ?>

                            <thead>
                            <tr>
                                <th>Ime</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Datum poziva</th>
                                <th>Akcije</th>
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
                                            echo "<td>
                                            <button type='button' class='btn btn-sm btn-outline-success me-1' title='Izmeni' onclick='enableRowEdit(this)'>
                                                <img src='images/edit.png' alt='Edit' style='width: 17px; height: 16px;'>
                                            </button>
                                            <button type='button' id='delInvitee' class='btn btn-sm btn-outline-danger' title='Obriši' onclick='deleteInviteeRow(this)'>
                                                <img src='images/delete.png' alt='Delete' style='width: 17px; height: 16px;'>
                                            </button>
                                            </td>";
                                            echo "</tr>";
                                        }
                                    } catch (Exception $e) {
                                        echo "Greška u povezivanju sa bazom: " . $e->getMessage();
                                    }
                                ?>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-success mt-3" id="btnSaveChanges">Sačuvaj promene</button>
                        <input type="hidden" name="deleted_invitees" id="deleted_invitees_input">
                    </form>
                    </div>
            </div>
        <div id="bgplavo">
            <div class="row">
                <div class="col-12 col-lg-4" style="margin-right: 2%;">
                    <h3>Dodaj želju</h3>
                    <form method="post" action="files/add_gift.php" class="mt-5">
                        <div class="mb-3">
                            <label for="gift_name" class="form-label">Naziv:</label>
                            <input type="text" id="gift_name" name="gift_name" class="form-control" minlength="2" maxlength="50" required>
                        </div>

                        <div class="mb-3">
                            <label for="link" class="form-label">Link:</label>
                            <input type="link" id="link" name="link" class="form-control" maxlength="254" placeholder="Link ka proizvodu">
                        </div>
                        <button type="submit" class="btn btn-primary">Dodaj</button>
                    </form>
                </div>
                <div class="col-12 col-lg-7">
                    <h4>Lista želja:</h4>
                    <div id="lista" class="row g-4">
                        <?php
                        $sql = "SELECT gift_id, name, link, reserved FROM gifts WHERE event_id = ?";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([$event_id]);

                        $gifts = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        if (count($gifts) > 0) {
                            foreach ($gifts as $row) {?>
                                <div class="col-auto">
                                    <div id="gift" class="modal-header" onclick="showGiftPopup(event, 'gift-popup', '<?php echo htmlspecialchars($row['name']); ?>', '<?php echo htmlspecialchars($row['link']); ?>', '<?php echo htmlspecialchars($row['reserved']); ?>', '<?php echo htmlspecialchars($row['gift_id']); ?>')">
                                        <h5 class="card-title fw-medium"><?php echo htmlspecialchars($row['name']); ?></h5>
                                        <div id="gift-x" class="btn-close btn-close-white" aria-label="Obriši želju" style="margin-left: 10px;"></div>
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
                    <form id="delete-form" action="files/delete_gifts.php" method="POST">
                        <input type="hidden" name="deleted_gifts" id="deleted_gifts">
                        <button id="potvrdi2" type="submit" class="btn btn-danger mt-3">Potvrdi brisanje</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
        <div id="gift-popup" class="popup">
            <div class="popup-content">
                <button class="close-btn" onclick="closePopup('gift-popup')">&#x2715;</button>
                <form action="files/update_gifts.php" method="POST">
                    <input type="hidden" name="gift_id" id="popup-id2">

                    <div class="mb-2">
                        <label for="popup-name-input2" class="form-label">Naziv:</label>
                        <input type="text" name="name" id="popup-name-input2" class="form-control" minlength="2" maxlength="50" required>
                    </div>

                    <div class="mb-2">
                        <label for="popup-link-input" class="form-label">Link:</label>
                        <input type="text" name="link" id="popup-link-input" maxlength="254" class="form-control" required>
                    </div>

                    <p id="popup-reserved" class="mt-4 fw-bold"></p>

                    <button type="submit" class="btn btn-primary mt-3">Potvrdi izmene</button>
                </form>
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







