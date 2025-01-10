<?php

use App\Controllers\Home;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\EventoController;
use App\Controllers\TreinoController;
use App\Controllers\CheckInController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->GET('/', [Home::class, 'index']);
    $routes->GET('user', [UserController::class, 'index']);
    $routes->GET('user/create', [UserController::class, 'create']);
    $routes->GET('user/edit/(:num)', [UserController::class, 'edit']);
    $routes->GET('user/delete/(:num)', [UserController::class, 'delete']);
    $routes->POST('user/save/(:num)', [UserController::class, 'save']);
    $routes->POST('user/save', [UserController::class, 'save']);

    $routes->GET('treino', [TreinoController::class, 'index']);
    $routes->GET('treino/create', [TreinoController::class, 'create']);
    $routes->GET('treino/edit/(:num)', [TreinoController::class, 'edit']);
    $routes->GET('treino/delete/(:num)', [TreinoController::class, 'delete']);
    $routes->POST('treino/save/(:num)', [TreinoController::class, 'save']);
    $routes->POST('treino/save', [TreinoController::class, 'save']);

    $routes->GET('evento', [EventoController::class, 'index']);
    $routes->GET('evento/create', [EventoController::class, 'create']);
    $routes->GET('evento/edit/(:num)', [EventoController::class, 'edit']);
    $routes->GET('evento/delete/(:num)', [EventoController::class, 'delete']);
    $routes->POST('evento/save/(:num)', [EventoController::class, 'save']);
    $routes->POST('evento/save', [EventoController::class, 'save']);

    $routes->GET('checkin', [CheckInController::class, 'index']);
    $routes->POST('checkin/save', [CheckInController::class, 'save']);
});

$routes->match(['get', 'post'], 'login', [AuthController::class, 'login']);
$routes->GET('logout', [AuthController::class, 'logout']);
