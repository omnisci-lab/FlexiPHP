<?php
namespace Core\Jwt;

function base64UrlEncode(string $data): string {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64UrlDecode(string $input): string {
    $remainder = strlen($input) % 4;
    if ($remainder) {
        $padlen = 4 - $remainder;
        $input .= str_repeat('=', $padlen);
    }
    return base64_decode(strtr($input, '-_', '+/'));
}

function createJwtToken(array $payload): string {
    $header = ['alg' => 'HS256', 'typ' => 'JWT'];
    $key = 'your_secret_key';

    $header64 = base64UrlEncode(json_encode($header));
    $payload64 = base64UrlEncode(json_encode($payload));
    $signature = hash_hmac('sha256', "$header64.$payload64", $key, true);
    $signature64 = base64UrlEncode($signature);

    return "$header64.$payload64.$signature64";
}

function decodeJwtToken(string $jwt): ?array {
    [$header64, $payload64, $signature] = explode('.', $jwt);
    $payloadJson = base64UrlDecode($payload64);
    return json_decode($payloadJson, true);
}

function isValidJwtPayload(array $payload): bool {
    // Optionally kiểm tra exp, iss, v.v.
    return isset($payload['sub'], $payload['role']);
}

function getCurrentUser(): ?array {
    // Ưu tiên session
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!empty($_SESSION['user'])) {
        return $_SESSION['user'];
    }

    // Nếu không có session, thử lấy từ Authorization: Bearer <token>
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
        $payload = decodeJwtToken($token);
        if ($payload && isValidJwtPayload($payload)) {
            return ['id' => $payload['sub'], 'role' => $payload['role']];
        }
    }

    return null;
}