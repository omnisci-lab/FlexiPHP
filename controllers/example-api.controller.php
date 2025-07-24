<?php
if(!defined('VALID_REQUEST')) die();

use Core\Enum as Enum;
use Core\Common as Common;
use Core\Controller as Controller;

Common\loadService('example');

Controller\addAction(Enum\Method::Get, '/api/example/list', fn() => index());
Controller\addAction(Enum\Method::Get,'/api/example/detail', fn() => getDetail());

function index(): callable {
    $examples = getExampleList();

    return Controller\sendJson($examples);
}

function getDetail(): callable {
    $id = Controller\getQuery('id');
    if(empty($id))
        return Controller\sendJson(['message' => 'ID is required'], Enum\HttpStatusCode::BAD_REQUEST);

    $example = getExample($id);
    if($example == null)
        return Controller\sendJson(['message' => 'Example not found'], Enum\HttpStatusCode::NOT_FOUND);

    return Controller\sendJson(['data' => $example, 'message' => 'Found']);
}

function create(): callable {
    $data = Controller\getJson();
    if(empty($data['name']) || empty($data['description'])) {
        return Controller\sendJson(['message' => 'Name and description are required'], Enum\HttpStatusCode::BAD_REQUEST);
    }

    // Insert the data into the database

    return Controller\sendJson(['message' => 'Example created successfully'], Enum\HttpStatusCode::CREATED);
}