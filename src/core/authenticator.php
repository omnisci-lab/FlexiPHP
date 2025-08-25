<?php
namespace Core\Authenticator;

if(!defined('VALID_REQUEST')) die();

/**
 * Login user: set signed cookie
 */
function auth_login(int|string $userId, int $expirySeconds = AUTH_DEFAULT_EXPIRY): void {
    $expiry = time() + $expirySeconds;
    $data = "$userId|$expiry";
    $signature = hash_hmac('sha256', $data, AUTH_SECRET_KEY);
    $cookieValue = base64_encode($data . '|' . $signature);

    setcookie(
        AUTH_COOKIE_NAME,
        $cookieValue,
        $expiry,
        '/',
        '',
        true,   // secure
        true    // httponly
    );
}

/**
 * Logout user: xóa cookie
 */
function auth_logout(): void {
    setcookie(AUTH_COOKIE_NAME, '', time() - 3600, '/');
}

/**
 * Lấy userId hiện tại, null nếu chưa login
 */
function auth_user(): int|string|null {
    if (empty($_COOKIE[AUTH_COOKIE_NAME])) {
        return null;
    }

    $cookie = base64_decode($_COOKIE[AUTH_COOKIE_NAME]);
    [$userId, $expiry, $signature] = explode('|', $cookie);

    $data = "$userId|$expiry";
    $expectedSig = hash_hmac('sha256', $data, AUTH_SECRET_KEY);

    if (hash_equals($expectedSig, $signature) && ((int)$expiry > time())) {
        return $userId;
    }

    // cookie giả mạo hoặc hết hạn
    auth_logout();
    return null;
}

/**
 * Kiểm tra user đã login chưa
 */
function auth_is_logged_in(): bool {
    return auth_user() !== null;
}