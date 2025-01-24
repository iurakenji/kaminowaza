<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\GraduacaoModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class NafudakakeController extends BaseController
{
    public function index()
    {
        
        $data['title'] = 'Nafudakake';
        $graduacaoModel = model(GraduacaoModel::class);
        $graduacoes = $graduacaoModel->orderBy('ordem', 'desc')->findAll();
        $userModel = model(UserModel::class);
        $alunos = $userModel->where('username !=', 'admin')->orderBy('graduacao', 'desc')->orderBy('inicio_treinos', 'asc')->findAll();
        
        $data += [
            'nafudakake' => []
        ];

        foreach ($graduacoes as $graduacao) {
            $alunosGrad = array_filter($alunos, function ($aluno) use ($graduacao) {
                return $aluno['graduacao'] == $graduacao['id'];
            });
            $alunosGrad = array_column($alunosGrad, 'nome');
            if (!empty($alunosGrad)) {
                $data['nafudakake'][$graduacao['id']]['alunos'] = $alunosGrad;
                $data['nafudakake'][$graduacao['id']]['graduacao'] = $graduacao;
            }
        }

        return view('nafudakake/index', $data);

    }
}
