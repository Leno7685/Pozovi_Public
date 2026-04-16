<?php
session_start();
require_once 'includes/db_config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'GET' && !isset($_GET['token']) && !isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}
$token = $_GET['token'];
$event_id = $_GET['id'];

$stmt = $pdo->prepare("SELECT name, invitee_id, gift_id, attendance FROM invitees WHERE event_id = ? AND token = ?");
$stmt->execute([$event_id,$token]);
$invitee = $stmt->fetch();
if (!$invitee) {
    header('Location: index.php');
    exit;
}
$invitee_name = $invitee['name'];
$_SESSION['invitee_id'] = $invitee['invitee_id'];
$gift_id = $invitee['gift_id'];
$attendance = $invitee['attendance'];

$stmt = $pdo->prepare("SELECT title, description, event_date, location, status, fname, lname FROM events JOIN users ON events.user_id = users.user_id WHERE event_id = ?");
$stmt->execute([$event_id]);
$rez = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pozivnica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css.css">
</head>
<body class="bg6">
<?php include 'templates/header.php'; ?>

    <?php if($rez['status'] == 'active'): ?>
        <div class="col-12 col-xl-11 col-xxl-10 mt-5 bgplavo3">
            <!--<h5 style="word-break: break-word; padding:17px; color:#071d59;"><?php// echo "Zdravo " . htmlspecialchars($invitee_name) . "! " . htmlspecialchars($rez['fname']) . " " . htmlspecialchars($rez['lname']) . " vas poziva na događaj \"" . htmlspecialchars($rez['title']) . "\" koji se održava: " . htmlspecialchars($rez['event_date']); ?></h5>
            <hr>-->
            <h5 class="text-center mb-3" style="font-size: 27px;"><?php echo htmlspecialchars($rez['title']) ?></h5>
            <div class="row">
                <div class="col-12 col-lg-6" style="border-right: 1px solid rgba(167,203,255,0.65); border-top: 1px solid rgba(167,203,255,0.65);padding-top:1%;">
                    <p class="text-muted text-center mb-5">Informacije o događaju</p>
                    <h5 class="mt-4" style="font-size: 19px; margin-left: 1%"><?php echo "<span class='text-muted'>Organizator: </span>" . htmlspecialchars($rez['fname']) . " " . htmlspecialchars($rez['lname']); ?></h5>
                    <h5 class="mt-4" style="font-size: 19px; margin-left: 1%"><?php echo "<span class='text-muted'>Naziv: </span>" . htmlspecialchars($rez['title']); ?></h5>
                    <?php if($rez['location'] != NULL): ?>
                        <h5 class="mt-4" style="font-size: 19px; margin-left: 1%"><?php echo "<span class='text-muted'>Lokacija: </span>" . htmlspecialchars($rez['location']); ?></h5>
                    <?php endif; ?>
                    <h5 class="mt-4" style="font-size: 19px; margin-left: 1%"><?php echo "<span class='text-muted'>Datum i vreme: </span>" . htmlspecialchars($rez['event_date']); ?></h5>
                    <?php if($rez['description'] != NULL): ?>
                        <div class="mt-4" style="font-size: 19px; margin-left: 1%"><?php echo "Opis:"; ?></div>
                        <div class="mt-1 text-muted notificationText" style="margin-left: 1%; background-color: #ccdaff; padding:1.7%;"><?php echo htmlspecialchars($rez['description']); ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-12 col-lg-6" style="border-top: 1px solid rgba(167,203,255,0.65);padding-top:1%;">
                    <p class="text-muted text-center mb-5">Vaš odgovor</p>
                    <form class="ms-4" action="files/invitation_submit.php" method="post">
                        <label for="attendanceFilter" class="form-label">Status:</label>
                        <select id="attendanceFilter" name="attendance" class="form-select" style="width: 200px;">
                            <option value="dolazi">Dolazim</option>
                            <option value="ne dolazi">Ne dolazim</option>
                            <option value="možda dolazi">Možda dolazim</option>
                        </select>
                        <?php
                            $stmt = $pdo->prepare("SELECT gift_id, name, link FROM gifts WHERE event_id = ? AND reserved = 'available'");
                            $stmt->execute([$event_id]);
                            $gifts = $stmt->fetchAll();

                            if(!empty($gifts)):
                        ?>
                            <label for="giftTable" class="form- mt-4">Lista poklona:</label>
                            <div id="giftTable">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Odaberi</th>
                                        <th>Naziv</th>
                                        <th>Link</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($gift_id !== null){
                                            $stmt = $pdo->prepare("SELECT name, link FROM gifts WHERE gift_id = ?");
                                            $stmt->execute([$gift_id]);
                                            $selected_gift = $stmt->fetch();
                                            $selected_gift_name = htmlspecialchars($selected_gift['name']);
                                            $selected_gift_link = htmlspecialchars($selected_gift['link']);
                                            echo "
                                            <tr onclick='chooseGift(this,$gift_id)' style='background-color:#c8d8fa; outline:2px solid #b0c2ea;'>
                                                <td><img src='images/gift.png' alt='poklon' style='height: 20px; width: 20px;display:inline;'></td>
                                                <td>$selected_gift_name</td>
                                                <td>$selected_gift_link</td>
                                            </tr>";
                                        }
                                        ?>
                                        <?php
                                            foreach ($gifts as $gift):
                                        ?>
                                            <tr onclick="chooseGift(this,<?php echo htmlspecialchars($gift['gift_id']); ?>)">
                                                <td><img src="images/gift.png" alt="poklon" style="height: 20px; width: 20px;display:none;"></td>
                                                <td><?php echo htmlspecialchars($gift['name']);?></td>
                                                <td><?php echo htmlspecialchars($gift['link']);?></td>
                                            </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                                </div>
                        <?php endif;?>
                        <input type="hidden" name="selected_gift_id">
                        <input type="hidden" name="token" value="<?php echo $token; ?>">
                        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                        <button type="submit" class="btn btn-primary mt-5" title="Ukoliko odaberete poklon, taj poklon se neće biti dostupan drugim zvanicama">Potvrdi izmene</button>
                    </form>
                </div>
            </div>
        </div>
    <?php elseif($rez['status'] == 'archived'): ?>
        <div class="d-flex justify-content-center"><h4 class="alert alert-dark text-center ps-5 pe-5"><p>Ovaj događaj više nije aktivan!</p></h4></div>
    <?php elseif($rez['status'] == 'blocked'): ?>
        <div class="d-flex justify-content-center"><h4 class="alert alert-danger text-center ps-5 pe-5"><p>Ovaj događaj trenutno nije dostupan!</p></h4></div>
    <?php endif;?>


<?php include 'templates/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('attendanceFilter').value = "<?php echo $attendance; ?>";
    });

    function chooseGift(tr,gift_id){
        let rows = document.querySelectorAll("#giftTable tbody tr");
        let select = "select";
        let img = tr.querySelector('img');
        if (img) {
            if (img.style.display === "inline") {
                select = "unselect";
            }
            else if(img.style.display === "none"){
                select = "select";
            }
        }
        rows.forEach(row => {
            row.style.backgroundColor = "";
            row.style.outline = "";
            let img = row.querySelector('img');
            if (img) img.style.display = "none";
        });

        if (img) {
            if(select === "select"){
                tr.style.backgroundColor = "#c8d8fa";
                tr.style.outline = "2px solid #b0c2ea";
                img.style.display = "inline";
                document.querySelector('input[name="selected_gift_id"]').value = gift_id;
            }
            if(select === "unselect"){
                tr.style.backgroundColor = "";
                tr.style.outline = "";
                img.style.display = "none";
                document.querySelector('input[name="selected_gift_id"]').value = "none";
            }
        }
    }

</script>
</body>
</html>
