<?php
namespace Core\Html;

if(!defined('VALID_REQUEST')) die();

use function Core\Common\csrfInput;

function printCsrfToken(): void {
    echo csrfInput();
}

