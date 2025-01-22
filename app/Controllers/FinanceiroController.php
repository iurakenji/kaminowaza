<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class FinanceiroController extends BaseController
{
    public function index()
    {
        $data['title'] = 'Financeiro';
        return view('financeiro/index', $data);
    }
}
