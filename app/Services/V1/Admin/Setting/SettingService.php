<?php

namespace App\Services\V1\Admin\Setting;

use App\Models\Setting;

class SettingService
{
    public function index()
    {
        return Setting::first();
    }

    public function update(array $data)
    {
        $info = Setting::firstOrFail();

        $data['phone'] = isset($data['phone'])
            ? str_replace(['+', ' ', '-'], '', $data['phone'])
            : $info->phone;

        $info->update($data);

        return $info->refresh();
    }
}
