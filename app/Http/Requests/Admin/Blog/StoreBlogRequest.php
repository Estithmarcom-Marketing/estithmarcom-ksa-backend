<?php

namespace App\Http\Requests\Admin\Blog;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
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
            'subtitle_ar' => ['required', 'string', 'max:255'],
            'subtitle_en' => ['required', 'string', 'max:255'],
            'short_content_ar' => ['required', 'string', 'max:255'],
            'short_content_en' => ['required', 'string', 'max:255'],
            'content_ar' => ['required', 'string'],
            'content_en' => ['required', 'string'],
            'published' => ['required', 'boolean'],
            'slug_ar' => ['nullable', 'string', 'max:255', 'unique:blogs,slug_ar'],
            'slug_en' => ['nullable', 'string', 'max:255', 'unique:blogs,slug_en'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'meta_title_ar' => ['required', 'string', 'max:255'],
            'meta_title_en' => ['required', 'string', 'max:255'],
            'meta_description_ar' => ['required', 'string', 'max:255'],
            'meta_description_en' => ['required', 'string', 'max:255'],
        ];
    }
}
