<?php
namespace Core\DB;

if(!defined('VALID_REQUEST')) die();

function InitPDO(): \PDO {
    $pdo = new \PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';port=' . DB_PORT, DB_USER, DB_PWD);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

    return $pdo;
}

function executeNonQuery(string $query, array $params = []): bool {
    $pdo = InitPDO();
    $stmt = $pdo->prepare($query);
    return $stmt->execute($params);
}

function executeQueryAll(string $query, array $params = []): array {
    $pdo = InitPDO();
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

    return $stmt->fetchAll();
}

function executeQuery(string $query, array $params = []): ?array {
    $pdo = InitPDO();
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

    return $stmt->fetch() ?: null;
}

/**
 * @return (int|string)
 */

function executeScalar(string $query, array $params = []): mixed {
    $pdo = InitPDO();
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

    return $stmt->fetchColumn();
}