<?php

namespace App\Controllers;

use App\Models\LocalModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class LocalController extends BaseController
{
    public function index(): string
    {
        $data['title'] = 'Locais';
        $localModel = model(LocalModel::class);
        $data['locais'] = $localModel->findAll();
        return view('local/index', $data);
    }

    public function create(): string
    {
        $data['title'] = 'Criar Local';
        return view('local/create-edit', $data);
    }

    public function edit($id): string
    {
        $localModel = model(LocalModel::class);
        $data['title'] = 'Editar Locais';
        $data['local'] = $localModel->find($id);
        return view('local/create-edit', $data);
    }

    public function save($id = null): RedirectResponse
    {
        $localModel = model(LocalModel::class);
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
                    $localModel->update($id, $data);
                } catch (\Throwable $th) {
                    $errors[] = $th->getMessage();
                }
            } else {
                try {
                    $localInserido = $localModel->insert($data);
                } catch (\Throwable $th) {
                    $errors[] = $th->getMessage();
                }  
            }
        } else {
            return redirect()->back()->withInput()->with('errors', $errors);
        }
        return redirect()->to('/local')->with('success', 'Local salvo com sucesso!');
    }

    public function delete($id): ResponseInterface
    {
        $localModel = model(LocalModel::class);
        $localModel->delete($id);
        return redirect()->to('/local')->with('success', 'Local excluido com sucesso!');
    }
}
