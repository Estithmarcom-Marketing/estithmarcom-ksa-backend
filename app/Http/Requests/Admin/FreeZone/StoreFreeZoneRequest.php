<?php

namespace App\Http\Requests\Admin\FreeZone;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreFreeZoneRequest extends FormRequest
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
            'slug_ar' => ['sometimes', 'string', 'max:255', 'unique:free_zones,slug_ar'],
            'slug_en' => ['sometimes', 'string', 'max:255', 'unique:free_zones,slug_en'],
            'active' => ['required', 'boolean'],
            'content_ar' => ['required', 'string'],
            'content_en' => ['required', 'string'],
            'image' => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:10240'],
            'faqs' => ['sometimes', 'array', 'min:1'],
            'faqs.*.question_ar' => ['required_with:faqs', 'string', 'max:255'],
            'faqs.*.question_en' => ['required_with:faqs', 'string', 'max:255'],
            'faqs.*.answer_ar' => ['required_with:faqs', 'string', 'max:2000'],
            'faqs.*.answer_en' => ['required_with:faqs', 'string', 'max:2000'],
            'faqs.*.published' => ['required_with:faqs', 'boolean'],
        ];
    }
}
