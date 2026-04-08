<?php

namespace App\Http\Requests\Admin\RequestService;

use App\Enum\RequestServiceStatusEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListRequestServicesRequest extends FormRequest
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
            'page' => ['sometimes', 'integer', 'min:1'],
            'per_page' => ['sometimes', 'integer', 'between:1,50'],
            'search' => ['sometimes', 'string', 'max:255'],
            'status' => ['sometimes', 'integer', Rule::in(RequestServiceStatusEnum::values())],
            'service_id' => ['sometimes', 'integer', 'exists:services,id'],
            'country_id' => ['sometimes', 'integer', 'exists:countries,id'],
        ];
    }
}
