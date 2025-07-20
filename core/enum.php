<?php
namespace Core\Enum;

if(!defined('VALID_REQUEST')) die();

enum Method: string { case Post = 'Post'; case Get = 'Get';}