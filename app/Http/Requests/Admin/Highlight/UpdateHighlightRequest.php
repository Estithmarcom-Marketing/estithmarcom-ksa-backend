<?php

namespace App\Http\Requests\Admin\Highlight;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateHighlightRequest extends FormRequest
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
            'label_en' => ['sometimes', 'string', 'max:255'],
            'label_ar' => ['sometimes', 'string', 'max:255'],
            'value_en' => ['sometimes', 'integer'],
            'value_ar' => ['sometimes', 'integer'],
            'image' => ['nullable', 'image:allow_svg', 'mimes:jpg,jpeg,png,webp,svg', 'max:10240'],
        ];
    }
}
