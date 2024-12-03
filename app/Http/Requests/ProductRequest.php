<?php

namespace App\Http\Requests;

use App\Core\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends BaseRequest
{
    protected function store(): array
    {
        if (!array_key_exists("show_product_owner", $this->toArray())) {
            $this->merge(["show_product_owner" => 0]);
        } else {
            $this->merge(["show_product_owner" => 1]);
        }

        if (!array_key_exists("price_limit", $this->toArray())) {
            $this->merge(["price_limit" => 0]);
        } else {
            $this->merge(["price_limit" => 1]);
        }

        return [
            "name" => "required|string",
            "description" => "sometimes|required|string",
            "commission_offer" => "sometimes|nullable|numeric",
            "category_id" => "required|exists:categories,id,status,1",
            "show_product_owner" => "sometimes|boolean",
            "price_limit" => "sometimes|boolean",
            "bid_increment_amount" => [
                "required",
                "numeric",
                function ($attribute, $value, $fail) {
                    $startPrice = $this->input('start_price');
                    $endPrice = $this->input('end_price');

                    if ($endPrice && $value >= $endPrice - $startPrice) {
                        $fail("$attribute must be less than the difference between start_price and end_price.");
                    }
                },
            ],
            "start_price" => "required|numeric",
            "end_price" => "required_if:price_limit,0|nullable|numeric|gt:start_price",
            "start_date" => "required|date|after_or_equal:" . now()->format('Y-m-d'),
            "end_date" => "required|date|after:start_date|after:" . now()->format('Y-m-d'),
            "position" => "sometimes|nullable|integer",
            "parent" => "sometimes|boolean",
            "status" => "sometimes|boolean",
            "image" => "required|mimes:jpg,png,jpeg|max:800"
        ];
    }

    protected function update(): array
    {
        $storeRule = $this->store();
        $storeRule["image"] = "sometimes|mimes:jpg,png,jpeg|max:800";
        unset($storeRule["category_id"]);
        return $storeRule;
    }
}
