<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidProductId extends FormRequest
{
    protected $redirectRoute = "page.not.found";

    public function rules(): array
    {
        $productId = $this->route()->parameter("product");
        $this->merge(["product_id" => $productId]);

        return [
            "product_id" => "required|string|exists:products,id,status,1,approved,1",
        ];
    }
}
