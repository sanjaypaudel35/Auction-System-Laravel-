<?php

namespace App\Http\Requests;

use App\Core\Requests\BaseRequest;

class CategoryRequest extends BaseRequest
{
    protected $redirectRoute = "dashboard.categories.create";

    protected function store(): array
    {
        return [
            "name" => "required|string",
            "description" => "sometimes|nullable|string",
            "position" => "sometimes|integer",
            "parent" => "sometimes|boolean",
            "status" => "sometimes|boolean",
        ];
    }

    protected function update(): array
    {
        $storeRule = $this->store();
        return $storeRule;
    }
}
