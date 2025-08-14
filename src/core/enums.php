<?php
/**
 * Chứa những enum quan trọng mà framework sẽ sử dụng
 */

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

enum HttpStatusCode: int
{
    case OK = 200;
    case CREATED = 201;
    case ACCEPTED = 202;
    case NO_CONTENT = 204;

    case BAD_REQUEST = 400;
    case UNAUTHORIZED = 401;
    case FORBIDDEN = 403;
    case NOT_FOUND = 404;
    case METHOD_NOT_ALLOWED = 405;
    case CONFLICT = 409;

    case INTERNAL_SERVER_ERROR = 500;
    case NOT_IMPLEMENTED = 501;
    case BAD_GATEWAY = 502;
    case SERVICE_UNAVAILABLE = 503;
}