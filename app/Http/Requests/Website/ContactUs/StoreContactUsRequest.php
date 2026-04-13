<?php

namespace App\Http\Requests\Website\ContactUs;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreContactUsRequest extends FormRequest
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
            'email' => ['sometimes', 'string', 'email:rfc,dns', 'max:255'],
            'phone' => ['required', 'string', 'phone:AUTO'],
            'message' => ['required', 'string', 'max:5000'],
        ];
    }
}
