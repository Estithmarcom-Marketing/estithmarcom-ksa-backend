<?php

namespace App\Http\Requests\Admin\Client;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
            'image' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'alt' => ['sometimes', 'string', 'max:255'],
            'link' => ['sometimes', 'url'],
            'published' => ['sometimes', 'boolean']
        ];
    }
}
