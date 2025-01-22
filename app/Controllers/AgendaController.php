<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AgendaController extends BaseController
{
    public function index()
    {
        $ocorrenciasModel = model('OcorrenciaModel');
        $data['title'] = 'Agenda';
        $request = service('request');
        $data['mes'] = $request->getGet('mes');
        $data['ano'] = $request->getGet('ano');

        if (empty($mes)) {
            $data['mes'] = date('m');
        }
        if (empty($ano)) {
            $data['ano'] = date('Y');
        }
        $data['ocorrencias'] = $ocorrenciasModel->getOcorrencias($data['mes'], $data['ano']);

        return view('agenda/index', $data);
    }
}
