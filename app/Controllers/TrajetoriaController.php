<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CheckInModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TrajetoriaController extends BaseController
{
    public function index()
    {
        $userModel = model(UserModel::class);
        $data['alunos'] = $userModel->where('username !=', 'admin')->where('tipo', 'aluno')->orderBy('graduacao', 'desc')->orderBy('inicio_treinos', 'asc')->findAll();
        $data['alunos'] = array_combine(array_column($data['alunos'], 'id'),array_column($data['alunos'], 'nome'));
        $data['title'] = 'Trajetoria';
        $request = $this->request->getGet('aluno');
        $data['selectedUser'] = $request ?? session()->get('user')['id'];

        $checkinModel = model(CheckInModel::class);
        $trajetoria = $checkinModel->getTrajetoria($data['selectedUser']);
        $data += $trajetoria;

        return view('trajetoria/index', $data);
    }
}
