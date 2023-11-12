<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisementUpdateRequest extends ApiValidator
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'advertisement.title' => 'alpha_num|string|max:255',
            'advertisement.description' => 'string|max:4000',
            'advertisement.location' => 'string',
            'categoryFields' => 'array',
            'categoryFields.*' => 'integer|exists:category_fields,id',
        ];
    }
}
