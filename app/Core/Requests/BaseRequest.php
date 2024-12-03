<?php

namespace App\Core\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseRequest extends FormRequest
{
    /**
     * Format the errors from the given Validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return array
     */
    protected function formatErrors(Validator $validator)
    {
        return $validator->getMessageBag()->toArray();
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // protected function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException($this->response(
    //         $this->formatErrors($validator)
    //     ));
    // }

    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        return new JsonResponse(['message' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $rules = $this->update();
        } elseif ($this->method() == 'POST') {
            $rules = $this->store();
        }

        return $rules;
    }

    /**
     * Get the validation rule that apply to store request
     *
     * @return array
     */
    protected function store(): array
    {
        return [];
    }

    /**
     * Get the validation rule that apply to update request
     *
     * @return array
     */
    protected function update(): array
    {
        return $this->store();
    }
}
