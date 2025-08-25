<?php
namespace Core\Response;

use Core\Enum\HttpStatusCode;
use function Core\Common\renderView;

if(!defined('VALID_REQUEST')) die();

function sendRedirect(string $url): callable
{
    $fn = function () use ($url) {
        header("Location: {$url}");
        exit();
    };

    return $fn;
}

function notFound(): callable
{
    $fn = function () {
        http_response_code(404);
        exit('404 Not Found');
    };

    return $fn;
}

function sendView(string $viewName, array $data = []): callable
{
    $fn = function () use ($viewName, $data) {
        http_response_code(200);
        renderView($viewName, $data);
    };

    return $fn;
}

function sendJson(array $data, HttpStatusCode $statusCode = HttpStatusCode::OK): callable
{
    $fn = function () use ($data, $statusCode) {
        header('Content-Type: application/json');
        http_response_code($statusCode->value);
        echo json_encode($data);
    };

    return $fn;
}

function sendText(string $text, HttpStatusCode $statusCode = HttpStatusCode::OK): callable
{
    $fn = function () use ($text, $statusCode) {
        header('Content-Type: text/plain');
        http_response_code($statusCode->value);
        echo $text;
    };

    return $fn;
}

//Đang thử nghiệm
function sendFile(string $filePath, string $fileName = null): callable
{
    $fn = function () use ($filePath, $fileName) {
        if (!file_exists($filePath)) {
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