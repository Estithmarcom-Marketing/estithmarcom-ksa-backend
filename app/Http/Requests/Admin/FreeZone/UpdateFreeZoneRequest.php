<?php

namespace App\Http\Requests\Admin\FreeZone;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFreeZoneRequest extends FormRequest
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
        $freeZoneId = $this->route('freeZone')->id;
        return [
            'title_ar' => ['sometimes', 'string', 'max:255'],
            'title_en' => ['sometimes', 'string', 'max:255'],
            'slug_ar' => ['sometimes', 'string', 'max:255', Rule::unique('free_zones', 'slug_ar')->ignore($freeZoneId)],
            'slug_en' => ['sometimes', 'string', 'max:255', Rule::unique('free_zones', 'slug_en')->ignore($freeZoneId)],
            'active' => ['sometimes', 'boolean'],
            'content_ar' => ['sometimes', 'string'],
            'content_en' => ['sometimes', 'string'],
            'image' => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:10240'],
        ];
    }
}
