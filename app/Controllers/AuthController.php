<?php

namespace App\Controllers;

use Config\Services;

class AuthController extends BaseController
{
    
    public function login()
    {
        if (Services::auth()->isLoggedIn()) {
            return redirect()->to('/');
        }
        $request = $this->request;
        if ($request->getMethod() === 'POST') {
            $data = $request->getPost();
            if (Services::auth()->login($data['username'], $data['password'])) {
                return redirect()->to('/',);
            } else {
                return redirect()->back()->with('errors', ['login' => 'Usuário ou senha inválido']);
            }
        }
        $theme = Services::theme()->getTheme();
        return view('auth/login', ['theme' => $theme]);
    }

    public function logout()
    {
        Services::auth()->logout();
        return redirect()->to('/');
    }

}
