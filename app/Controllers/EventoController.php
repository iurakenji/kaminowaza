<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\EventoModel;
use App\Models\OcorrenciaModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;

class EventoController extends BaseController
{

    public function index(string $page = 'index'): string
    {
        $title = 'Eventos';
        $eventoModel = model(EventoModel::class);
        $data['eventos'] = $eventoModel->findAll();
        return view('evento/' . $page, ['title' => $title, 'data' => $data]);
    }

    public function create(): string
    {
        $title = 'Criar evento';
        return view('evento/create-edit', compact('title'));
    }

    public function edit($id): string
    {
        $eventoModel = model(EventoModel::class);
        $title = 'Editar evento';
        $evento = $eventoModel->find($id);
        return view('evento/create-edit', ['title' => $title, 'evento' => $evento]);
    }

    public function save($id = null): RedirectResponse
    {
        $eventoModel = model(EventoModel::class);
        $ocorrenciaModel = model(OcorrenciaModel::class);
        $request = $this->request;

        $validation = service('validation');
        if ($request->getMethod() === 'POST') {
            $data = $request->getPost();
        }
        $isEdit = isset($id);
        unset($data['submit']);
        $rules = [
            'titulo' => 'required',
            'inicio' => 'required|valid_date',
            'termino' => 'required|valid_date',
            'tipo' => "required",
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
                    $eventoModel->update($id, $data);
                } catch (\Throwable $th) {
                    $errors[] = $th->getMessage();
                }
                $ocorrencia = $ocorrenciaModel->where(['referencia_id' => $id])->where(['tipo' => 'evento'])->first();
            } else {
                try {
                    $eventoInserido = $eventoModel->insert($data);
                } catch (\Throwable $th) {
                    $errors[] = $th->getMessage();
                }  
            }
            $ocorrenciaData = [
                'tipo' => 'evento',
                'referencia_id' => $isEdit ? $id : $eventoInserido,
                'inicio' => $data['inicio'],
                'termino' => $data['termino'],
                'titulo' => $data['titulo'],
                'observacao' => $data['observacao']
            ];
            try {
                if (!$isEdit && empty($ocorrencia)) {
                    $ocorrenciaModel->insert($ocorrenciaData);
                } else {
                    $ocorrenciaModel->update($ocorrencia, $ocorrenciaData);
                }
            } catch (\Throwable $th) {
                $errors[] = $th->getMessage();
            }
        } else {
            return redirect()->back()->withInput()->with('errors', $errors);
        }
        return redirect()->to('/evento')->with('success', 'Evento salvo com sucesso!');
    }

    public function delete($id): ResponseInterface
    {
        $eventoModel = model(EventoModel::class);
        $ocorrenciaModel = model(OcorrenciaModel::class);
        $ocorrencia = $ocorrenciaModel->where(['referencia_id' => $id])->where(['tipo' => 'evento'])->delete();
        if (!empty($ocorrencia)) {
            $ocorrenciaModel->where(['referencia_id' => $id])->where(['tipo' => 'evento'])->delete();
        }
        $eventoModel->delete($id);
        return redirect()->to('/evento')->with('success', 'evento excluido com sucesso!');
    }
    
}