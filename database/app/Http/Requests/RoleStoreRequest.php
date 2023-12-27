<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RoleStoreRequest extends ApiValidator
{
//    /**
//     * Determine if the user is authorized to make this request.
//     * @param User $user
//     * @return bool
//     */
//    public function authorize(User $user): bool
//    {
//        return true;
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'  =>  'required|string|max:255',
        ];
    }
}
