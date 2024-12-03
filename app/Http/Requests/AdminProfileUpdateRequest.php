<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            "name" => ["string", "max:255"],
            "address" => ["required", "string", "max:100"],
            "phone_number" => ["required", "min:10", "max:20"],
            "password" => "sometimes|confirmed|min:6",
            "old_password" => "required_with:password|current_password",
        ];
    }
}
