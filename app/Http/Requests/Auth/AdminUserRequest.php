<?php

namespace App\Http\Requests\Auth;

use App\Core\Requests\BaseRequest;

class AdminUserRequest extends BaseRequest
{
    protected $redirectRoute = "dashboard.users.create";

    protected function store(): array
    {
        return [
            "name" => "required|string",
            "email" => "required|email|unique:users,email",
            "password" => "required|confirmed|min:8",
        ];
    }

    protected function update(): array
    {
        $storeRule = $this->store();

        return $storeRule;
    }
}
