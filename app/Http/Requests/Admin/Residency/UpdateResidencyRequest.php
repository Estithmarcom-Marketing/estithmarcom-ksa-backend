<?php

namespace App\Http\Requests\Admin\Residency;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

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
            'meta_title_ar' => ['sometimes', 'nullable', 'string', 'max:255'],
            'meta_title_en' => ['sometimes', 'nullable', 'string', 'max:255'],
            'meta_description_ar' => ['sometimes', 'nullable', 'string', 'max:255'],
            'meta_description_en' => ['sometimes', 'nullable', 'string', 'max:255'],
            'country_id' => ['sometimes', 'exists:countries,id'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],

        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $residency = $this->route('residency');

            $targetType = $this->exists('chat_target_type')
                ? $this->input('chat_target_type')
                : $residency?->chat_target_type;

            $targetId = $this->exists('chat_target_id')
                ? $this->input('chat_target_id')
                : $residency?->chat_target_id;

            if (filled($targetType) !== filled($targetId)) {
                $message = 'Chat target type and chat target ID must be provided together.';

                $validator->errors()->add('chat_target_type', $message);
                $validator->errors()->add('chat_target_id', $message);
            }
        });
    }
}
