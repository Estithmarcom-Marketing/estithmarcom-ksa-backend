<?php

namespace App\Services\V1\Admin\FreeZone;

use App\Models\FreeZone;

class FreeZoneService
{
    public function list(array $data)
    {
        $per_page = $data['per_page'] ?? 10;

        return FreeZone::query()
            ->when($data['active'] ?? null, fn($q, $v) => $q->active($v))
            ->when($data['search'] ?? null, fn($q, $v) => $q->search($v))
            ->with('media')
            ->select('id', 'title_ar', 'title_en', 'slug_ar', 'slug_en', 'active', 'created_at')
            ->latest()
            ->paginate($per_page);
    }

    public function show(FreeZone $freeZone)
    {
        return $freeZone->load('media');
    }

    public function store(array $data)
    {
        $slug_ar = $data['slug_ar'] ?? make_slug($data['title_ar'], 'ar', FreeZone::class, 'slug_ar');
        $slug_en = $data['slug_en'] ?? make_slug($data['title_en'], 'en', FreeZone::class, 'slug_en');

        $freeZone = FreeZone::create([
            'title_ar' => $data['title_ar'],
            'title_en' => $data['title_en'],
            'content_ar' => $data['content_ar'],
            'content_en' => $data['content_en'],
            'active' => $data['active'] ?? true,
            'slug_ar' => $slug_ar,
            'slug_en' => $slug_en,
        ]);

        if (isset($data['image'])) {
            $freeZone->addMedia($data['image'])->toMediaCollection('free_zone');
        }

        return $freeZone;
    }

    public function update(FreeZone $freeZone, array $data)
    {
        $slug_ar = $data['slug_ar'] ?? $this->updateSlug($freeZone, $data['title_ar'] ?? $freeZone->title_ar, 'ar');
        $slug_en = $data['slug_en'] ?? $this->updateSlug($freeZone, $data['title_en'] ?? $freeZone->title_en, 'en');

        $freeZone->update([
            'title_ar' => $data['title_ar'] ?? $freeZone->title_ar,
            'title_en' => $data['title_en'] ?? $freeZone->title_en,
            'content_ar' => $data['content_ar'] ?? $freeZone->content_ar,
            'content_en' => $data['content_en'] ?? $freeZone->content_en,
            'active' => $data['active'] ?? $freeZone->active,
            'slug_ar' => $slug_ar,
            'slug_en' => $slug_en,
        ]);

        if (isset($data['image'])) {
            $freeZone->clearMediaCollection('free_zone');
            $freeZone->addMedia($data['image'])->toMediaCollection('free_zone');
        }

        return $freeZone->refresh();
    }

    public function destroy(FreeZone $freeZone)
    {
        $freeZone->clearMediaCollection('free_zone');
        $freeZone->delete();
    }

    private function updateSlug($freeZone, $new_title, $locale)
    {
        if ($new_title === $freeZone->{"title_$locale"}) {
            return $freeZone->{"slug_$locale"};
        }

        return make_slug($new_title, $locale, FreeZone::class, "slug_$locale");
    }
}
