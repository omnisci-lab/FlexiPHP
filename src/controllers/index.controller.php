<?php

if(!defined('VALID_REQUEST')) die();

use Core\Enum as Enum;
use Core\Common as Common;
use Core\Controller as Controller;

Controller\addAction(Enum\Method::Get, '/', fn() => index());
Controller\addAction(Enum\Method::Get, '/login', fn() => login());
Controller\addAction(Enum\Method::Post, '/login', fn() => submitLogin());

function index(): callable {
    // Render the main view
    return Controller\sendView('index');
}

function login(): callable {
    // Render the login view
    return Controller\sendView('login');
}

function submitLogin(): callable {
    $username = Controller\getFormData('username');
    $password = Controller\getFormData('password');
    
    if(empty($username) || empty($password)) {
        $message = 'username and password are required';
        return Controller\sendView('login', compact('message'));
    }

    if($username == 'admin' && $password == 'password') {
        // Simulate successful login
        $_SESSION['user'] = ['username' => $username];
        return Controller\sendRedirect('/index');
    }

    $message = 'Invalid username or password';
    return Controller\sendView('login', compact('message'));
}