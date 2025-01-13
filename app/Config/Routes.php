<?php

use App\Controllers\Home;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\ConfigController;
use App\Controllers\EventoController;
use App\Controllers\NormasController;
use App\Controllers\TreinoController;
use App\Controllers\CheckInController;
use CodeIgniter\Router\RouteCollection;
use App\Controllers\PagamentoController;
use App\Controllers\FinanceiroController;
use App\Controllers\RelatoriosController;
use App\Controllers\TrajetoriaController;
use App\Controllers\TipoPagamentoController;

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
    $routes->POST('user/save/', [UserController::class, 'save']);

    $routes->GET('treino', [TreinoController::class, 'index']);
    $routes->GET('treino/create', [TreinoController::class, 'create']);
    $routes->GET('treino/edit/(:num)', [TreinoController::class, 'edit']);
    $routes->GET('treino/delete/(:num)', [TreinoController::class, 'delete']);
    $routes->POST('treino/save/(:num)', [TreinoController::class, 'save']);
    $routes->POST('treino/save/', [TreinoController::class, 'save']);

    $routes->GET('evento', [EventoController::class, 'index']);
    $routes->GET('evento/create', [EventoController::class, 'create']);
    $routes->GET('evento/edit/(:num)', [EventoController::class, 'edit']);
    $routes->GET('evento/delete/(:num)', [EventoController::class, 'delete']);
    $routes->POST('evento/save/(:num)', [EventoController::class, 'save']);
    $routes->POST('evento/save/', [EventoController::class, 'save']);

    $routes->GET('checkin', [CheckInController::class, 'index']);
    $routes->POST('checkin/save', [CheckInController::class, 'save']);

    $routes->GET('dash', [Home::class, 'dash']);

    $routes->GET('configuracoes', [ConfigController::class, 'index']);

    $routes->GET('trajetoria', [TrajetoriaController::class, 'index']);

    $routes->GET('financeiro', [FinanceiroController::class, 'index']);

    $routes->GET('tipo_pagamento', [TipoPagamentoController::class, 'index']);
    $routes->GET('tipo_pagamento/create', [TipoPagamentoController::class, 'create']);
    $routes->GET('tipo_pagamento/edit/(:num)', [TipoPagamentoController::class, 'edit']);
    $routes->GET('tipo_pagamento/delete/(:num)', [TipoPagamentoController::class, 'delete']);
    $routes->POST('tipo_pagamento/save/(:num)', [TipoPagamentoController::class, 'save']);
    $routes->POST('tipo_pagamento/save/', [TipoPagamentoController::class, 'save']);

    $routes->GET('pagamento', [PagamentoController::class, 'index']);
    $routes->GET('pagamento/create', [PagamentoController::class, 'create']);
    $routes->GET('pagamento/edit/(:num)', [PagamentoController::class, 'edit']);
    $routes->GET('pagamento/delete/(:num)', [PagamentoController::class, 'delete']);
    $routes->POST('pagamento/save/(:num)', [PagamentoController::class, 'save']);
    $routes->POST('pagamento/save/', [PagamentoController::class, 'save']);

    $routes->GET('normas', [NormasController::class, 'index']);
    $routes->GET('normas/create', [NormasController::class, 'create']);
    $routes->GET('normas/edit/(:num)', [NormasController::class, 'edit']);
    $routes->GET('normas/delete/(:num)', [NormasController::class, 'delete']);
    $routes->POST('normas/save/(:num)', [NormasController::class, 'save']);
    $routes->POST('normas/save/', [NormasController::class, 'save']);

    $routes->GET('relatorios', [RelatoriosController::class, 'index']);
});

$routes->match(['get', 'post'], 'login', [AuthController::class, 'login']);
$routes->GET('logout', [AuthController::class, 'logout']);
