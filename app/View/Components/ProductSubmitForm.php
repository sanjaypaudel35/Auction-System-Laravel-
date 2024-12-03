<?php

namespace App\View\Components;

use App\Models\Product;
use App\Repositories\CategoryRepository;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductSubmitForm extends Component
{
    protected Product $product;

    public function __construct(
        protected CategoryRepository $categoryRepository,
        ?Product $product = null
    ) {
        $this->product = $product;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $categories = $this->categoryRepository->fetchAll(["no_paginate" => true]);
        $product = $this->product;
        return view('components.frontend.product-submit-form', compact("categories", "product"));
    }
}
