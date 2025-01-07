<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

class Home extends BaseController
{
    public function index(string $page = 'home'): string
    {
        //if (! is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
          //  throw new PageNotFoundException($page);
        //}
        
        $title = '';

        return view($page, ['title' => $title]);
    }
}