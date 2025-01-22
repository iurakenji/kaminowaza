<?php

namespace App\Controllers;

use App\Models\CheckInModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TrajetoriaController extends BaseController
{
    public function index()
    {
        $data['title'] = 'Trajetoria';
        $checkinModel = model(CheckInModel::class);
        $trajetoria = $checkinModel->getTrajetoria(\Config\Services::auth()->user()['id']);
        $data += $trajetoria;
        // dd($data);
        return view('trajetoria/index', $data);
    }
}
