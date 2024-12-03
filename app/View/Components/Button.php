<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public string $buttonClass;
    public function __construct($buttonClass = "btn btn-default")
    {
        $this->buttonClass = $buttonClass;
    }

    public function render(): View|Closure|string
    {
        return view('components.dashboard.button');
    }
}
