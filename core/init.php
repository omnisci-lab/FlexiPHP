<?php
namespace Core;

if(!defined('VALID_REQUEST')) die();

require_once './config.php';

if(!defined('DB_HOST') || !defined('DB_PORT') || !defined('DB_USER') || !defined('DB_PWD'))
    exit('');

require_once './core/db.php';
require_once './core/common.php';
require_once './core/enums.php';
require_once './core/controller.php';

use Core\Common\loadControllers();

// Load các controller
function setControllers(callable $callbacks): void {
    foreach ($callbacks as $callback)
        $callback();
}