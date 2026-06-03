<?php

namespace App\Http\Requests\Admin\Blog;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBlogRequest extends FormRequest
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
        $blogId = $this->blog->id;

        return [
            'title_ar' => ['sometimes', 'string', 'max:255'],
            'title_en' => ['sometimes', 'string', 'max:255'],
            'subtitle_ar' => ['sometimes', 'string', 'max:255'],
            'subtitle_en' => ['sometimes', 'string', 'max:255'],
            'short_content_ar' => ['sometimes', 'string', 'max:255'],
            'short_content_en' => ['sometimes', 'string', 'max:255'],
            'content_ar' => ['sometimes', 'string'],
            'content_en' => ['sometimes', 'string'],
            'published' => ['sometimes', 'boolean'],

            'slug_ar' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('blogs', 'slug_ar')->ignore($blogId),
            ],

            'slug_en' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('blogs', 'slug_en')->ignore($blogId),
            ],

            'image' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],

            'meta_title_ar' => ['sometimes', 'string', 'max:255'],
            'meta_title_en' => ['sometimes', 'string', 'max:255'],
            'meta_description_ar' => ['sometimes', 'string', 'max:255'],
            'meta_description_en' => ['sometimes', 'string', 'max:255'],
            'category_id' => ['sometimes', 'exists:categories,id'],
        ];
    }
}
