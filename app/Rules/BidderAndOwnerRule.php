<?php

namespace App\Rules;

use App\Repositories\ProductRepository;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class BidderAndOwnerRule implements ValidationRule
{
    public function __construct(
        protected ProductRepository $productRepository
    ) {

    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $productId = request("product_id");
        $product = $this->productRepository->fetch($productId);
        if (Auth::user()->id == $product->user_id) {
            $fail("Product owner is not allowed to bid.");
        }
    }
}
