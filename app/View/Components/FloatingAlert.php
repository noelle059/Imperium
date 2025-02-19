<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FloatingAlert extends Component
{
    public $message;

    public function __construct($message = null)
    {
        $this->message = $message;
    }

    public function render()
    {
        return view('components.floating-alert');
    }
}