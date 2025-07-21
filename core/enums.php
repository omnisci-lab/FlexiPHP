<?php
namespace Core\Enum;

if(!defined('VALID_REQUEST')) die();

enum Method: string { 
    case Post = 'Post'; 
    case Get = 'Get'; 
    case Put = 'Put'; 
    case Delete = 'Delete'; 
    case Patch = 'Patch'; 
    case Head = 'Head'; 
    case Options = 'Options'; 
}