<?php
namespace Core\Controller;

use Core\Enum\Method;
use function Core\Jwt\getCurrentUser;
use function Core\Common\validateCsrfToken;

if (!defined('VALID_REQUEST'))
    die();

function mapMethod(string $method): Method
{
    switch ($method) {
        case 'GET':
            return Method::Get;
        case 'POST':
            return Method::Post;
        default:
            return Method::Get;
    }
}

function addAction(Method $method, string $path, callable $func, string $authorizeFor = null): void
{
    $reqPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if ($path !== $reqPath)
        return;

    if ($method !== mapMethod($_SERVER['REQUEST_METHOD']))
        return;

    if ($method !== Method::Get && !validateCsrfToken()) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    if ($authorizeFor !== null) {
        $currentUser = getCurrentUser();
        if (!$currentUser || $currentUser['role'] !== $authorizeFor) {
            http_response_code(403);
            exit('Forbidden: You do not have permission to access this resource.');
        }
    }

    $view = $func();
    if (is_callable($view)) {
        $view();
    } else {
        http_response_code(500);
        exit('Internal Server Error: View function did not return a callable.');
    }
}