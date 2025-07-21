<?php
namespace Core\Controller;

use Core\Enum\Method;
use function Core\Common\renderView;

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
        if($method !== Method::Get && !Core\Common\validateCsrfToken()){
            http_response_code(403);
            exit('Invalid CSRF token');
        }

        $view = $func();
        if(is_callable($view)){
            $view();
        } else {
            http_response_code(500);
            exit('Internal Server Error: View function did not return a callable.');
        }
    }
}

function sendRedirect(string $url): callable {
    $fn = function() use ($url) {
        header("Location: {$url}");
        exit();
    };

    return $fn;
}

function notFound(): callable {
    $fn = function() {
        http_response_code(404);
        exit('404 Not Found');
    };

    return $fn;
}

function sendView(string $viewName, array $data = []): callable {
    $fn = function() use ($viewName, $data) {
        http_response_code(200);
        renderView($viewName, $data);
    };

    return $fn;
}

function sendJson(array $data): callable {
    $fn = function() use ($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    };

    return $fn;
}