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
            'short_description_ar' => ['required', 'string', 'max:2000'],
            'short_description_en' => ['required', 'string', 'max:2000'],
            'long_description_ar' => ['required', 'string', 'max:60000'],
            'long_description_en' => ['required', 'string', 'max:60000'],
            'feature_description_ar' => ['nullable', 'string', 'max:20000'],
            'feature_description_en' => ['nullable', 'string', 'max:20000'],

            'published' => ['required', 'boolean'],

            'meta_title_ar' => ['nullable', 'string', 'max:255'],
            'meta_title_en' => ['nullable', 'string', 'max:255'],
            'meta_description_ar' => ['nullable', 'string'],
            'meta_description_en' => ['nullable', 'string'],

            'image' => ['nullable', 'image:allow_svg', 'mimes:jpg,jpeg,png,webp,svg', 'max:10240'],
            'country_ids' => ['nullable', 'array'],
            'country_ids.*' => ['exists:countries,id'],
            'faqs' => ['sometimes', 'array', 'min:1'],
            'faqs.*.question_ar' => ['required_with:faqs', 'string', 'max:255'],
            'faqs.*.question_en' => ['required_with:faqs', 'string', 'max:255'],
            'faqs.*.answer_ar' => ['required_with:faqs', 'string', 'max:2000'],
            'faqs.*.answer_en' => ['required_with:faqs', 'string', 'max:2000'],
            'faqs.*.published' => ['required_with:faqs', 'boolean'],
            'features' => ['sometimes', 'array', 'min:1'],
            'features.*.title_ar' => ['required_with:features', 'string', 'max:255'],
            'features.*.title_en' => ['required_with:features', 'string', 'max:255'],
            'features.*.description_ar' => ['required_with:features', 'string', 'max:2000'],
            'features.*.description_en' => ['required_with:features', 'string', 'max:2000'],
            'features.*.published' => ['required_with:features', 'boolean'],
            'features.*.image' => ['nullable', 'image:allow_svg', 'mimes:jpg,jpeg,png,webp,svg', 'max:10240'],

        ];
    }
    protected function prepareForValidation()
    {
        if (is_string($this->country_ids)) {
            $this->merge([
                'country_ids' => [$this->country_ids]
            ]);
        }
    }
}
