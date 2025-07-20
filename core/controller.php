<?php
namespace Core\Controller;

use Core\Enum\Method;
use Core\Common as Common;

if(!defined('VALID_REQUEST')) die();

function getQuery(string $queryName, int|string|null $default = null): int|string|null {
    if(isset($_GET[$queryName]))
        return $_GET[$queryName];

    return $default;
}

function getFormData(string $key, int|string|null $default = null) : int|string|null {
    if(isset($_POST[$key]))
        return $_POST[$key];

    return $default;
}

function mapMethod(string $method): Method {
    switch ($method){
        case 'GET': return Method::Get;
        case 'POST': return Method::Post;
        default: return Method::Get;
    }
}

function addAction(Method $method, string $path, callable $func): void {
    $reqPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    if ($method === mapMethod($_SERVER['REQUEST_METHOD']) && $path === $reqPath) {
        if($method !== Method::Get && !Common\validateCsrfToken()){
            http_response_code(403);
            exit('Invalid CSRF token');
        }

        $func();
    }
}