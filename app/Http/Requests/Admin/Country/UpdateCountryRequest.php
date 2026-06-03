<?php

namespace App\Http\Requests\Admin\Country;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCountryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name_ar' => ['sometimes', 'string', 'max:255'],
            'name_en' => ['sometimes', 'string', 'max:255'],
            'title_ar' => ['sometimes', 'string', 'max:255'],
            'title_en' => ['sometimes', 'string', 'max:255'],
            'description_ar' => ['sometimes', 'string', 'max:255'],
            'description_en' => ['sometimes', 'string', 'max:255'],
            'image' => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:10240'],
            'active' => ['sometimes', 'boolean'],
        ];
    }
}
