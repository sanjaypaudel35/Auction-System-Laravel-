<?php

namespace App\Rules;

use App\Repositories\ProductRepository;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BidAmountRule implements ValidationRule
{
    public function __construct(
        protected ProductRepository $productRepository
    ) {

    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $productId = request("product_id");
        $product = $this->productRepository->fetch($productId);
        $topBid = $product->topBids->first()?->bid_amount;

        $allowedBid = $product->start_price;
        if ($topBid) {
            $allowedBid = ($topBid + $product->bid_increment_amount);
        }

        if (
            $value < $product->start_price
            || $value < $allowedBid
            || (!$product->price_limit && $value > $product->end_price)
        ) {
            $fail("Invalid bid amount.");
        }
    }
}
