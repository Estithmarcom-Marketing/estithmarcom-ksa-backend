<?php

namespace App\Services\V1\Admin\Service;

use App\Models\Service;
use Illuminate\Support\Facades\DB;

class ServiceManager
{
    public function index(array $data)
    {
        $per_page = $data['per_page'] ?? 10;

        return Service::query()
            ->when(array_key_exists('published', $data), fn($q) => $q->published($data['published']))
            ->when(filled($data['search'] ?? null), fn($q) => $q->search($data['search']))
            ->when(filled($data['country_id'] ?? null), fn($q) => $q->filterByCountry($data['country_id']))
            ->with('media')
            ->select('id', 'title_ar', 'published', 'created_at')
            ->latest()
            ->paginate($per_page);
    }

    public function show(Service $service)
    {
        return $service->load(['media', 'countries:id,name_ar,active', 'faqs']);
    }

    public function store(array $data)
    {
        $data['slug_ar'] = $data['slug_ar'] ?? make_slug($data['title_ar'], 'ar', Service::class, 'slug_ar');
        $data['slug_en'] = $data['slug_en'] ?? make_slug($data['title_en'], 'en', Service::class, 'slug_en');

        return DB::transaction(function () use ($data) {
            $service = Service::create($data);
            $this->syncCountries($service, $data);
            if (isset($data['faqs'])) {
                $service->faqs()->createMany($data['faqs']);
            }
            if (isset($data['image'])) {
                $service->addMedia($data['image'])->toMediaCollection('service');
            }
            return $service;
        });
    }

    public function update(Service $service, array $data)
    {
        $data['slug_ar'] = $data['slug_ar'] ?? $this->updateSlug($service, $data['title_ar'] ?? $service->title_ar, 'ar');
        $data['slug_en'] = $data['slug_en'] ?? $this->updateSlug($service, $data['title_en'] ?? $service->title_en, 'en');

        return DB::transaction(function () use ($service, $data) {
            $service->update($data);
            $this->syncCountries($service, $data);
            if (isset($data['image'])) {
                $service->clearMediaCollection('service');
                $service->addMedia($data['image'])->toMediaCollection('service');
            }
            if (isset($data['faqs'])) {
                $service->faqs()->delete();
                $service->faqs()->createMany($data['faqs']);
            }
            return $service->refresh();
        });
    }

    public function destroy(Service $service)
    {
        $service->clearMediaCollection('service');
        $service->faqs()->delete();
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
