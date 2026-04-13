<?php

namespace App\Services\V1\Admin\Service;

use App\Models\Service;

class ServiceManager
{
    public function index(array $data)
    {
        $per_page = $data['per_page'] ?? 10;

        return Service::query()
            ->when($data['published'] ?? null, fn($q, $v) => $q->published($v))
            ->when($data['search'] ?? null, fn($q, $v) => $q->search($v))
            ->with('media')
            ->select('id', 'title_ar', 'title_en', 'published', 'created_at')
            ->latest()
            ->paginate($per_page);
    }

    public function show(Service $service)
    {
        return $service->load(['media', 'countries']);
    }

    public function store(array $data)
    {
        $slug_ar = $data['slug_ar'] ?? make_slug($data['title_ar'], 'ar', Service::class, 'slug_ar');
        $slug_en = $data['slug_en'] ?? make_slug($data['title_en'], 'en', Service::class, 'slug_en');

        $service = Service::create([
            'title_ar' => $data['title_ar'],
            'title_en' => $data['title_en'],
            'short_description_ar' => $data['short_description_ar'],
            'short_description_en' => $data['short_description_en'],
            'long_description_ar' => $data['long_description_ar'],
            'long_description_en' => $data['long_description_en'],
            'published' => $data['published'],
            'meta_title_ar' => $data['meta_title_ar'],
            'meta_title_en' => $data['meta_title_en'],
            'meta_description_ar' => $data['meta_description_ar'],
            'meta_description_en' => $data['meta_description_en'],
            'slug_ar' => $slug_ar,
            'slug_en' => $slug_en,
        ]);
        $this->syncCountries($service, $data);
        if (isset($data['image'])) {
            $service->addMedia($data['image'])->toMediaCollection('service');
        }

        return $service;
    }

    public function update(Service $service, array $data)
    {
        $slug_ar = $data['slug_ar'] ?? $this->updateSlug($service, $data['title_ar'] ?? $service->title_ar, 'ar');
        $slug_en = $data['slug_en'] ?? $this->updateSlug($service, $data['title_en'] ?? $service->title_en, 'en');
        $service->update([
            'title_ar' => $data['title_ar'] ?? $service->title_ar,
            'title_en' => $data['title_en'] ?? $service->title_en,
            'short_description_ar' => $data['short_description_ar'] ?? $service->short_description_ar,
            'short_description_en' => $data['short_description_en'] ?? $service->short_description_en,
            'long_description_ar' => $data['long_description_ar'] ?? $service->long_description_ar,
            'long_description_en' => $data['long_description_en'] ?? $service->long_description_en,
            'published' => $data['published'] ?? $service->published,
            'meta_title_ar' => $data['meta_title_ar'] ?? $service->meta_title_ar,
            'meta_title_en' => $data['meta_title_en'] ?? $service->meta_title_en,
            'meta_description_ar' => $data['meta_description_ar'] ?? $service->meta_description_ar,
            'meta_description_en' => $data['meta_description_en'] ?? $service->meta_description_en,
            'slug_ar' => $slug_ar,
            'slug_en' => $slug_en,
        ]);
        $this->syncCountries($service, $data);
        if (isset($data['image'])) {
            $service->clearMediaCollection('service');
            $service->addMedia($data['image'])->toMediaCollection('service');
        }

        return $service->refresh();
    }

    public function destroy(Service $service)
    {
        $service->clearMediaCollection('service');
        $service->delete();
    }

    private function updateSlug($service, $new_title, $locale)
    {
        if ($new_title === $service->{"title_$locale"}) {
            return $service->{"slug_$locale"};
        }

        return make_slug($new_title, $locale, Service::class, "slug_$locale");
    }
    private function syncCountries(Service $service, array $data): void
    {
        if (isset($data['country_ids'])) {
            $service->countries()->sync($data['country_ids']);
        }
    }
}
