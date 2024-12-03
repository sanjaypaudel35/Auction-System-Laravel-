<?php

namespace App\View\Components;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UpcomingAuctionCard extends Component
{
    public Product $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.upcoming-auction-card');
    }
}
