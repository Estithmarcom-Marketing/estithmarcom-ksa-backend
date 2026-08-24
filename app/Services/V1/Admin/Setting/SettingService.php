<?php

namespace App\Services\V1\Admin\Setting;

use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class SettingService
{
    public function index()
    {
        return Setting::with('addresses')->first();
    }

    public function update(array $data)
    {
        return DB::transaction(function () use ($data) {
            $info = Setting::firstOrFail();

            $data['phone'] = isset($data['phone'])
                ? str_replace(['+', ' ', '-'], '', $data['phone'])
                : $info->phone;

            $addresses = $data['addresses'] ?? null;
            unset($data['addresses']);

            $info->update($data);

            if ($addresses !== null) {
                $info->addresses()->delete();
                $info->addresses()->createMany($addresses);
            }

            return $info->fresh('addresses');
        });
    }
}
