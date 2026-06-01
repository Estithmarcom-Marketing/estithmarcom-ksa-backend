<?php

namespace App\Http\Requests\Admin\RequestResidency;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enum\RequestResidencyStatusEnum;
class ListRequestResidenciesRequest extends FormRequest
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
            'status' => ['sometimes', 'integer', Rule::in(RequestResidencyStatusEnum::values())],
            'residency_id' => ['sometimes', 'integer', 'exists:residencies,id'],
        ];
    }
}
