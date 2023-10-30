<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
//    /**
//     * Determine if the user is authorized to make this request.
//     */
//    public function authorize(): bool
//    {
//        return false;
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user.name'  =>  'string|alpha',
            'user.email' =>  'email|unique:users,email',
            'user.login' =>  'string',
            'user.password'  =>  'string|min:10|max:30',
            'role_id'   =>  'exists:roles,id',
        ];
    }
}
