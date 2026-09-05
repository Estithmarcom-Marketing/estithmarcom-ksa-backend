<?php

namespace App\Http\Requests\Admin\Service;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

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
            'features' => ['nullable', 'array'],
            'features.*.id' => [
                'nullable',
                'integer',
                Rule::exists('service_features', 'id')->where(function ($query) use ($serviceId) {
                    $query->where('service_id', $serviceId);
                }),
            ],
            'features.*.title_ar' => ['sometimes', 'string', 'max:255'],
            'features.*.title_en' => ['sometimes', 'string', 'max:255'],
            'features.*.description_ar' => ['sometimes', 'string', 'max:2000'],
            'features.*.description_en' => ['sometimes', 'string', 'max:2000'],
            'features.*.published' => ['sometimes', 'boolean'],
            'features.*.image' => ['nullable', 'image:allow_svg', 'mimes:jpg,jpeg,png,webp,svg', 'max:10240'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $service = $this->route('service');

            $targetType = $this->exists('chat_target_type')
                ? $this->input('chat_target_type')
                : $service?->chat_target_type;

            $targetId = $this->exists('chat_target_id')
                ? $this->input('chat_target_id')
                : $service?->chat_target_id;

            if (filled($targetType) !== filled($targetId)) {
                $message = 'Chat target type and chat target ID must be provided together.';

                $validator->errors()->add('chat_target_type', $message);
                $validator->errors()->add('chat_target_id', $message);
            }
        });
    }

    protected function prepareForValidation()
    {
        // country_ids fix
        if (is_string($this->country_ids)) {
            $this->merge([
                'country_ids' => [$this->country_ids],
            ]);
        }

        // features fix
        if ($this->has('features')) {

            $features = $this->input('features');

            // if JSON string -> decode
            if (is_string($features)) {
                $decoded = json_decode($features, true);
                $features = is_array($decoded) ? $decoded : [];
            }

            // ensure it's always array
            if (! is_array($features)) {
                $features = [];
            }

            $this->merge([
                'features' => $features,
            ]);
        }
    }
}
