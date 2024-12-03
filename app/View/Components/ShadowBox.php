<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ShadowBox extends Component
{
    public string $shadowClass;
    public bool $enableBorderRadius;

    public function __construct(string $shadowClass = "shadow-sm", bool $enableBorderRadius = false)
    {
        $this->shadowClass = $shadowClass;
        $this->enableBorderRadius = $enableBorderRadius;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.shadow-box');
    }
}
