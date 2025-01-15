<?php

namespace App\Controllers;

use App\Models\TecnicaModel;
use App\Models\GraduacaoModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class GraduacaoController extends BaseController
{
    public function index(string $page = 'index'): string
    {
        $title = 'Graduações';
        $graduacaoModel = model(GraduacaoModel::class);
        $data['graduacoes'] = $graduacaoModel->findAll();
        return view('graduacao/' . $page, ['title' => $title, 'data' => $data]);
    }

    public function create(): string
    {
        $data['title'] = 'Criar Nova Graduação';
        $data['tecnicas'] = model(TecnicaModel::class)->findAll();
        return view('graduacao/create-edit', $data);
    }

    public function edit($id): string
    {
        $graduacaoModel = model(GraduacaoModel::class);
        $title = 'Editar Graduação';
        $graduacao = $graduacaoModel->find($id);
        return view('graduacao/create-edit', ['title' => $title, 'graduacao' => $graduacao]);
    }

    public function save($id = null): RedirectResponse
    {
        $graduacaoModel = model(GraduacaoModel::class);
        $request = $this->request;

        $validation = service('validation');
        if ($request->getMethod() === 'POST') {
            $data = $request->getPost();
        }
        $isEdit = isset($id);
        unset($data['submit']);
        $rules = [
            'nome' => 'required',
        ];
        $validation->setRules($rules);
        $validation->run($data);
        $errors = $validation->getErrors();

        if (empty($errors)) {
            if ($isEdit) {
                try {
                    $graduacaoModel->update($id, $data);
                } catch (\Throwable $th) {
                    $errors[] = $th->getMessage();
                }
            } else {
                try {
                    $graduacaoModel->insert($data);
                } catch (\Throwable $th) {
                    $errors[] = $th->getMessage();
                }  
            }
        } else {
            return redirect()->back()->withInput()->with('errors', $errors);
        }
        return redirect()->to('/graduacao')->with('success', 'Graduação registrada com sucesso!');
    }

    public function delete($id): ResponseInterface
    {
        $graduacaoModel = model(GraduacaoModel::class);
        $graduacaoModel->delete($id);
        return redirect()->to('/graduacao')->with('success', 'Graduação excluida com sucesso!');
    }

    public function list(): string
    {
        $graduacaoModel = model(GraduacaoModel::class);
        $data['title'] = 'Graduações do Dojo';
        $data['graduacaos'] = $graduacaoModel->findAll();
        return view('graduacao/list', $data);
    }
}
