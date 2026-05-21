<?php

namespace App\Http\Requests\Admin\Service;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServiceRequest extends FormRequest
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
        $serviceId = $this->route('service')->id;

        return [
            'title_ar' => ['sometimes', 'string', 'max:255'],
            'title_en' => ['sometimes', 'string', 'max:255'],

            'short_description_ar' => ['sometimes', 'string'],
            'short_description_en' => ['sometimes', 'string'],

            'long_description_ar' => ['sometimes', 'string'],
            'long_description_en' => ['sometimes', 'string'],

            'published' => ['sometimes', 'boolean'],

            'meta_title_ar' => ['nullable', 'string', 'max:255'],
            'meta_title_en' => ['nullable', 'string', 'max:255'],

            'meta_description_ar' => ['nullable', 'string'],
            'meta_description_en' => ['nullable', 'string'],

            'slug_ar' => ['nullable', 'string', 'max:255', Rule::unique('services', 'slug_ar')->ignore($serviceId)],
            'slug_en' => ['nullable', 'string', 'max:255', Rule::unique('services', 'slug_en')->ignore($serviceId)],

            'image' => ['nullable', 'image:allow_svg', 'mimes:jpg,jpeg,png,webp,svg', 'max:10240'],
            'country_ids' => ['nullable', 'array'],
            'country_ids.*' => ['exists:countries,id'],
            'faqs' => ['nullable', 'array'],
            'faqs.*.question_ar' => ['required_with:faqs', 'string', 'max:255'],
            'faqs.*.question_en' => ['required_with:faqs', 'string', 'max:255'],
            'faqs.*.answer_ar' => ['required_with:faqs', 'string', 'max:2000'],
            'faqs.*.answer_en' => ['required_with:faqs', 'string', 'max:2000'],
            'faqs.*.published' => ['required_with:faqs', 'boolean'],
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
