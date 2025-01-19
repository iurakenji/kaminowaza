<?php

namespace App\Controllers;

use Exception;
use App\Models\UserModel;
use App\Models\GraduacaoModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Exceptions\PageNotFoundException;

class UserController extends BaseController
{
    public function index(string $page = 'index'): string
    {
        $userModel = model(UserModel::class);
        $data['title'] = 'Usuários';
        $data['users'] = $userModel->findAll();
        $graduacaoModel = model(GraduacaoModel::class);
        $data['graduacoes'] = $graduacaoModel->findAll();
        $data['graduacoes'] = array_combine(array_column($data['graduacoes'], 'id'),array_column($data['graduacoes'], 'nome'));

        return view('user/' . $page, $data);
    }

    public function create(): string
    {
        $data['title'] = 'Inserir Novo Usuário';
        $graduacaoModel = model(GraduacaoModel::class);
        $data['graduacoes'] = $graduacaoModel->findAll();
        $data['graduacoes'] = array_combine(array_column($data['graduacoes'], 'id'),array_column($data['graduacoes'], 'nome'));
        return view('user/create-edit', $data);
    }

    public function edit($id): string
    {
        $userModel = model(UserModel::class);
        $data['title'] = 'Editar Usuário';
        $data['user'] = $userModel->find($id);
        $graduacaoModel = model(GraduacaoModel::class);
        $data['graduacoes'] = $graduacaoModel->findAll();
        $data['graduacoes'] = array_combine(array_column($data['graduacoes'], 'id'),array_column($data['graduacoes'], 'nome'));
        return view('user/create-edit', $data);
    }

    public function save($id = null): RedirectResponse{
        $userModel = model(UserModel::class);
        $request = $this->request;
        $validation = service('validation');
        $image = $this->request->getFile('image_path');
        if ($request->getMethod() === 'POST') {
            $data = $request->getPost();
        }
        $isEdit = isset($id);
        unset($data['submit']);
        $graduacaoModel = model(GraduacaoModel::class);
        $graduacoes = $graduacaoModel->findAll();
        $graduacoes = implode(',', array_column($graduacoes, 'id'));
        $rules = [
            'username' => 'required',
            'nome' => 'required',
            'tipo' => 'required|in_list[aluno,professor,admin]',
            'dn' => 'required|date',
            'sexo' => 'required',
            'telefone' => 'required',
            'graduacao' => "required|in_list[$graduacoes]",
            'inicio_treinos' => 'required|date',
        ];
        $validation->setRules($rules);
        $validation->run($data);
        $errors = $validation->getErrors();

        if (empty($errors)) {
            if ($image->isValid() && !$image->hasMoved()) {
                if ($isEdit) {
                    $user = $userModel->find($id);
                    if (!empty($data['image_path'])) {
                        $image_path = $user['image_path'];
                        if (file_exists('images/users/'.$image_path) && is_file('images/users/'.$image_path)) {
                            unlink('images/users/'.$image_path);   
                        }  
                        $newName = $image->getRandomName();
                        $image->move('images/users', $newName);
                        $data['image_path'] = $newName;
                    }
                }
            }
            if ($isEdit) {
                $data['updated_at'] = date('Y-m-d H:i:s');
                $userModel->update($id, $data);                
            } else {
                $data['active'] = 1;
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                $data['created_at'] = date('Y-m-d H:i:s');
                $userModel->insert($data);
            }
        } else {
            dd($errors);
        }
        return redirect()->to('/user')->with('success', 'Usuário salvo com sucesso!');
    }
}