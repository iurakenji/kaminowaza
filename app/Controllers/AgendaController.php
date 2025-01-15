<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AgendaController extends BaseController
{
    public function index()
    {
        $ocorrenciasModel = model('OcorrenciaModel');
        $title = 'Agenda';
        $request = service('request');
        $mes = $request->getGet('mes');
        $ano = $request->getGet('ano');

        if (empty($mes)) {
            $mes = date('m');
        }
        if (empty($ano)) {
            $ano = date('Y');
        }
        $ocorrencias = $ocorrenciasModel->getOcorrencias($mes, $ano);

        return view('agenda/index', ['title' => $title, 'mes' => $mes, 'ano' => $ano, 'ocorrencias' => $ocorrencias]);
    }
}
