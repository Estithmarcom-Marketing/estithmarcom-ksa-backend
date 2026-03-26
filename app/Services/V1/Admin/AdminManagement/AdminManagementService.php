<?php

namespace App\Services\V1\Admin\AdminManagement;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminManagementService
{
    public function index(array $data)
    {
        $per_page = $data['per_page'] ?? 10;

        return User::paginate($per_page);
    }

    public function getAuthenticatedUser()
    {
        return auth('sanctum')->user();
    }

    public function store(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function destroy(User $admin)
    {
        if ($admin->id === 1) {
            throw new \LogicException(__('admin.super_admin_cannot_delete'));
        }
        $admin->delete();
    }

    public function update(User $admin, array $data)
    {
        $user = auth('api')->user();
        if ($user->id !== 1) {
            throw new \LogicException(__('admin.only_super_admin_can_update'));
        }

        return $this->updateAdmin($admin, $data);
    }

    public function updateProfile(array $data)
    {
        $admin = auth('api')->user();

        return $this->updateAdmin($admin, $data);

    }

    private function updateAdmin(User $admin, array $data)
    {
        $admin->update([
            'name' => $data['name'] ?? $admin->name,
            'email' => $data['email'] ?? $admin->email,
            'password' => isset($data['password'])
                ? Hash::make($data['password'])
                : $admin->password,
        ]);

        return $admin->refresh();
    }
}
