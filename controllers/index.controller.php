<?php

if(!defined('VALID_REQUEST')) die();

use Core\Enum as Enum;
use Core\Common as Common;
use Core\Controller as Controller;

Controller\addAction(Enum\Method::Get, '/', fn() => index());

function index(): callable {
    // Render the main view
    return Controller\sendView('index');
}