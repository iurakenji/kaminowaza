<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;


class NavBarCell extends Cell
{
    public $user;
    public $theme;

    public function render(): string
    {
        $theme = \Config\Services::theme()->getTheme();
        $user = \Config\Services::auth()->user();
        return $this->view('nav_bar', ['user' => $user, 'theme' => $theme]);
    }

}
