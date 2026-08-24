<?php

namespace App\Services\V1\Website\Setting;

use App\Models\Setting;

class SettingService
{
    public function getSettings()
    {
        $locale = app()->getLocale() ?? 'ar';

        return Setting::select([
            'id',
            "name_$locale as name",
            'phone',
            'email',
            'facebook',
            'x',
            'instagram',
            'linkedin',
            'whatsapp',
            'snapchat',
            'tiktok',
        ])
            ->with(['addresses' => fn ($query) => $query->select(['id', 'setting_id', "address_$locale as address"])])
            ->firstOrFail();
    }
}
