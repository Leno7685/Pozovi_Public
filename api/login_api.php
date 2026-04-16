<?php
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . '/../includes/db_config.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/auth.php';

use Detection\MobileDetect;
$detect = new MobileDetect;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$body = json_decode(file_get_contents('php://input'), true);
$email = trim($body['email'] ?? '');
$password = $body['password'] ?? '';

if (!$email || !$password) {
    http_response_code(400);
    echo json_encode(['error' => 'Email i lozinka su obavezni']);
    exit;
}

$stmt = $pdo->prepare('SELECT user_id, password, fname, lname, role, activated, blocked FROM users WHERE email = ?');
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    http_response_code(401);
    echo json_encode(['error' => 'Ne postoji nalog sa ovom email adresom.']);
    exit;
}
if (!password_verify($password, $user['password'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Pogrešna lozinka.']);
    exit;
}
if ((int)$user['blocked'] === 1) {
    http_response_code(403);
    echo json_encode(['error' => 'Zabranjen pristup.']);
    exit;
}
if ((int)$user['activated'] === 0) {
    http_response_code(403);
    echo json_encode(['error' => 'Nalog nije aktiviran.']);
    exit;
}

$token = generate_jwt([
    'user_id' => (int)$user['user_id'],
    'email'   => $email,
    'role'    => $user['role'],
]);

$ip_address = $_SERVER['REMOTE_ADDR'];
$http_user_agent = $_SERVER['HTTP_USER_AGENT'];
$device_type = 'computer';
if ($detect->isMobile()) {
    $device_type = 'phone';
} elseif ($detect->isTablet()) {
    $device_type = 'tablet';
}
$operating_system = 'other';
if ($detect->isAndroidOS()) {
    $operating_system = 'android';
} elseif ($detect->isiOS()) {
    $operating_system = 'ios';
} elseif (strpos($http_user_agent, 'Windows') !== false) {
    $operating_system = 'windows';
}
try {
    $stmt = $pdo->prepare("INSERT INTO detects (ip_address, user_id, operating_system, device_type, http_user_agent) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$ip_address, $user['user_id'], $operating_system, $device_type, $http_user_agent]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Greška pri snimanju detekcije']);
    exit;
}

echo json_encode([
    'message' => 'Uspešna prijava.',
    'token'   => $token,
    'user'    => [
        'fname' => $user['fname'],
        'lname' => $user['lname'],
    ],
]);
