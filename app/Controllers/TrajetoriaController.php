<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TrajetoriaController extends BaseController
{
    public function index()
    {
        $data['title'] = 'Trajetoria';
        return view('trajetoria/index', $data);
    }
}
