<?php

define('VALID_REQUEST', true);

require_once './core/init.php';

Core\setControllers(
    fn() => loadControllers('example')
);