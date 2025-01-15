<?php

namespace App\Controllers;

use App\Models\NormaModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class NormaController extends BaseController
{
    public function index(string $page = 'index'): string
    {
        $title = 'Definição de Normas';
        $normaModel = model(NormaModel::class);
        $data['normas'] = $normaModel->findAll();
        return view('norma/' . $page, ['title' => $title, 'data' => $data]);
    }

    public function create(): string
    {
        $title = 'Criar Nova Norma';
        return view('norma/create-edit', compact('title'));
    }

    public function edit($id): string
    {
        $normaModel = model(NormaModel::class);
        $title = 'Editar Tipo de Pagamento';
        $norma = $normaModel->find($id);
        return view('norma/create-edit', ['title' => $title, 'norma' => $norma]);
    }

    public function save($id = null): RedirectResponse
    {
        $normaModel = model(NormaModel::class);
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
                    $norma = $normaModel->find($id);
                    if (!empty($data['image_path'])) {
                        $image_path = $norma['image_path'];
                        if (file_exists('images/normas/'.$image_path) && is_file('images/normas/'.$image_path)) {
                            unlink('images/normas/'.$image_path);   
                        }
                        $newName = $image->getRandomName();
                        $image->move('images/normas', $newName);
                        $data['image_path'] = $newName;
                    }
                }
            }
            if ($isEdit) {
                try {
                    $normaModel->update($id, $data);
                } catch (\Throwable $th) {
                    $errors[] = $th->getMessage();
                }
            } else {
                try {
                    $normaModel->insert($data);
                } catch (\Throwable $th) {
                    $errors[] = $th->getMessage();
                }  
            }
        } else {
            return redirect()->back()->withInput()->with('errors', $errors);
        }
        return redirect()->to('/norma')->with('success', 'Norma registrada com sucesso!');
    }

    public function delete($id): ResponseInterface
    {
        $normaModel = model(NormaModel::class);
        $normaModel->delete($id);
        return redirect()->to('/norma')->with('success', 'Norma excluida com sucesso!');
    }

    public function list(): string
    {
        $normaModel = model(NormaModel::class);
        $data['title'] = 'Normas do Dojo';
        $data['normas'] = $normaModel->findAll();
        return view('norma/list', $data);
    }
}
