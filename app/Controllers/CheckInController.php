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
        $location = $_ENV['LOCATION'];
        $location = COORDENADAS[$location];
        $data['location'] = $location;
        // $data['ocorrencias'] = $ocorrenciaModel->getOcorrencias();
        // $data['ocorrencias'] = array_combine(array_column($data['ocorrencias'], 'id'), array_column($data['ocorrencias'], 'titulo'));
        return view('checkin/index', $data);
    }

    public function save()
    {
        $location = $_ENV['LOCATION'];
        $location = COORDENADAS[$location];
        


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

    public function checkLocation()
    {
        $location = $_ENV['LOCATION'];
        $location = COORDENADAS[$location];
        return $location;



}