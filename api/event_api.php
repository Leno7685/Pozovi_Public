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

$event_id = $_GET['id'] ?? null;
if (!$event_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Nedostaje event_id']);
    exit;
}


$sql = "SELECT * FROM events WHERE event_id = ? AND user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$event_id, $user_id]);

$event = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$event) {
    http_response_code(404);
    echo json_encode(['error' => 'Događaj nije pronađen']);
    exit;
}

$sql = "SELECT invitee_id, name, email, attendance, created_at FROM invitees WHERE event_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$event_id]);
$invitees = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT gift_id, name, link, reserved FROM gifts WHERE event_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$event_id]);
$gifts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$response = [
    "event" => $event,
    "invitees" => $invitees,
    "gifts" => $gifts
];

http_response_code(200);
echo json_encode($response);
