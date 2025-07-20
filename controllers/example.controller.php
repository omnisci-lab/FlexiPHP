<?php
if(!defined('VALID_REQUEST')) die();

use function Core\Common\loadService;
use function Core\Common\renderView;
use Core\Enum\Method;
use function Core\Controller\addAction;
use function Core\Controller\getFormData;

//Load file example.service.php
loadService('example');

addAction(Method::Get, '/', function() {
    renderView('example/index');
});

addAction(Method::Get, '/detail', function(){
    $id = getQuery('id');
    if(empty($id))
        return;

    $example = getExample($id);
    if($example == null){
        header('Location: /');
        exit();
    }

    renderView('example/detail', compact($example));
})