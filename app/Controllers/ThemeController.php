<?php

namespace App\Controllers;

use App\Models\ThemeModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class ThemeController extends BaseController
{
    public function index(): string
    {
        $data['title'] = 'Temas';
        $themeModel = model(ThemeModel::class);
        $data['themes'] = $themeModel->findAll();
        return view('theme/index', $data);
    }

    public function create(): string
    {
        $data['title'] = 'Criar Novo Tema';
        return view('theme/create-edit', $data);
    }

    public function edit($id): string
    {
        $themeModel = model(ThemeModel::class);
        $data['title'] = 'Editar Tema';
        $data['theme'] = $themeModel->find($id);
        return view('theme/create-edit', $data);
    }

    public function save($id = null): RedirectResponse
    {
        $themeModel = model(ThemeModel::class);
        $request = $this->request;
        $iconImg = $this->request->getFile('icon');
        $logoImg = $this->request->getFile('logo');

        $validation = service('validation');
        if ($request->getMethod() === 'POST') {
            $data = $request->getPost();
        }

        $isEdit = isset($id);
        unset($data['submit']);
        $rules = [
            'name' => 'required',
        ];
        $validation->setRules($rules);
        $validation->run($data);
        $errors = $validation->getErrors();

        if (empty($errors)) {
            if ($iconImg->isValid() && !$iconImg->hasMoved()) {
                if ($isEdit) {
                    $theme = $themeModel->find($id);
                    if (!empty($data['icon'])) {
                        $icon = $theme['icon'];
                        if (file_exists('images/themes/'.$icon) && is_file('images/themes/'.$icon)) {
                            unlink('images/themes/'.$icon);       
                        }
                    }
                }
                $newName = $iconImg->getRandomName();
                $iconImg->move('images/themes', $newName);
                $data['icon'] = $newName;
            }
            if ($logoImg->isValid() && !$logoImg->hasMoved()) {
                if ($isEdit) {
                    $theme = $themeModel->find($id);
                    if (!empty($data['logo'])) {
                        $logo = $theme['logo'];
                        if (file_exists('images/themes/'.$logo) && is_file('images/themes/'.$logo)) {
                            unlink('images/themes/'.$logo);       
                        }
                    }
                }
                $newName = $logoImg->getRandomName();
                $logoImg->move('images/themes', $newName);
                $data['logo'] = $newName;
            }
            if ($isEdit) {
                try {
                    $themeModel->update($id, $data);
                } catch (\Throwable $th) {
                    $errors[] = $th->getMessage();
                }
            } else {
                try {
                    $themeModel->insert($data);
                } catch (\Throwable $th) {
                    $errors[] = $th->getMessage();
                }  
            }
        } else {
            return redirect()->back()->withInput()->with('errors', $errors);
        }
        return redirect()->to('/theme')->with('success', 'Tema registrada com sucesso!');
    }

    public function delete($id): ResponseInterface
    {
        $themeModel = model(ThemeModel::class);
        $themeModel->delete($id);
        return redirect()->to('/theme')->with('success', 'Tema excluida com sucesso!');
    }

    public function select($id): RedirectResponse
    {
        $themeModel = model(ThemeModel::class);
        $themeModel->update($themeModel->where('selected', 1)->first(), ['selected' => 0]);
        $theme = $themeModel->where('id', $id)->first();
        $themeModel->update($theme['id'], ['selected' => 1]);
        return redirect()->to('/theme')->with('success', 'Tema alterado para ' . $theme['name']);
    }
}
