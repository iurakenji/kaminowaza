<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class ErrorMessageCell extends Cell
{
    public $type;
    public $id;
    public $message;

    public function render(): string
    {
        return $this->view('error_message', ['id' => $this->id, 'type' => $this->type, 'message' => $this->message]);
    }
}
