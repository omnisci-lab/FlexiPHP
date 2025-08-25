<?php
if(!defined('VALID_REQUEST')) die();

use Core\Enum as Enum;
use Core\Common as Common;
use Core\Controller as Controller;
use Core\Response as Response;
use Core\Request as Request;

Common\loadService('example');

Controller\addAction(Enum\Method::Get, '/api/example/list', fn() => index());
Controller\addAction(Enum\Method::Get,'/api/example/detail', fn() => getDetail());
Controller\addAction(Enum\Method::Get,'/api/example/detail-text', fn() => getDetailText());

function index(): callable {
    $examples = getExampleList();

    return Response\sendJson($examples);
}

function getDetail(): callable {
    $id = Request\getQuery('id');
    if(empty($id))
        return Response\sendJson(['message' => 'ID is required'], Enum\HttpStatusCode::BAD_REQUEST);

    $example = getExample($id);
    if($example == null)
        return Response\sendJson(['message' => 'Example not found'], Enum\HttpStatusCode::NOT_FOUND);

    return Response\sendJson(['data' => $example, 'message' => 'Found']);
}

function getDetailText(): callable {
    $id = Request\getQuery('id');
    if(empty($id))
        return Response\sendText('ID is required', Enum\HttpStatusCode::BAD_REQUEST);

    $example = getExample($id);
    if($example == null)
        return Response\sendText('Example not found', Enum\HttpStatusCode::NOT_FOUND);

    return Response\sendText("Example ID: {$example['id']}\nName: {$example['name']}\nDescription: {$example['description']}");
}

function create(): callable {
    $data = Request\getJson();
    if(empty($data['name']) || empty($data['description'])) {
        return Response\sendJson(['message' => 'Name and description are required'], Enum\HttpStatusCode::BAD_REQUEST);
    }

    // Insert the data into the database

    return Response\sendJson(['message' => 'Example created successfully'], Enum\HttpStatusCode::CREATED);
}