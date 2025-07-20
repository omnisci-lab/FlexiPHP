<?php
if(!defined('VALID_REQUEST')) die();

function getExample(string $id): ?array {
    $query = 'SELECT * FROM examples WHERE id = ?';
    return Core\DB\executeQuery($query, [$id]);
}