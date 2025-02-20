<?php

use App\Controllers\Home;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\LocalController;
use App\Controllers\NormaController;
use App\Controllers\ThemeController;
use App\Controllers\AgendaController;
use App\Controllers\ConfigController;
use App\Controllers\EventoController;
use App\Controllers\TreinoController;
use App\Controllers\CheckInController;
use App\Controllers\TecnicaController;
use CodeIgniter\Router\RouteCollection;
use App\Controllers\GraduacaoController;
use App\Controllers\PagamentoController;
use App\Controllers\FinanceiroController;
use App\Controllers\NafudakakeController;
use App\Controllers\RelatoriosController;
use App\Controllers\TrajetoriaController;
use App\Controllers\TipoPagamentoController;
use App\Controllers\RegistroPagamentoController;

/**
 * @var RouteCollection $routes
 */
$routes->group('', ['filter' => 'auth'], function ($routes) {

    $routes->GET('/', [Home::class, 'index']);
    $routes->GET('/home', [Home::class, 'index']);

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

    $routes->GET('theme', [ThemeController::class, 'index']);
    $routes->GET('theme/create', [ThemeController::class, 'create']);
    $routes->GET('theme/edit/(:num)', [ThemeController::class, 'edit']);
    $routes->GET('theme/delete/(:num)', [ThemeController::class, 'delete']);
    $routes->POST('theme/save/(:num)', [ThemeController::class, 'save']);
    $routes->POST('theme/save/', [ThemeController::class, 'save']);
    $routes->POST('theme/select/(:num)', [ThemeController::class, 'select']);

    $routes->GET('evento', [EventoController::class, 'index']);
    $routes->GET('evento/create', [EventoController::class, 'create']);
    $routes->GET('evento/edit/(:num)', [EventoController::class, 'edit']);
    $routes->GET('evento/delete/(:num)', [EventoController::class, 'delete']);
    $routes->POST('evento/save/(:num)', [EventoController::class, 'save']);
    $routes->POST('evento/save/', [EventoController::class, 'save']);

    $routes->GET('checkin', [CheckInController::class, 'checkin']);
    $routes->match(['GET', 'POST'], 'checkin/save', [CheckInController::class, 'save']);

    $routes->GET('dash', [Home::class, 'dash']);

    $routes->GET('estatuto', [Home::class, 'estatuto']);

    $routes->GET('configuracoes', [ConfigController::class, 'index']);

    $routes->GET('trajetoria', [TrajetoriaController::class, 'index']);

    $routes->GET('nafudakake', [NafudakakeController::class, 'index']);

    $routes->GET('financeiro', [FinanceiroController::class, 'index']);
    $routes->GET('doacoes', [FinanceiroController::class, 'doacao']);

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

    $routes->GET('registroPagamento', [RegistroPagamentoController::class, 'index']);    
    $routes->GET('registroPagamento/create', [RegistroPagamentoController::class, 'create']);
    $routes->GET('registroPagamento/edit/(:num)', [RegistroPagamentoController::class, 'edit']);
    $routes->GET('registroPagamento/delete/(:num)', [RegistroPagamentoController::class, 'delete']);
    $routes->POST('registroPagamento/save/(:num)', [RegistroPagamentoController::class, 'save']);
    $routes->POST('registroPagamento/save/', [RegistroPagamentoController::class, 'save']);
    $routes->GET('registroPagamento/historico', [RegistroPagamentoController::class, 'list']);

    $routes->GET('norma', [NormaController::class, 'index']);
    $routes->GET('norma/list', [NormaController::class, 'list']);
    $routes->GET('norma/create', [NormaController::class, 'create']);
    $routes->GET('norma/edit/(:num)', [NormaController::class, 'edit']);
    $routes->GET('norma/delete/(:num)', [NormaController::class, 'delete']);
    $routes->POST('norma/save/(:num)', [NormaController::class, 'save']);
    $routes->POST('norma/save/', [NormaController::class, 'save']);

    $routes->GET('tecnica', [TecnicaController::class, 'index']);
    $routes->GET('tecnica/list', [TecnicaController::class, 'list']);
    $routes->GET('tecnica/create', [TecnicaController::class, 'create']);
    $routes->GET('tecnica/edit/(:num)', [TecnicaController::class, 'edit']);
    $routes->GET('tecnica/delete/(:num)', [TecnicaController::class, 'delete']);
    $routes->POST('tecnica/save/(:num)', [TecnicaController::class, 'save']);
    $routes->POST('tecnica/save/', [TecnicaController::class, 'save']);

    $routes->GET('graduacao', [GraduacaoController::class, 'index']);
    $routes->GET('graduacao/list', [GraduacaoController::class, 'list']);
    $routes->GET('graduacao/create', [GraduacaoController::class, 'create']);
    $routes->GET('graduacao/edit/(:num)', [GraduacaoController::class, 'edit']);
    $routes->GET('graduacao/delete/(:num)', [GraduacaoController::class, 'delete']);
    $routes->POST('graduacao/save/(:num)', [GraduacaoController::class, 'save']);
    $routes->POST('graduacao/save/', [GraduacaoController::class, 'save']);

    $routes->GET('local', [LocalController::class, 'index']);
    $routes->GET('local/create', [LocalController::class, 'create']);
    $routes->GET('local/edit/(:num)', [LocalController::class, 'edit']);
    $routes->GET('local/delete/(:num)', [LocalController::class, 'delete']);
    $routes->POST('local/save/(:num)', [LocalController::class, 'save']);
    $routes->POST('local/save/', [LocalController::class, 'save']);

    $routes->GET('relatorios', [RelatoriosController::class, 'index']);

    $routes->GET('agenda', [AgendaController::class, 'index']);

});

$routes->match(['get', 'post'], 'login', [AuthController::class, 'login']);
$routes->GET('logout', [AuthController::class, 'logout']);
