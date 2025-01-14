<?php

namespace App\Controllers;

use App\Models\TecnicaModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class TecnicaController extends BaseController
{
    public function index(string $page = 'index'): string
    {
        $title = 'Técnicas';
        $tecnicaModel = model(TecnicaModel::class);
        $data['tecnicas'] = $tecnicaModel->findAll();
        return view('tecnica/' . $page, ['title' => $title, 'data' => $data]);
    }

    public function create(): string
    {
        $title = 'Criar Nova Técnica';
        return view('tecnica/create-edit', compact('title'));
    }

    public function edit($id): string
    {
        $tecnicaModel = model(TecnicaModel::class);
        $title = 'Editar Tipo de Pagamento';
        $tecnica = $tecnicaModel->find($id);
        return view('tecnica/create-edit', ['title' => $title, 'tecnica' => $tecnica]);
    }

    public function save($id = null): RedirectResponse
    {
        $tecnicaModel = model(TecnicaModel::class);
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
                    $tecnica = $tecnicaModel->find($id);
                    if (!empty($data['image_path'])) {
                        $image_path = $tecnica['image_path'];
                        if (file_exists('images/tecnicas/'.$image_path) && is_file('images/tecnicas/'.$image_path)) {
                            unlink('images/tecnicas/'.$image_path);       
                        }
                        $newName = $image->getRandomName();
                        $image->move('images/tecnicas', $newName);
                        $data['image_path'] = $newName;
                    }
                }
            }
            if ($isEdit) {
                try {
                    $tecnicaModel->update($id, $data);
                } catch (\Throwable $th) {
                    $errors[] = $th->getMessage();
                }
            } else {
                try {
                    $tecnicaModel->insert($data);
                } catch (\Throwable $th) {
                    $errors[] = $th->getMessage();
                }  
            }
        } else {
            return redirect()->back()->withInput()->with('errors', $errors);
        }
        return redirect()->to('/tecnica')->with('success', 'tecnica registrada com sucesso!');
    }

    public function delete($id): ResponseInterface
    {
        $tecnicaModel = model(TecnicaModel::class);
        $tecnicaModel->delete($id);
        return redirect()->to('/tecnica')->with('success', 'tecnica excluida com sucesso!');
    }

    public function list(): string
    {
        $tecnicaModel = model(TecnicaModel::class);
        $data['title'] = 'tecnicas do Dojo';
        $data['tecnicas'] = $tecnicaModel->findAll();
        return view('tecnica/list', $data);
    }

}