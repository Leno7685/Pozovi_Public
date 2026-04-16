<?php
header("Content-Type: application/json; charset=UTF-8");

require_once '../includes/db_config.php';
require_once '../vendor/autoload.php';
require_once '../includes/auth.php';

$jwt = get_bearer_token();
if (!$jwt) {
    http_response_code(401);
    echo json_encode(['error' => 'Nedostaje token']);
    exit;
}

$decoded = validate_jwt($jwt);
if (!$decoded) {
    http_response_code(401);
    echo json_encode(['error' => 'Neispravan ili istekao token']);
    exit;
}

$user_id = $decoded->data->user_id ?? null;
if (!$user_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Nedostaje user_id u tokenu']);
    exit;
}

$archived = isset($_GET['archived']) && $_GET['archived'] == 1;

if ($archived) {
    $sql = "SELECT event_id, title, description, event_date, status FROM events WHERE user_id = ? AND status = 'archived'";
} else {
    $sql = "SELECT event_id, title, description, event_date, status FROM events WHERE user_id = ? AND status != 'archived'";
}

$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT notification_id, title, text FROM notifications WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

$response = [
    "events" => $events,
    "notifications" => $notifications
];

http_response_code(200);
echo json_encode($response);
