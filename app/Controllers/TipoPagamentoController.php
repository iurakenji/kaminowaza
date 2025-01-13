<?php

namespace App\Controllers;

use App\Models\TipoPagamentoModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class TipoPagamentoController extends BaseController
{
    public function index(string $page = 'index'): string
    {
        $title = 'Tipos de Pagamentos';
        $tipoPagamentoModel = model(TipoPagamentoModel::class);
        $data['tipos_pagamentos'] = $tipoPagamentoModel->findAll();
        return view('tipo_pagamento/' . $page, ['title' => $title, 'data' => $data]);
    }

    public function create(): string
    {
        $title = 'Criar Tipo de Pagamento';
        return view('tipo_pagamento/create-edit', compact('title'));
    }

    public function edit($id): string
    {
        $eventoModel = model(TipoPagamentoModel::class);
        $title = 'Editar Tipo de Pagamento';
        $tipoPagamento = $eventoModel->find($id);
        return view('tipo_pagamento/create-edit', ['title' => $title, 'tipoPagamento' => $tipoPagamento]);
    }

    public function save($id = null): RedirectResponse
    {
        $tipoPagamentoModel = model(TipoPagamentoModel::class);
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
                    $tipoPagamentoModel->update($id, $data);
                } catch (\Throwable $th) {
                    $errors[] = $th->getMessage();
                }
            } else {
                try {
                    $tipoPagamentoInserido = $tipoPagamentoModel->insert($data);
                } catch (\Throwable $th) {
                    $errors[] = $th->getMessage();
                }  
            }
        } else {
            return redirect()->back()->withInput()->with('errors', $errors);
        }
        return redirect()->to('/tipo_pagamento')->with('success', 'Tipo de Pagamento salvo com sucesso!');
    }

    public function delete($id): ResponseInterface
    {
        $tipoPagamentoModel = model(TipoPagamentoModel::class);
        $tipoPagamentoModel->delete($id);
        return redirect()->to('/tipo_pagamento')->with('success', 'Tipo de Pagamento excluido com sucesso!');
    }
}
