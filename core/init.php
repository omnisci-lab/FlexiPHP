<?php
namespace Core;

if(!defined('VALID_REQUEST')) die();

define('WEB_DIR', dirname(__DIR__));

require_once './config.php';

if(!defined('DB_HOST') || !defined('DB_PORT') || !defined('DB_USER') || !defined('DB_PWD'))
    exit('Required database configuration is missing.');

require_once './core/enums.php';
require_once './core/string.php';
require_once './core/router.php';
require_once './core/db.php';
require_once './core/common.php';
require_once './core/controller.php';

use Core\Router;
use function Core\Str\startsWith;

function boot(): void {
    global $routes;
    $reqPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    // Load routes
    foreach ($routes as $route) {
        $path = $route['path'];
        $action = $route['action'];

        // Check if the request path matches the route
        if (startsWith($reqPath, $path) || $reqPath === $path)
            $action();
    }
}