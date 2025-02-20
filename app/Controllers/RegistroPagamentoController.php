<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RegistroPagamentoModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class RegistroPagamentoController extends BaseController
{
    public function index(): string
    {
        $data['title'] = 'Registro de Pagamento';
        $registroPagamentoModel = model(RegistroPagamentoModel::class);
        $data['registrosPagamento'] = $registroPagamentoModel->findAll();
        return view('registro_pagamento/index', $data);
    }

    public function create(): string
    {
        $data['title'] = 'Registrar Pagamento';
        return view('registro_pagamento/create-edit', $data);
    }

    public function edit($id): string
    {
        $registroPagamentoModel = model(RegistroPagamentoModel::class);
        $data['title'] = 'Editar Registro de Pagamento';
        $data['registroPagamento'] = $registroPagamentoModel->find($id);
        return view('registro_pagamento/create-edit', $data);
    }

    public function save($id = null): RedirectResponse
    {
        $registroPagamentoModel = model(RegistroPagamentoModel::class);
        $request = $this->request;
        $image = $this->request->getFile('image_path');

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
            if ($image->isValid() && !$image->hasMoved()) {
                if ($isEdit) {
                    $registroPagamento = $registroPagamentoModel->find($id);
                    if (!empty($data['image_path'])) {
                        $image_path = $registroPagamento['image_path'];
                        if (file_exists('images/registroPagamentos/'.$image_path) && is_file('images/registroPagamentos/'.$image_path)) {
                            unlink('images/registro_pagamento/'.$image_path);   
                        }
                    }
                }
                $newName = $image->getRandomName();
                $image->move('images/registro_pagamento', $newName);
                $data['image_path'] = $newName;
            }
            if ($isEdit) {
                try {
                    $registroPagamentoModel->update($id, $data);
                } catch (\Throwable $th) {
                    $errors[] = $th->getMessage();
                }
            } else {
                try {
                    $registroPagamentoModel->insert($data);
                } catch (\Throwable $th) {
                    $errors[] = $th->getMessage();
                }  
            }
        } else {
            return redirect()->back()->withInput()->with('errors', $errors);
        }
        return redirect()->to('/registro_pagamento')->with('success', 'Norma registrada com sucesso!');
    }

    public function delete($id): ResponseInterface
    {
        $registroPagamentoModel = model(RegistroPagamentoModel::class);
        $registroPagamentoModel->delete($id);
        return redirect()->to('/registro_pagamento')->with('success', 'Norma excluida com sucesso!');
    }

    public function list(): string
    {
        $registroPagamentoModel = model(RegistroPagamentoModel::class);
        $data['title'] = 'Normas do Dojo';
        $data['registroPagamentos'] = $registroPagamentoModel->findAll();
        return view('registro_pagamento/list', $data);
    }

}


