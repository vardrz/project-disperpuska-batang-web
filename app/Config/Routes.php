<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LoginController::index');
$routes->post('/login', 'LoginController::login');
$routes->get('/logout', 'LoginController::logout');

$routes->group('/home', static function($routes){
    $routes->get('/', 'HomeController::index');
    $routes->get('public', 'HomeController::public');
    $routes->get('public/delete/(:num)', 'HomeController::publicDelete/$1');

    $routes->get('admin', 'HomeController::admin');
    $routes->get('admin/delete/(:num)', 'HomeController::adminDelete/$1');
    $routes->post('admin/save', 'HomeController::adminSave');
    
    $routes->get('surat', 'HomeController::surat');
    $routes->get('surat/detail', 'SuratController::suratDetail');
    $routes->post('surat/save', 'SuratController::suratSave');
});

$routes->group('/api', static function($routes){
    $routes->post('login-public', 'AuthController::loginPublic');
    $routes->post('login-staff', 'AuthController::loginStaff');
    $routes->post('register-public', 'AuthController::registrationPublic');

    $routes->get('search-arsip', 'ArchiveController::findArchived');
    $routes->post('borrow-arsip', 'ArchiveController::leanArchive');
});
