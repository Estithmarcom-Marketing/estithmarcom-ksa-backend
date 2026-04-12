<?php

namespace App\Services\V1\Website\FreeZone;

use App\Models\FreeZone;

class FreeZoneService
{
    public function list(array $data)
    {
        $per_page = $data['per_page'] ?? 10;
        $locale = app()->getLocale();
        return FreeZone::select(
            'id',
            "title_$locale as title",
            "slug_$locale as slug"

        )->with('media')
            ->active(true)
            ->latest()
            ->paginate($per_page);
    }
    public function show($identifier)
    {
        $locale = app()->getLocale();
        return FreeZone::select(
            'id',
            "title_$locale as title",
            "slug_$locale as slug",
            "content_$locale as content",
        )
            ->with('media')
            ->active(true)
            ->where(
                fn($q) => $q->where('slug_en', $identifier)
                    ->orWhere('slug_ar', $identifier)
                    ->orWhere('id', $identifier)
            )
            ->first();
    }
}
