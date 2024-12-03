<?php

namespace App\Http\Requests\User;

use App\Core\Requests\BaseRequest;

class CustomerRequest extends BaseRequest
{
   protected function update(): array
   {
        return [
            "name" => "required|string",
            "phone_number" => "required|string|min:10",
            "address" => "sometimes|string",
        ];
   }
}
