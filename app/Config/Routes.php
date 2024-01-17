<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LoginController::index');
$routes->post('/login', 'LoginController::login');

$routes->group('/api', static function($routes){
    $routes->post('login-public', 'AuthController::loginPublic');
    $routes->post('login-staff', 'AuthController::loginStaff');
});