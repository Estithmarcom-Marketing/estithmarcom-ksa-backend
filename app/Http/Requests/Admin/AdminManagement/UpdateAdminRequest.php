<?php

namespace App\Http\Requests\Admin\AdminManagement;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdminRequest extends FormRequest
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
        $adminId = $this->getAdminId();

        return [
            'name' => 'sometimes|string|max:255',
            'email' => [
                'sometimes',
                'email:rfc,dns',
                Rule::unique('users', 'email')->ignore($adminId),
            ],
            'phone' => 'sometimes|nullable|string|phone:AUTO',
            'password' => 'sometimes|string|min:8|confirmed',
        ];
    }

    private function getAdminId(): ?int
    {
        $admin = $this->route('admin');

        if ($admin instanceof User) {
            return $admin->id;
        }

        if (is_numeric($admin)) {
            return (int) $admin;
        }

        return auth('api')->id();
    }
}
