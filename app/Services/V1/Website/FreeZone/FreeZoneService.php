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
            [
                'id',
                "title_$locale as title",
                "slug_$locale as slug"
            ]

        )->with('media')
            ->active(true)
            ->latest()
            ->paginate($per_page);
    }
    public function show($identifier)
    {
        $locale = app()->getLocale();

        return FreeZone::with([
            'media',
            'faqs' => function ($q) use ($locale) {
                $q->select([
                    'id',
                    'faqable_id',
                    'faqable_type',
                    "question_$locale as question",
                    "answer_$locale as answer",
                ])->published(true);
            }
        ])
            ->select([
                'id',
                "title_$locale as title",
                "slug_$locale as slug",
                "content_$locale as content"
            ])
            ->active(true)
            ->where(
                fn($q) => $q->where('slug_en', $identifier)
                    ->orWhere('slug_ar', $identifier)
                    ->orWhere('id', $identifier)
            )
            ->first();
    }
}
