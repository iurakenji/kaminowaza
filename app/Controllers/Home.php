<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

class Home extends BaseController
{
    public function index(): string
    {
        $data['title'] = '';
        $data['cards'] = [];

        return view('home/home', $data);
    }

    public function dash(): string
    {
        $data['title'] = 'Dashboard';

        return view('home/dash', $data);
    }

    public function estatuto(): string
    {
        $data['title'] = 'Estatuto do Instituto Sergio Murilo Pereira';

        return view('home/estatuto', $data);
    }
}