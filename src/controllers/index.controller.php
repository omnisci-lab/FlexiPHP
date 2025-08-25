<?php

if(!defined('VALID_REQUEST')) die();

use Core\Enum as Enum;
use Core\Controller as Controller;
use Core\Response as Response;
use Core\Request as Request;
use Core\Authenticator as Authenticator;

Controller\addAction(Enum\Method::Get, '/', fn() => index());
Controller\addAction(Enum\Method::Get, '/login', fn() => login());
Controller\addAction(Enum\Method::Post, '/login', fn() => submitLogin());

function index(): callable {
    // Render the main view
    return Response\sendView('index');
}

function login(): callable {
    // Render the login view
    return Response\sendView('login');
}

function submitLogin(): callable {
    $username = Request\getFormData('username');
    $password = Request\getFormData('password');
    
    if(empty($username) || empty($password)) {
        $message = 'username and password are required';
        return Response\sendView('login', compact('message'));
    }

    if($username == 'admin' && $password == 'password') {
        // Simulate successful login
        Authenticator\auth_login($username);
        return Response\sendRedirect('/');
    }

    $message = 'Invalid username or password';
    return Response\sendView('login', compact('message'));
}