<?php
header("Content-Type: application/json; charset=UTF-8");

require_once '../includes/db_config.php';
require_once '../vendor/autoload.php';
require_once '../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

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

$body = json_decode(file_get_contents('php://input'), true);
$notification_id = $body['notification_id'] ?? null;

if (!$notification_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Nedostaje notification_id']);
    exit;
}

$stmt = $pdo->prepare("DELETE FROM notifications WHERE notification_id = ? AND user_id = ?");
$success = $stmt->execute([$notification_id, $user_id]);

if ($success && $stmt->rowCount() > 0) {
    http_response_code(200);
    echo json_encode(['message' => 'Notifikacija obrisana']);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Notifikacija nije pronađena']);
}
