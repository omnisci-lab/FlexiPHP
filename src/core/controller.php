<?php
namespace Core\Controller;

use Core\Enum\Method;
use Core\Enum\HttpStatusCode;
use function Core\Jwt\getCurrentUser;
use function Core\Common\validateCsrfToken;
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

function getJson(): array
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'PUT')
        return [];

    if (!isset($_SERVER['CONTENT_TYPE']) || stripos($_SERVER['CONTENT_TYPE'], 'application/json') === false)
       return [];

    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return [];
    }

    return $data;
}

function mapMethod(string $method): Method {
    switch ($method){
        case 'GET': return Method::Get;
        case 'POST': return Method::Post;
        default: return Method::Get;
    }
}

function addAction(Method $method, string $path, callable $func, string $authorizeFor = null): void {
    $reqPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if($path !== $reqPath)
        return;

    if($method !== mapMethod($_SERVER['REQUEST_METHOD']))
        return;

    if($method !== Method::Get && !validateCsrfToken()){
            http_response_code(403);
            exit('Invalid CSRF token');
    }

    if($authorizeFor !== null) {
        $currentUser = getCurrentUser();
        if (!$currentUser || $currentUser['role'] !== $authorizeFor) {
            http_response_code(403);
            exit('Forbidden: You do not have permission to access this resource.');
        }
    }

    $view = $func();
    if(is_callable($view)){
        $view();
    } else {
        http_response_code(500);
        exit('Internal Server Error: View function did not return a callable.');
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

function sendJson(array $data, HttpStatusCode $statusCode = HttpStatusCode::OK): callable {
    $fn = function() use ($data, $statusCode) {
        header('Content-Type: application/json');
        http_response_code($statusCode->value);
        echo json_encode($data);
    };

    return $fn;
}

function sendText(string $text, HttpStatusCode $statusCode = HttpStatusCode::OK): callable {
    $fn = function() use ($text, $statusCode) {
        header('Content-Type: text/plain');
        http_response_code($statusCode->value);
        echo $text;
    };

    return $fn;
}

//Đang thử nghiệm
function sendFile(string $filePath, string $fileName = null): callable {
    $fn = function() use ($filePath, $fileName) {
        if(!file_exists($filePath)){
            http_response_code(404);
            exit('File not found');
        }

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . ($fileName ?? basename($filePath)) . '"');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
    };

    return $fn;
}