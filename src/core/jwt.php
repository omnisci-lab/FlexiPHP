<?php
namespace Core\Jwt;

function base64UrlEncode(string $data): string
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64UrlDecode(string $input): string
{
    $remainder = strlen($input) % 4;
    if ($remainder) {
        $padlen = 4 - $remainder;
        $input .= str_repeat('=', $padlen);
    }
    return base64_decode(strtr($input, '-_', '+/'));
}

function createJwtToken(array $payload, int $ttlSeconds = 3600): string
{
    if (!defined('JWT_SECRET_KEY'))
        exit('JWT secret key not set');

    if (!defined('JWT_ISSUER'))
        exit('JWT issuer not set');

    $key = JWT_SECRET_KEY;
    $now = time();
    $payload = array_merge([
        'iat' => $now,               // issued at
        'exp' => $now + $ttlSeconds, // expiry
        'iss' => JWT_ISSUER  // issuer
    ], $payload);

    $header = ['alg' => 'HS256', 'typ' => 'JWT'];

    $header64 = base64UrlEncode(json_encode($header));
    $payload64 = base64UrlEncode(json_encode($payload));
    $signature = hash_hmac('sha256', "$header64.$payload64", $key, true);
    $signature64 = base64UrlEncode($signature);

    return "$header64.$payload64.$signature64";
}

function decodeJwtToken(string $jwt): ?array
{
    if (!defined('JWT_SECRET_KEY'))
        exit('JWT secret key not set');

    if (!defined('JWT_ISSUER'))
        exit('JWT issuer not set');

    $parts = explode('.', $jwt);
    if (count($parts) !== 3) {
        return null; // Invalid structure
    }

    $key = JWT_SECRET_KEY;
    $issuer = JWT_ISSUER;

    [$header64, $payload64, $signature64] = $parts;
    $expected = base64UrlEncode(hash_hmac('sha256', "$header64.$payload64", $key, true));
    if (!hash_equals($expected, $signature64)) {
        return null; // Signature mismatch
    }

    $payloadJson = base64UrlDecode($payload64);
    $payload = json_decode($payloadJson, true);

    // Check standard claims
    if (!isset($payload['exp']) || time() > $payload['exp'])
        return null; // Expired token

    if (isset($payload['nbf']) && time() < $payload['nbf'])
        return null; // Not yet valid

    if (isset($payload['iss']) && $payload['iss'] !== $issuer)
        return null; // Wrong issuer

    return $payload;
}

function getCurrentUser(): ?array {
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
        $payload = decodeJwtToken($token);
        if ($payload) {
            return $payload;
        }
    }
    return null;
}