<?php
namespace Core\Router;

if(!defined('VALID_REQUEST')) die();

$routes = [];

/**
 * @param callable[] $actions
 */
function addRoute(string $path, array $actions): void {
    global $routes;
    foreach ($actions as $action) {
        if (!is_callable($action))
            exit("Action for route '$path' must be callable.");
        
        $routes[] = [
            'path' => $path,
            'action' => $action
        ];
    }
}