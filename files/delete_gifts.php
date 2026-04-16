<?php
session_start();
require_once '../includes/db_config.php';

if (!isset($_SESSION['event_id'], $_SESSION['user_id'])) {
    header('Location: ../dashboard.php');
    exit;
}

if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin' && isset($_SESSION['temp_user_id']))
{
    $user_id = $_SESSION['temp_user_id'];
}
elseif($_SESSION['role'] === 'user'){
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT 1 from events WHERE user_id = ? AND event_id = ? AND status = 'active'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $_SESSION['event_id']]);
    if (!$stmt->fetch()) {
        header('Location: ../event.php');
        exit;
    }
}
else{
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleted_gifts'])) {
    $giftsToDelete = json_decode($_POST['deleted_gifts'], true);

    if (is_array($giftsToDelete) && count($giftsToDelete) > 0) {
        $placeholders = rtrim(str_repeat('?,', count($giftsToDelete)), ',');
        $sqlUpdateInvitees = "UPDATE invitees SET gift_id = NULL WHERE gift_id IN ($placeholders) AND event_id = ?";
        $stmtUpdate = $pdo->prepare($sqlUpdateInvitees);
        $stmtUpdate->execute([...$giftsToDelete,$_SESSION['event_id']]);


        $sqlDeleteGifts = "DELETE FROM gifts WHERE gift_id IN ($placeholders) AND event_id = ?";
        $stmtDelete = $pdo->prepare($sqlDeleteGifts);
        $stmtDelete->execute([...$giftsToDelete, $_SESSION['event_id']]);

        $_SESSION['success'] = "Želje su obrisane, a povezane zvanice su ažurirane.";
    }
}

header('Location: ../event.php');
exit;
