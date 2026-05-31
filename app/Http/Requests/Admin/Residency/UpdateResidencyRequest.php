<?php

namespace App\Http\Requests\Admin\Residency;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateResidencyRequest extends FormRequest
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
        $residencyId = $this->route('residency')->id;
        return [
            'title_ar' => ['sometimes', 'string', 'max:255'],
            'title_en' => ['sometimes', 'string', 'max:255'],
            'description_ar' => ['sometimes', 'string', 'max:60000'],
            'description_en' => ['sometimes', 'string', 'max:60000'],
            'slug_ar' => ['sometimes', 'string', 'max:255', 'unique:residencies,slug_ar,' . $residencyId],
            'slug_en' => ['sometimes', 'string', 'max:255', 'unique:residencies,slug_en,' . $residencyId],
            'published' => ['sometimes', 'boolean'],
            'meta_title_ar' => ['sometimes', 'nullable', 'string', 'max:255'],
            'meta_title_en' => ['sometimes', 'nullable', 'string', 'max:255'],
            'meta_description_ar' => ['sometimes', 'nullable', 'string', 'max:255'],
            'meta_description_en' => ['sometimes', 'nullable', 'string', 'max:255'],
            'country_id' => ['sometimes', 'exists:countries,id'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],

        ];
    }
}
