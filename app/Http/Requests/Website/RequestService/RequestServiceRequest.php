<?php

namespace App\Http\Requests\Website\RequestService;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RequestServiceRequest extends FormRequest
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
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'phone:AUTO'],
            'service_id' => ['required', 'exists:services,id'],
            'country_id' => ['required', 'exists:countries,id'],
            'additional_info' => ['nullable', 'array'],
            'additional_info.*' => ['nullable', 'string', 'max:500'],
        ];
    }
}
