<?php
namespace Core\Request;

if(!defined('VALID_REQUEST')) die();

/**
 * Get a query parameter from the URL
 * @param string $queryName
 * @param int|string|null $default
 * @return int|string|null
 */
function getQuery(string $queryName, int|string|null $default = null): int|string|null
{
    if (isset($_GET[$queryName]))
        return $_GET[$queryName];

    return $default;
}

/**
 * Get a form data from POST request
 * @param string $key
 * @param int|string|null $default
 * @return int|string|null
 */
function getFormData(string $key, int|string|null $default = null): int|string|null
{
    if (isset($_POST[$key]))
        return $_POST[$key];

    return $default;
}

/**
 * Get JSON data from the request body
 * @return array
 */
function getJson(): array
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'PUT')
        return [];

    if (!isset($_SERVER['CONTENT_TYPE']) || stripos($_SERVER['CONTENT_TYPE'], 'application/json') === false)
        return [];

    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return [];
    }

    return $data;
}