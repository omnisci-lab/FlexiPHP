<?php
namespace Core\Common;

if(!defined('VALID_REQUEST')) die();

function generateCsrfToken(): string {
    if (session_status() !== PHP_SESSION_ACTIVE) 
        session_start();

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function validateCsrfToken(): bool {
    if (session_status() !== PHP_SESSION_ACTIVE) 
        session_start();

    $token = $_POST['csrf_token'] ?? '';
    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token))
        return false;

    return true;
}

function csrfInput(): string {
    $token = generateCsrfToken();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
}

function renderView(string $viewName, array $data = []): void {
    extract($data);

    $viewPath = WEB_DIR . "/views/{$viewName}.view.php";
    require_once WEB_DIR . "/views/layouts/layout.view.php";
}

function loadService(string $serviceName): void {
    require_once WEB_DIR . "/services/{$serviceName}.service.php";
}

function loadController(string $controllerName): void {
    require_once WEB_DIR . "/controllers/{$controllerName}.controller.php";
}