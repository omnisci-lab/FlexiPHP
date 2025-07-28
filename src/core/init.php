<?php
namespace Core;

if(!defined('VALID_REQUEST')) die();

define('WEB_DIR', dirname(__DIR__));

require_once './config.php';

if(!defined('DB_PROVIDER') || !in_array(DB_PROVIDER, ['mysql', 'sqlite']))
    exit('Invalid or missing database provider configuration.');

if(DB_PROVIDER === 'mysql') {
    if(!defined('DB_HOST') || !defined('DB_NAME') || !defined('DB_USER') || !defined('DB_PWD'))
        exit('Required database configuration is missing.');

    if(!defined('DB_PORT'))
        define('DB_PORT', '3306'); // Default MySQL port
}

require_once './core/enums.php';
require_once './core/string.php';
require_once './core/router.php';
require_once './core/common.php';
require_once './core/html.php';
require_once './core/controller.php';
require_once './core/db.php';
require_once './core/jwt.php';
require_once './core/authenticator.php';
require_once './core/authorizer.php';

use function Core\Str\startsWith;

function boot(): void {
    global $routes;
    $reqPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $hasMatchedPath = false;

    // Load routes
    foreach ($routes as $route) {
        $path = $route['path'];
        $action = $route['action'];
 
        // If the path is exactly '/', we treat it as a special case
        if($path === '/'){
            if($reqPath === '/'){
                $action();
                $hasMatchedPath = true; 
                continue;
            } else
                continue; 
        }

        // Check if the request path matches the route
        if (startsWith($reqPath, $path) || $reqPath === $path) {
            $action();
            $hasMatchedPath = true;
        }
    }

    if(!$hasMatchedPath) {
        // No route matched, return 404
        http_response_code(404);
        exit('404 Not Found');
    }
}