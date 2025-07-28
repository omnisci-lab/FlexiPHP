<?php
if(!defined('VALID_REQUEST')) die();

use function Core\DB\executeQuery;
use function Core\DB\executeQueryAll;

function getExample(string $id): ?array {
    $query = 'SELECT * FROM examples WHERE id = ?';
    return executeQuery($query, [$id]);
}

function getExampleList(): array {
    $query = 'SELECT * FROM examples';
    return executeQueryAll($query);
}