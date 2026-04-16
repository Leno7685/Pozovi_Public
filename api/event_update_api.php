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
    echo json_encode(['error' => 'Nedostaje user_id']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Metoda nije dozvoljena']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$event_id = $data['event_id'] ?? null;
$title = $data['title'] ?? null;
$description = $data['description'] ?? null;
$event_date = $data['event_date'] ?? null;
$location = $data['location'] ?? null;

if (!$event_id || !$title || !$event_date) {
    http_response_code(400);
    echo json_encode(['error' => 'Nedostaju obavezna polja']);
    exit;
}

$sql = "SELECT event_id FROM events WHERE event_id = ? AND user_id = ? and status='active'";
$stmt = $pdo->prepare($sql);
$stmt->execute([$event_id, $user_id]);
if (!$stmt->fetch()) {
    http_response_code(403);
    echo json_encode(['error' => 'Nije moguće izmeniti ovaj događaj']);
    exit;
}

$sql = "UPDATE events SET title = ?, description = ?, event_date = ?, location = ? WHERE event_id = ?";
$stmt = $pdo->prepare($sql);
$ok = $stmt->execute([$title, $description, $event_date, $location, $event_id]);

if ($ok) {
    echo json_encode(['success' => true, 'message' => 'Događaj uspešno izmenjen']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Neuspešna izmena']);
}
