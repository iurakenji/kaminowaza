<?php

namespace App\Services;

class AuthService
{
    protected $session;

    public function __construct()
    {
        $this->session = service('session');
    }

    public function login(string $username, string $password): bool
    {
        $user = db_connect()->table('users')
            ->where('username', $username)
            ->get()
            ->getRow();

        if ($user && password_verify($password, $user->password)) {
            $this->session->set('user', [
                'id' => $user->id,
                'username' => $user->username,
                'nome' => $user->nome,
                'tipo' => $user->tipo,
                'email' => $user->email
            ]);
            return true;
        }

        return false;
    }

    public function logout()
    {
        $this->session->remove('user');
    }

    public function isLoggedIn(): bool
    {
        return $this->session->has('user');
    }

    public function user()
    {
        return $this->session->get('user');
    }
}
