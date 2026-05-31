<?php

namespace App\Services\V1\Admin\Residency;

use App\Models\Residency;

class ResidencyService
{
    public function list(array $data)
    {
        $per_page = $data['per_page'] ?? 10;
        $search = $data['search'] ?? null;

        return Residency::query()
            ->when(array_key_exists('published', $data), fn($q) => $q->published($data['published']))
            ->when(filled($data['country_id'] ?? null), fn($q) => $q->filterByCountry($data['country_id']))
            ->when(filled($search ?? null), fn($q) => $q->search($search))
            ->with('media')
            ->select(['id', 'title_ar', 'published', 'created_at'])
            ->latest()
            ->paginate($per_page);
    }
    public function show(Residency $residency)
    {
        return $residency->load(['media', 'country:id,name_ar']);
    }
    public function store(array $data)
    {
        $data['slug_ar'] = $data['slug_ar'] ?? make_slug($data['title_ar'], 'ar', Residency::class, 'slug_ar');
        $data['slug_en'] = $data['slug_en'] ?? make_slug($data['title_en'], 'en', Residency::class, 'slug_en');
        $residency = Residency::create($data);
        if (! empty($data['image'])) {
            $residency->addMedia($data['image'])->toMediaCollection('residency');
        }
        return $residency;
    }
    public function update(Residency $residency, array $data)
    {
        $data['slug_ar'] = $data['slug_ar'] ?? $this->updateSlug($residency, $data['title_ar'] ?? $residency->title_ar, 'ar');
        $data['slug_en'] = $data['slug_en'] ?? $this->updateSlug($residency, $data['title_en'] ?? $residency->title_en, 'en');
        $residency->update($data);
        if (! empty($data['image'])) {
            $residency->clearMediaCollection('residency');
            $residency->addMedia($data['image'])->toMediaCollection('residency');
        }
        return $residency;
    }
    public function destroy(Residency $residency)
    {
        $residency->clearMediaCollection('residency');
        $residency->delete();
    }
    private function updateSlug($residency, $new_title, $locale)
    {
        if ($new_title === $residency->{"title_$locale"}) {
            return $residency->{"slug_$locale"};
        }
        return make_slug($new_title, $locale, Residency::class, 'slug_' . $locale);
    }
}
