<?php
if(!defined('VALID_REQUEST')) die();

use Core\Enum as Enum;
use Core\Common as Common;
use Core\Controller as Controller;
use Core\Response as Response;
use Core\Request as Request;

//Load file example.service.php
Common\loadService('example');

Controller\addAction(Enum\Method::Get, '/example/list', fn() => index());
Controller\addAction(Enum\Method::Get, '/example/detail', fn() => detail());

function index(): callable {
    return Response\sendView('example/index');
}

function detail(): callable {
    $id = Request\getQuery('id');
    if(empty($id))
        return Response\sendRedirect('/example');

    $example = getExample($id);
    if($example == null)
        return Response\notFound();

    $example = [
        'id' => 1,
        'name' => 'Example Name',
        'description' => 'This is an example description.'
    ];

    return Response\sendView('example/detail', compact('example'));
}