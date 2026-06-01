<?php

namespace App\Http\Requests\Website\RequestResidency;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RequestResidencyRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email:rfc,dns', 'max:255'],
            'phone' => ['required', 'string', 'phone:AUTO'],
            'residency_id' => ['required', 'exists:residencies,id'],
            'city' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:60000'],
        ];
    }
}
