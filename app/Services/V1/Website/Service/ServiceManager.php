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

        return Service::select(['id', "title_$locale as title", "slug_$locale as slug", "short_description_$locale as short_description"])
            ->with('media')
            ->published(true)
            ->when(filled($search ?? null), fn($q) => $q->search($search))
            ->when(filled($country_id), fn($q) => $q->filterByCountry($country_id))
            ->latest()
            ->paginate($per_page);
    }
    public function show($identifier)
    {
        $locale = app()->getLocale();

        return Service::select(
            [
                'id',
                "title_{$locale} as title",
                "slug_{$locale} as slug",
                "short_description_{$locale} as short_description",
                "long_description_{$locale} as long_description",
                "feature_description_{$locale} as feature_description",
                "meta_title_{$locale} as meta_title",
                "meta_description_{$locale} as meta_description"
            ]
        )
            ->with([
                'media',
                'faqs' => function ($q) use ($locale) {
                    $q->select([
                        'id',
                        'faqable_id',
                        'faqable_type',
                        "question_$locale as question",
                        "answer_$locale as answer",
                    ])->published(true);
                },
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
    }
    public function listWithoutPagination()
    {
        $locale = app()->getLocale();
        return Service::select(['id', "title_$locale as title"])
            ->published(true)
            ->latest()
            ->get();
    }
}
