<?php

namespace App\Controllers;

use App\Models\GraduacaoModel;
use App\Controllers\BaseController;
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
        $title = 'Criar Nova Técnica';
        return view('graduacao/create-edit', compact('title'));
    }

    public function edit($id): string
    {
        $graduacaoModel = model(GraduacaoModel::class);
        $title = 'Editar Tipo de Pagamento';
        $graduacao = $graduacaoModel->find($id);
        return view('graduacao/create-edit', ['title' => $title, 'graduacao' => $graduacao]);
    }

    public function save($id = null): RedirectResponse
    {
        $graduacaoModel = model(GraduacaoModel::class);
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
                    $graduacao = $graduacaoModel->find($id);
                    if (!empty($data['image_path'])) {
                        $image_path = $graduacao['image_path'];
                        if (file_exists('images/graduacaos/'.$image_path) && is_file('images/graduacaos/'.$image_path)) {
                            unlink('images/graduacaos/'.$image_path);       
                        }
                        $newName = $image->getRandomName();
                        $image->move('images/graduacaos', $newName);
                        $data['image_path'] = $newName;
                    }
                }
            }
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
        return redirect()->to('/graduacao')->with('success', 'graduacao registrada com sucesso!');
    }

    public function delete($id): ResponseInterface
    {
        $graduacaoModel = model(GraduacaoModel::class);
        $graduacaoModel->delete($id);
        return redirect()->to('/graduacao')->with('success', 'graduacao excluida com sucesso!');
    }

    public function list(): string
    {
        $graduacaoModel = model(GraduacaoModel::class);
        $data['title'] = 'graduacaos do Dojo';
        $data['graduacaos'] = $graduacaoModel->findAll();
        return view('graduacao/list', $data);
    }
}
