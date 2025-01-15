<?php

namespace App\Controllers;

use App\Models\PagamentoModel;
use App\Models\TipoPagamentoModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class PagamentoController extends BaseController
{
    public function index(string $page = 'index'): string
    {
        $tipoPagamentoModel = model(TipoPagamentoModel::class);
        $data['title'] = 'Criar Novo Pagamento';
        $data['tipos_pagamentos'] = $tipoPagamentoModel->findAll();
        $data['tipos_pagamentos'] = array_combine(array_column($data['tipos_pagamentos'], 'id'),array_column($data['tipos_pagamentos'], 'nome'));

        $pagamentoModel = model(PagamentoModel::class);
        $data['pagamentos'] = $pagamentoModel->findAll();
        return view('pagamento/' . $page, $data);
    }

    public function create(): string
    {
        $tipoPagamentoModel = model(TipoPagamentoModel::class);
        $data['title'] = 'Criar Novo Pagamento';
        $data['tipos_pagamentos'] = $tipoPagamentoModel->findAll();
        $data['tipos_pagamentos'] = array_combine(array_column($data['tipos_pagamentos'], 'id'),array_column($data['tipos_pagamentos'], 'nome'));
        return view('pagamento/create-edit',  $data);
    }

    public function edit($id): string
    {
        $pagamentoModel = model(PagamentoModel::class);
        $tipoPagamentoModel = model(TipoPagamentoModel::class);
        $data['title'] = 'Editar Pagamento';
        $data['tipos_pagamentos'] = $tipoPagamentoModel->findAll();
        $data['tipos_pagamentos'] = array_combine(array_column($data['tipos_pagamentos'], 'id'),array_column($data['tipos_pagamentos'], 'nome'));
        
        $data['pagamento'] = $pagamentoModel->find($id);
        
        return view('pagamento/create-edit', $data);
    }

    public function save($id = null): RedirectResponse
    {
        $pagamentoModel = model(PagamentoModel::class);
        $request = $this->request;

        $validation = service('validation');
        if ($request->getMethod() === 'POST') {
            $data = $request->getPost();
        }
        $isEdit = isset($id);
        unset($data['submit']);
        $rules = [
            'nome' => 'required',
            'valor' => 'required|decimal',
            'recorrente' => 'required',
        ];
        $validation->setRules($rules);
        $validation->run($data);
        $errors = $validation->getErrors();
        if (empty($data['contrato_id'])) {
            unset($data['contrato_id']);
        }

        if (empty($errors)) {
            if ($isEdit) {
                try {
                    $pagamentoModel->update($id, $data);
                } catch (\Throwable $th) {
                    $errors[] = $th->getMessage();
                }
            } else {
                try {
                    $pagamentoModel->insert($data);
                } catch (\Throwable $th) {
                    $errors[] = $th->getMessage();
                }  
            }
        } else {
            return redirect()->back()->withInput()->with('errors', $errors);
        }
        return redirect()->to('/pagamento')->with('success', 'pagamento registrada com sucesso!');
    }

    public function delete($id): ResponseInterface
    {
        $pagamentoModel = model(PagamentoModel::class);
        $pagamentoModel->delete($id);
        return redirect()->to('/tipo_pagamento')->with('success', 'Tipo de Pagamento excluido com sucesso!');
    }
}
