<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DashboardTopBidders extends Component
{
    public object $topBidders;
    public function __construct(object $topBidders)
    {
        $this->topBidders = $topBidders;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.dashboard-top-bidders');
    }
}
