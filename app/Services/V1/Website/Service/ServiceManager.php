<?php

namespace App\Services\V1\Website\Service;

use App\Models\Service;

class ServiceManager
{
    public function list(array $data)
    {
        $per_page = $data['per_page'] ?? 10;
        $search = $data['search'] ?? null;
        $country_id = $data['country_id'] ?? null;
        $locale = app()->getLocale();
        return Service::select('id', "title_$locale as title", "slug_$locale as slug", "short_description_$locale as short_description")
            ->with('media')
            ->published(true)
            ->when($search, fn($q, $v) => $q->search($v))
            ->when($country_id, fn($q, $v) => $q->filterByCountry($v))
            ->latest()
            ->paginate($per_page);
    }
    public function show($identifier)
    {
        $locale = app()->getLocale();

        $service = Service::select(
            'id',
            "title_{$locale} as title",
            "slug_{$locale} as slug",
            "short_description_{$locale} as short_description",
            "long_description_{$locale} as long_description",
            "meta_title_{$locale} as meta_title",
            "meta_description_{$locale} as meta_description"
        )
            ->with([
                'media',
                'countries' => function ($q) use ($locale) {
                    $q->select(
                        'countries.id',
                        "name_{$locale} as name"
                    );
                }
            ])
            ->published(true)
            ->where(function ($query) use ($identifier) {
                $query->where("slug_ar", $identifier)
                    ->orWhere("slug_en", $identifier)
                    ->orWhere("id", $identifier);
            })
            ->first();

        return $service;
    }
    public function listWithoutPagination()
    {
        $locale = app()->getLocale();
        return Service::select('id', "title_$locale as title")
            ->published(true)
            ->latest()
            ->get();
    }
}
