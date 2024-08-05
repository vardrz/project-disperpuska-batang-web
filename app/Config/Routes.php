<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LoginController::index');
$routes->post('/login', 'LoginController::login');
$routes->get('/logout', 'LoginController::logout');

$routes->group('/home', static function ($routes) {
    $routes->get('/', 'HomeController::index');
    $routes->get('public', 'HomeController::public');
    $routes->get('public/delete/(:num)', 'HomeController::publicDelete/$1');

    $routes->get('admin', 'HomeController::admin');
    $routes->get('admin/delete/(:num)', 'HomeController::adminDelete/$1');
    $routes->post('admin/save', 'HomeController::adminSave');

    $routes->get('surat', 'HomeController::surat');
    $routes->get('surat/detail', 'SuratController::suratDetail');
    $routes->post('surat/save', 'SuratController::suratSave');

    $routes->get('pengembalian', 'PengembalianController::pengembalian');
    $routes->post('pengembalian/save', 'PengembalianController::pengembalianSave');
    $routes->get('pengembalian/edit/(:any)', 'PengembalianController::pengembalianEdit/$1');
    $routes->post('pengembalian/update/(:num)', 'PengembalianController::pengembalianUpdate/$1');
    $routes->get('laporan', 'LaporanController::laporan');
    $routes->get('laporan-peminjaman', 'LaporanController::laporanPeminjaman');
    $routes->get('laporan-arsip', 'LaporanController::laporanArsip');
    $routes->get('laporan/pdf/(:any)', 'LaporanController::savePDF/$1');
    $routes->get('laporan-peminjaman/pdf/(:any)', 'LaporanController::saveBorrowPDF/$1');
    $routes->get('laporan-arsip/pdf/(:any)', 'LaporanController::saveArsipPDF/$1');
});

$routes->group('/api', static function ($routes) {
    $routes->post('login-public', 'ApiAuthController::loginPublic');
    $routes->post('login-staff', 'ApiAuthController::loginStaff');
    $routes->post('register-public', 'ApiAuthController::registrationPublic');

    $routes->get('list-arsip', 'ApiArcihveController::getArsip');
    $routes->get('list-arsip/(:any)', 'ApiArcihveController::show/$1');
    $routes->post('pinjam-arsip', 'ApiArcihveController::create');
});
