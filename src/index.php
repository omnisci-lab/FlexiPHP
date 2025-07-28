<?php

define('VALID_REQUEST', true);

require_once './core/init.php';

use Core\Router as Router;
use Core\Common as Common;

// Set up routes and controllers
Router\addRoute('/example', [
    fn() => Common\loadController('example'),
    // Add more controllers as needed
]);

Router\addRoute('/api/example', [
    fn() => Common\loadController('example-api'),
    // Add more API controllers as needed
]);

Router\addRoute('/', [
    fn() => Common\loadController('index')
]);

Router\addRoute('/login', [
    fn() => Common\loadController('index')
]);

// Boot the application
Core\boot();