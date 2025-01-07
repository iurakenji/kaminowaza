<?php

namespace App\Controllers;

use App\Models\CheckInModel;
use App\Models\OcorrenciaModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CheckInController extends BaseController
{
    public function index()
    {
        $ocorrenciaModel = model(OcorrenciaModel::class);
        $data['title'] = 'Check-in';
        $data['ocorrencias'] = $ocorrenciaModel->getOcorrencias();
        $data['ocorrencias'] = array_combine(array_column($data['ocorrencias'], 'id'), array_column($data['ocorrencias'], 'titulo'));
        return view('checkin/index', $data);
    }

    public function save()
    {
        $checkInModel = model(CheckInModel::class);
        $user = session()->get('user');
        $data = $this->request->getPost();
        $data['user_id'] = $user['id'];
        $data['hora_checkin'] = date('Y-m-d H:i:s', time());
        $checkExist = $checkInModel->select('*')->where('ocorrencia_id', $data['ocorrencia_id'])->where('user_id', $user['id'])->first();
        if (!empty($checkExist)) {
            return redirect()->back()->withInput()->with('errors', ['Check in já realizado para este evento.']);
        }
        $checkInModel->insert($data);
        return redirect()->to('/checkin')->with('success', 'Check in realizado com sucesso!');
    }
}