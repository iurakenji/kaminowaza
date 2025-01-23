<?php

namespace App\Controllers;

use App\Models\LocalModel;
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
        $localModel = model(LocalModel::class);
        $ocorrenciaModel = model(OcorrenciaModel::class);
        $now = date('Y-m-d');
        $locais = $localModel->findAll();
        $data['locais'] = array_map(function($local) {
            return [
                'latitude' => $local['latitude'],
                'longitude' => $local['longitude'],
                'raio' => $local['raio_permitido']
            ];
        }, array_combine(array_column($locais, 'id'), $locais));
        $data['ocorrencias'] = $ocorrenciaModel
            ->select('id, titulo, local_id')
                ->where("DATE(inicio) = '$now'")
                ->orWhere("DATE(termino) = '$now'")
            ->findAll();
        // $data['ocorrencias'] = array_combine(array_column($data['ocorrencias'], 'id'), array_column($data['ocorrencias'], 'titulo'));
        return view('checkin/index', $data);
    }

    public function save()
    {

        $checkInModel = model(CheckInModel::class);
        
        $data = $this->request->getPost();
        $user = session()->get('user');
        $data['user_id'] = $user['id'];
        $data['hora_checkin'] = date('Y-m-d H:i:s');
        $coord = [
            'lat' => $data['latitude'],
            'lon' => $data['longitude']
        ];
        
        $coord['lat'] = $data['latitude'];
        unset($data['latitude']);
        $coord['lon'] = $data['longitude'];
        unset($data['longitude']);
        
        $locationChecked = \Config\Services::location()->checkLocation($data['ocorrencia_id'], $coord);
        
        if (!$locationChecked) {
            return redirect()->back()->withInput()->with('error', 'Localização fora do permitido para o evento.');
        }
        $checkExist = $checkInModel->select('*')->where('ocorrencia_id', $data['ocorrencia_id'])->where('user_id', $user['id'])->first();
        if (!empty($checkExist)) {
            return redirect()->back()->withInput()->with('error', 'Você já realizou um check-in neste evento.');
        }
        $checkInModel->insert($data);
        return redirect()->to('/checkin')->with('success', 'Check in realizado com sucesso!');
    }

    


}