<?php
namespace Core\Str;

if(!defined('VALID_REQUEST')) die();

/**
 * Loại bỏ ký tự nguy hiểm, tránh XSS đơn giản
 * Remove dangerous characters to prevent simple XSS attacks
 */
function sanitize(string $input): string {
    return htmlspecialchars($input, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Kiểm tra chuỗi $haystack có bắt đầu bằng $needle không
 * Check if the string $haystack starts with $needle
 */
function startsWith(string $haystack, string $needle): bool {
    return strncmp($haystack, $needle, strlen($needle)) === 0;
}

/**
 * Kiểm tra chuỗi $haystack có kết thúc bằng $needle không
 * Check if the string $haystack ends with $needle
 */
function endsWith(string $haystack, string $needle): bool {
    $len = strlen($needle);
    if ($len === 0) return true;
    return substr($haystack, -$len) === $needle;
}

/**
 * Xóa khoảng trắng đầu/cuối và giữa chuỗi thành 1 dấu cách
 * Trim whitespace from the beginning, end, and between words in a string
 * and replace multiple spaces with a single space
 */
function trimAll(string $str): string {
    $str = trim($str);
    $str = preg_replace('/\s+/', ' ', $str);
    return $str;
}