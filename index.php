<?php

define('VALID_REQUEST', true);

require_once './config.php';
require_once './core/db.php';
require_once './core/common.php';
require_once './core/enums.php';
require_once './core/controller.php';

Core\Includer\loadControllers('example');