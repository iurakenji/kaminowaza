<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;
use Exception;

class UserController extends BaseController
{
    public function index(string $page = 'index'): string
    {
        if (! is_file(APPPATH . 'Views/user/' . $page . '.php')) {
            throw new PageNotFoundException($page);
        }
        $userModel = model(UserModel::class);
        $data['users'] = $userModel->findAll();

        return view('user/' . $page, ['title' => 'Usuários', 'data' => $data]);
    }

    public function create(): string
    {
        return view('user/create-edit', ['title' => 'Criar Usuário']);
    }

    public function edit($id): string
    {
        $userModel = model(UserModel::class);
        $title = 'Editar Usuário';
        $user = $userModel->find($id);
        return view('user/create-edit', ['title' => $title, 'user' => $user]);
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
        $graduacoes = implode(',', array_keys(GRADUACOES));
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