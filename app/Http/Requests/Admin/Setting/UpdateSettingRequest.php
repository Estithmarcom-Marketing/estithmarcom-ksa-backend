<?php

namespace App\Http\Requests\Admin\Setting;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
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
            'name_ar' => 'sometimes|string|max:255',
            'name_en' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|regex:/^9665\d{8}$/',
            'email' => 'sometimes|email:rfc,dns',
            'address' => 'sometimes|string|max:255',
            'facebook' => 'sometimes|url',
            'x' => 'sometimes|url',
            'instagram' => 'sometimes|url',
            'linkedin' => 'sometimes|url',
            'whatsapp' => 'sometimes|string|max:255',
            'snapchat' => 'sometimes|string|max:255',
            'tiktok' => 'sometimes|url',
        ];
    }
}
