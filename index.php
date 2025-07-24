<?php

define('VALID_REQUEST', true);

require_once './core/init.php';

use Core\Router as Router;
use Core\Enum as Enum;
use Core\Common as Common;
use Core\Controller as Controller;

// Set up routes and controllers
Router\addRoute('/example', [
    fn() => Common\loadController('example'),
    // Add more controllers as needed
]);

Router\addRoute('/api/example', [
    fn() => Common\loadController('example-api'),
    // Add more API controllers as needed
]);

// Boot the application
Core\boot();