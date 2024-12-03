<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormInput extends Component
{
    public string $type;
    public string $name;
    public ?string $value;

    public string $placeholder;

    public function __construct(
        string $type = "text",
        string $name = "name",
        string $placeholder = "placeholder",
        ?string $value = null
    ) {
        $this->type = $type;
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->value = $value;
    }

    public function render(): View|Closure|string
    {
        return view('components.dashboard.from-input');
    }
}
