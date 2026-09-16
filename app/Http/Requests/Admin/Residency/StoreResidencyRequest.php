<?php

namespace App\Http\Requests\Admin\Residency;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreResidencyRequest extends FormRequest
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
            'description_ar' => ['required', 'string', 'max:60000'],
            'description_en' => ['required', 'string', 'max:60000'],
            'slug_ar' => ['nullable', 'string', 'max:255', 'unique:residencies,slug_ar'],
            'slug_en' => ['nullable', 'string', 'max:255', 'unique:residencies,slug_en'],
            'published' => ['required', 'boolean'],
            'chat_target_type' => [
                'nullable',
                'string',
                Rule::in(['category', 'group', 'service']),
                'required_with:chat_target_id',
            ],
            'chat_target_id' => [
                'nullable',
                'string',
                'max:128',
                'regex:/\A[A-Za-z0-9][A-Za-z0-9_-]*\z/',
                'required_with:chat_target_type',
            ],
            'meta_title_ar' => ['nullable', 'string', 'max:255'],
            'meta_title_en' => ['nullable', 'string', 'max:255'],
            'meta_description_ar' => ['nullable', 'string', 'max:255'],
            'meta_description_en' => ['nullable', 'string', 'max:255'],
            'country_id' => ['required', 'exists:countries,id'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ];
    }
}
