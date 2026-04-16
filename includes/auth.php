<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

const JWT_SECRET = 'PRIVATE';
const JWT_ISSUER = 'https://leon.stud.vts.su.ac.rs/Pozovi';
const JWT_TTL = 5000;

function generate_jwt(array $data): string {
    $now = time();
    $payload = [
        'iss'  => JWT_ISSUER,
        'iat'  => $now,
        'nbf'  => $now,
        'exp'  => $now + JWT_TTL,
        'data' => $data,
    ];
    return JWT::encode($payload, JWT_SECRET, 'HS256');
}

function validate_jwt(string $jwt) {
    try {
        $decoded = JWT::decode($jwt, new Key(JWT_SECRET, 'HS256'));

        if (!isset($decoded->iss) || $decoded->iss !== JWT_ISSUER) {
            return false;
        }

        return $decoded;
    } catch (Exception $e) {
        return false;
    }
}

function get_bearer_token(): ?string {
    $headers = function_exists('apache_request_headers')
        ? apache_request_headers()
        : (function_exists('getallheaders') ? getallheaders() : []);

    if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $headers['Authorization'] = $_SERVER['HTTP_AUTHORIZATION'];
    } elseif (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
        $headers['Authorization'] = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
    }

    $auth = $headers['Authorization'] ?? $headers['authorization'] ?? null;
    if ($auth && preg_match('/Bearer\s+(\S+)/', $auth, $m)) {
        return $m[1];
    }
    return null;
}
