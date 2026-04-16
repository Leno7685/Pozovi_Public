<?php
$stmt = $pdo->prepare("UPDATE events set status = 'archived' WHERE user_id = ? and event_date <= NOW() and status != 'archived'");
$stmt->execute([$_SESSION['user_id']]);
?>