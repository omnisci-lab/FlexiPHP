<?php
namespace Core\DB;

use \PDO;

if(!defined('VALID_REQUEST')) die();

function InitPDO(): PDO {
    $pdo = null;
    if(DB_PROVIDER === 'sqlite')
        $pdo = new PDO('sqlite:' . WEB_DIR . '/sqlite/database.sqlite');
    else if (DB_PROVIDER === 'mysql')
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';port=' . DB_PORT, DB_USER, DB_PWD);
    else
        exit('Unsupported DB_PROVIDER: ' . DB_PROVIDER);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $pdo;
}

global $pdo;
$pdo = InitPDO();

function executeNonQuery(string $query, array $params = []): bool {
    global $pdo;
    $stmt = $pdo->prepare($query);
    return $stmt->execute($params);
}

function executeQueryAll(string $query, array $params = []): array {
    global $pdo;
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

    return $stmt->fetchAll();
}

function executeQuery(string $query, array $params = []): ?array {
    global $pdo;
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

    return $stmt->fetch() ?: null;
}

/**
 * @return (int|string)
 */

function executeScalar(string $query, array $params = []): int|string {
    global $pdo;
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

    return $stmt->fetchColumn();
}