<?php

namespace App\Http\Requests\Admin\Service;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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

            'title_ar' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'slug_ar' => ['nullable', 'string', 'max:255', 'unique:services,slug_ar'],
            'slug_en' => ['nullable', 'string', 'max:255', 'unique:services,slug_en'],
            'short_description_ar' => ['required', 'string'],
            'short_description_en' => ['required', 'string'],
            'long_description_ar' => ['required', 'string'],
            'long_description_en' => ['required', 'string'],

            'published' => ['required', 'boolean'],

            'meta_title_ar' => ['nullable', 'string', 'max:255'],
            'meta_title_en' => ['nullable', 'string', 'max:255'],
            'meta_description_ar' => ['nullable', 'string'],
            'meta_description_en' => ['nullable', 'string'],

            'image' => ['required', 'image:allow_svg', 'mimes:jpg,jpeg,png,webp,svg', 'max:10240'],

        ];
    }
}
