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
        
        //Implementar checagem secundária (backend) da localização

        $checkInModel = model(CheckInModel::class);
        $user = session()->get('user');
        $data = $this->request->getPost();
        $data['user_id'] = $user['id'];
        $data['hora_checkin'] = date('Y-m-d H:i:s', time());
        $checkExist = $checkInModel->select('*')->where('ocorrencia_id', $data['ocorrencia_id'])->where('user_id', $user['id'])->first();
        if (!empty($checkExist)) {
            return redirect()->back()->withInput()->with('senhaIncorreta', [true]);
        }
        $checkInModel->insert($data);
        return redirect()->to('/checkin')->with('success', 'Check in realizado com sucesso!');
    }

    private function checkLocation(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $r = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $r * $c;

        return $distance;
    }

    private function deg2rad(float $deg): float
    {
        return $deg * pi() / 180;
    }


}