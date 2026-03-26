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

        $phone = isset($data['phone'])
            ? str_replace(['+', ' ', '-'], '', $data['phone'])
            : $info->phone;

        $info->update([
            'name_ar' => $data['name_ar'] ?? $info->name_ar,
            'name_en' => $data['name_en'] ?? $info->name_en,
            'phone' => $phone,
            'email' => $data['email'] ?? $info->email,
            'address' => $data['address'] ?? $info->address,
            'facebook' => $data['facebook'] ?? $info->facebook,
            'x' => $data['x'] ?? $info->x,
            'instagram' => $data['instagram'] ?? $info->instagram,
            'linkedin' => $data['linkedin'] ?? $info->linkedin,
            'whatsapp' => $data['whatsapp'] ?? $info->whatsapp,
            'snapchat' => $data['snapchat'] ?? $info->snapchat,
            'tiktok' => $data['tiktok'] ?? $info->tiktok,
        ]);

        return $info->refresh();
    }
}
