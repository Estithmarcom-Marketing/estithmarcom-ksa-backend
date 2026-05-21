<?php

namespace App\Services\V1\Admin\FreeZone;

use App\Models\FreeZone;
use Illuminate\Support\Facades\DB;

class FreeZoneService
{
    public function list(array $data)
    {
        $per_page = $data['per_page'] ?? 10;

        return FreeZone::query()
            ->select(['id', 'title_ar', 'active', 'created_at'])
            ->when(array_key_exists('active', $data), fn($q) => $q->active($data['active']))
            ->when(filled($data['search'] ?? null), fn($q) => $q->search($data['search']))
            ->with('media')
            ->latest()
            ->paginate($per_page);
    }

    public function show(FreeZone $freeZone)
    {
        return $freeZone->load(['media', 'faqs']);
    }

    public function store(array $data)
    {
        $data['slug_ar'] = $data['slug_ar'] ?? make_slug($data['title_ar'], 'ar', FreeZone::class, 'slug_ar');
        $data['slug_en'] = $data['slug_en'] ?? make_slug($data['title_en'], 'en', FreeZone::class, 'slug_en');

        return DB::transaction(function () use ($data) {
            $freeZone = FreeZone::create($data);

            if (isset($data['image'])) {
                $freeZone->addMedia($data['image'])->toMediaCollection('free_zone');
            }
            if (isset($data['faqs'])) {
                $freeZone->faqs()->createMany($data['faqs']);
            }
            return $freeZone;
        });
    }

    public function update(FreeZone $freeZone, array $data)
    {
        $data['slug_ar'] = $data['slug_ar'] ?? $this->updateSlug($freeZone, $data['title_ar'] ?? $freeZone->title_ar, 'ar');
        $data['slug_en'] = $data['slug_en'] ?? $this->updateSlug($freeZone, $data['title_en'] ?? $freeZone->title_en, 'en');

        return DB::transaction(function () use ($freeZone, $data) {
            $freeZone->update($data);

            if (isset($data['image'])) {
                $freeZone->clearMediaCollection('free_zone');
                $freeZone->addMedia($data['image'])->toMediaCollection('free_zone');
            }

            if (isset($data['faqs'])) {
                $freeZone->faqs()->delete();
                $freeZone->faqs()->createMany($data['faqs']);
            }

            return $freeZone->refresh();
        });
    }

    public function destroy(FreeZone $freeZone)
    {
        DB::transaction(function () use ($freeZone) {
            $freeZone->clearMediaCollection('free_zone');
            $freeZone->faqs()->delete();
            $freeZone->delete();
        });
    }

    private function updateSlug($freeZone, $new_title, $locale)
    {
        if ($new_title === $freeZone->{"title_$locale"}) {
            return $freeZone->{"slug_$locale"};
        }

        return make_slug($new_title, $locale, FreeZone::class, "slug_$locale");
    }
}
