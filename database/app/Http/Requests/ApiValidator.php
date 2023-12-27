<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ApiValidator extends FormRequest
{
    public function failedValidation(Validator $validator)
    {
        return response()
            ->json([
                'data'  =>  [],
                'error' => [
                    'code' => 422,
                    'message' =>'Validation error',
                    'errors' => $validator->errors(),
                ],
            ],422)
            ->throwResponse();
    }
}
