<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

class Home extends BaseController
{
    public function index(): string
    {
        $data['title'] = '';
        $data['cards'] = [];

        return view('home', $data);
    }
}