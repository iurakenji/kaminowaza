<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TreinoModel;
use App\Models\OcorrenciaModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;

class TreinoController extends BaseController
{
    public function index(string $page = 'index'): string
    {
        $title = 'Treinos';
        $treinoModel = model(TreinoModel::class);
        $userModel = model(UserModel::class);
        $data['treinos'] = $treinoModel->findAll();
        $professores = $userModel->select(['id', 'nome'])->where(['tipo' => 'professor'])->findAll();
        $professores = array_combine(array_column($professores, 'id'),array_column($professores, 'nome'));
        $data['professores'] = $professores;

        return view('treino/' . $page, ['title' => $title, 'data' => $data]);
    }

    public function create(): string
    {
        $userModel = model(UserModel::class);
        $title = 'Criar Treino';
        $professores = $userModel->select(['id', 'nome'])->where(['tipo' => 'professor'])->findAll();
        $professores = array_combine(array_column($professores, 'id'),array_column($professores, 'nome'));
        return view('treino/create-edit', compact('title', 'professores'));
    }

    public function edit($id): string
    {
        $treinoModel = model(TreinoModel::class);
        $userModel = model(UserModel::class);
        $title = 'Editar Treino';
        $treino = $treinoModel->find($id);
        $professores = $userModel->select(['id', 'nome'])->where(['tipo' => 'professor'])->findAll();
        $professores = array_combine(array_column($professores, 'id'),array_column($professores, 'nome'));
        return view('treino/create-edit', ['title' => $title, 'treino' => $treino, 'professores' => $professores]);
    }

    public function save($id = null): RedirectResponse
    {
        $treinoModel = model(TreinoModel::class);
        $userModel = model(UserModel::class);
        $ocorrenciaModel = model(OcorrenciaModel::class);

        $professoresIds = $userModel->select(['id'])->where(['tipo' => 'professor'])->findAll();
        $professoresIds = !empty($professoresIds) ? array_column($professoresIds, 'id') : [];
        $professoresIds = implode(',', $professoresIds);
        $request = $this->request;

        $validation = service('validation');
        if ($request->getMethod() === 'POST') {
            $data = $request->getPost();
        }
        $isEdit = isset($id);
        unset($data['submit']);
        $rules = [
            'dia' => 'required',
            'inicio' => 'required',
            'termino' => 'required',
            'professor_id' => "required|in_list[$professoresIds]",
        ];
        $validation->setRules($rules);
        $validation->run($data);
        $errors = $validation->getErrors();

        $conflitos = $ocorrenciaModel->checkAvailable($data);

        if (!empty($conflitos)) {
            return redirect()->back()->withInput()->with('conflitos', $conflitos);
        }

        if (empty($errors)) {
            if ($isEdit) {
                try {
                    $treinoModel->update($id, $data);
                } catch (\Throwable $th) {
                    $errors[] = $th->getMessage();
                }
            } else {
                try {
                    $inserted = $treinoModel->insert($data);
                } catch (\Throwable $th) {
                    $errors[] = $th->getMessage();
                }
            }
            $ocorrenciaData = [
                'dia' => $data['dia'],
                'tipo' => 'treino_regular',
                'inicio' => $data['inicio'],
                'termino' => $data['termino'],
                'referencia_id' => $id ?: $inserted,
                'titulo' => 'Treino: ' 
                            . WEEKDAYS[$data['dia']] 
                            . ' - ' 
                            . date('H:i', strtotime($data['inicio'])) 
                            . ' a ' 
                            . date('H:i', strtotime($data['termino'])),
                'observacao' => $data['observacao']
            ];
            $errors += $ocorrenciaModel->upsertTreinos($ocorrenciaData);
        } else {
            return redirect()->back()->withInput()->with('errors', $errors);
        }
        return redirect()->to('/treino')->with('success', 'Treino salvo com sucesso!');
    }

    public function delete($id): ResponseInterface
    {
        $treinoModel = model(TreinoModel::class);
        $treinoModel->delete($id);
        return redirect()->to('/treino')->with('success', 'Treino excluido com sucesso!');
    }
}