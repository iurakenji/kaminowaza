<?php

namespace App\Controllers;

use App\Models\TecnicaModel;
use App\Models\GraduacaoModel;
use App\Models\RequisitoModel;
use App\Controllers\BaseController;
use App\Models\GraduacaoTecnicaModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class GraduacaoController extends BaseController
{
    public function index(): string
    {
        $data['title'] = 'Graduações';
        $graduacaoModel = model(GraduacaoModel::class);
        $data['graduacoes'] = $graduacaoModel->findAll();
        return view('graduacao/index', $data);
    }

    public function create(): string
    {
        $data['title'] = 'Criar Nova Graduação';
        $data['tecnicas'] = model(TecnicaModel::class)->findAll();
        $data['tipos_requisitos'] = [
            'aulas_total' => 'Total de aulas',
            'tempo_total' => 'Tempo total',
            'aulas_grad' => 'Aulas desde a última graduação',
            'aulas_tempo' => 'Aulas em um período',
            'idade' => 'Idade',
        ];
        return view('graduacao/create-edit', $data);
    }

    public function edit($id): string
    {
        $graduacaoModel = model(GraduacaoModel::class);
        $requisitosModel = model(RequisitoModel::class);
        $tecnicasModel = model(TecnicaModel::class);
        $graduacaoTecnicasModel = model(GraduacaoTecnicaModel::class);
        $data['title'] = 'Editar Graduação';
        $data['graduacao'] = $graduacaoModel->find($id);
        $data['requisitos'] = $requisitosModel->where('graduacao_id', $id)->findAll();
        $data['tecnicas'] = array_map(function($tecnica) {
            return ['id' => $tecnica['id'], 'nome' => $tecnica['nome']];
        }, $tecnicasModel->findAll());
        $data['graduacao_tecnicas'] = $graduacaoTecnicasModel->where('graduacao_id', $id)->findAll();
        $data['graduacao_tecnicas'] = array_column($data['graduacao_tecnicas'], 'tecnica_id');
        $data['tipos_requisitos'] = [
            'aulas_total' => 'Total de aulas',
            'tempo_total' => 'Tempo total',
            'aulas_grad' => 'Aulas desde a última graduação',
            'aulas_tempo' => 'Aulas em um período',
            'idade' => 'Idade',
        ];
        return view('graduacao/create-edit', $data);
    }

    public function save($id = null): RedirectResponse
    {
        $graduacaoModel = model(GraduacaoModel::class);
        $request = $this->request;

        $validation = service('validation');
        if ($request->getMethod() === 'POST') {
            $data = $request->getPost();
            $requisitos = json_decode($data['requisitos'], true);
            $tecnicas = json_decode($data['graduacao_tecnicas'], false);
            unset($data['requisitos']);
            unset($data['graduacao_tecnicas']);
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
                    $id = $graduacaoModel->insert($data);
                } catch (\Throwable $th) {
                    $errors[] = $th->getMessage();
                }  
            }
            if (isset($requisitos)) {
                $requisitosModel = model(RequisitoModel::class);
                $requisitosModel->upsertRequisitos($id, $requisitos);
            }
            if (isset($tecnicas)) {
                $graduacaoTecnicasModel = model(GraduacaoTecnicaModel::class);
                $graduacaoTecnicasModel->upsertTecnicas($id, $tecnicas);
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
