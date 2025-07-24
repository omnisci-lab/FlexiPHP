<?php
if(!defined('VALID_REQUEST')) die();

use Core\Enum as Enum;
use Core\Common as Common;
use Core\Controller as Controller;

//Load file example.service.php
Common\loadService('example');

Controller\addAction(Enum\Method::Get, '/example', fn() => index());
Controller\addAction(Enum\Method::Get, '/example/detail', fn() => detail());

function index(): callable {
    return Controller\sendView('example/index');
}

function detail(): callable {
    $id = Controller\getQuery('id');
    if(empty($id))
        return Controller\sendRedirect('/example');

    $example = getExample($id);
    if($example == null)
        return Controller\notFound();

    $example = [
        'id' => 1,
        'name' => 'Example Name',
        'description' => 'This is an example description.'
    ];

    return Controller\sendView('example/detail', compact('example'));
}