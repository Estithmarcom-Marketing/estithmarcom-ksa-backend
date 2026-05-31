<?php

namespace App\Services\V1\Website\Residency;

use App\Models\Residency;

class ResidencyService
{
    public function list(array $data)
    {
        $locale = app()->getLocale() ?? 'ar';
        $per_page = $data['per_page'] ?? 10;

        return Residency::query()
            ->published(true)
            ->when(filled($data['country_id'] ?? null), fn($q) => $q->filterByCountry($data['country_id']))
            ->when(filled($data['search'] ?? null), fn($q) => $q->search($data['search']))
            ->with('media')
            ->select([
                'id',
                "title_$locale as title",
            ])
            ->latest()
            ->paginate($per_page);
    }

    public function show($identifier)
    {
        $locale = app()->getLocale();

        return Residency::select(
            [
                'id',
                'country_id',
                "title_{$locale} as title",
                "slug_{$locale} as slug",
                "description_{$locale} as description",
                "meta_title_{$locale} as meta_title",
                "meta_description_{$locale} as meta_description",
            ]
        )
            ->with([
                'media',
                'country' => function ($q) use ($locale) {
                    $q->select(
                        'id',
                        "name_{$locale} as name"
                    );
                },
            ])
            ->published(true)
            ->where(function ($query) use ($identifier) {
                $query->where('slug_ar', $identifier)
                    ->orWhere('slug_en', $identifier)
                    ->orWhere('id', $identifier);
            })
            ->firstOrFail();
    }
}
