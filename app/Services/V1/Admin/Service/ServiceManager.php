<?php

namespace App\Services\V1\Admin\Service;

use App\Models\Service;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceFeature;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

class ServiceManager
{
    public function index(array $data)
    {
        $perPage = $data['per_page'] ?? 10;

        return Service::query()
            ->when(array_key_exists('published', $data), fn($q) => $q->published($data['published']))
            ->when(filled($data['search'] ?? null), fn($q) => $q->search($data['search']))
            ->when(filled($data['country_id'] ?? null),  fn($q) => $q->filterByCountry($data['country_id']))
            ->with('media')
            ->select(
                [
                    'id',
                    'title_ar',
                    'published',
                    'created_at'
                ]
            )
            ->latest()
            ->paginate($perPage);
    }

    public function show(Service $service)
    {
        return $service->load([
            'media',
            'countries:id,name_ar,active',
            'faqs',
            'features.media',
        ]);
    }
    public function store(array $data)
    {
        $data['slug_ar'] = $data['slug_ar'] ?? make_slug($data['title_ar'], 'ar', Service::class, 'slug_ar');
        $data['slug_en'] = $data['slug_en'] ?? make_slug($data['title_en'], 'en', Service::class, 'slug_en');

        return DB::transaction(function () use ($data) {

            $service = Service::create(
                Arr::except($data, [
                    'features',
                    'faqs',
                    'country_ids',
                    'image',
                ])
            );
            $this->syncCountries($service, $data);
            $this->createManyFaqs($service, $data['faqs'] ?? null);
            $this->createManyFeatures($service, $data['features'] ?? null);
            $this->syncImage($service, $data['image'] ?? null, 'service');

            return $service;
        });
    }

    public function update(Service $service, array $data)
    {
        $data['slug_ar'] = $data['slug_ar'] ?? $this->updateSlug($service, $data['title_ar'] ?? null, 'ar');
        $data['slug_en'] = $data['slug_en'] ?? $this->updateSlug($service, $data['title_en'] ?? null, 'en');

        return DB::transaction(function () use ($service, $data) {

            $service->update(
                Arr::except($data, [
                    'features',
                    'faqs',
                    'country_ids',
                    'image',
                ])
            );

            $this->syncCountries($service, $data);

            if (isset($data['faqs'])) {
                $service->faqs()->delete();
                $this->createManyFaqs($service, $data['faqs']);
            }

            if (isset($data['features'])) {
                $this->syncFeatures($service, $data['features']);
            }

            $this->syncImage($service, $data['image'] ?? null, 'service');

            return $service->refresh();
        });
    }

    public function destroy(Service $service): void
    {
        DB::transaction(function () use ($service) {
            $service->features()
                ->get()
                ->each(fn($feature) => $this->deleteFeature($feature));

            $service->clearMediaCollection('service');
            $service->faqs()->delete();
            $service->delete();
        });
    }

    private function createManyFaqs(Service $service, ?array $faqs): void
    {
        if (! empty($faqs)) {
            $service->faqs()->createMany($faqs);
        }
    }

    private function createManyFeatures(Service $service, ?array $features): void
    {
        if (empty($features)) {
            return;
        }

        foreach ($features as $featureData) {
            $this->createFeature($service, $featureData);
        }
    }
    private function createFeature(Service $service, array $data): ServiceFeature
    {
        $feature = $service->features()->create(
            [
                'title_ar' => $data['title_ar'],
                'title_en' => $data['title_en'],
                'description_ar' => $data['description_ar'],
                'description_en' => $data['description_en'],
                'published' => $data['published'],
            ]
        );

        $this->syncImage($feature, $data['image'] ?? null, 'service_feature');

        return $feature;
    }

    private function syncFeatures(Service $service, array $features): void
    {
        $existing   = $service->features()->get()->keyBy('id');
        $incomingIds = collect($features)->pluck('id')->filter();

        $existing
            ->whereNotIn('id', $incomingIds)
            ->each(fn($feature) => $this->deleteFeature($feature));

        foreach ($features as $featureData) {
            if (! empty($featureData['id'])) {
                $this->updateExistingFeature($existing, $featureData);
            } else {
                $this->createFeature($service, $featureData);
            }
        }
    }
    private function updateExistingFeature($existing, array $featureData): void
    {
        $feature = $existing->get($featureData['id']);

        if (! $feature) {
            return;
        }

        $feature->update($featureData);
        $this->syncImage($feature, $featureData['image'] ?? null, 'service_feature');
    }


    private function syncFeatureImage(
        ServiceFeature $feature,
        mixed $image
    ): void {
        if (! $image instanceof UploadedFile) {
            return;
        }

        $feature->clearMediaCollection(
            'service_feature'
        );

        $feature
            ->addMedia($image)
            ->toMediaCollection('service_feature');
    }

    private function updateSlug(Service $service,  ?string $newTitle, string $locale): string
    {
        $currentTitle = $service->{"title_$locale"};

        if (! $newTitle || $newTitle === $currentTitle) {
            return $service->{"slug_$locale"};
        }

        return make_slug($newTitle, $locale, Service::class, "slug_$locale");
    }

    private function syncCountries(
        Service $service,
        array $data
    ): void {
        if (isset($data['country_ids'])) {
            $service->countries()
                ->sync($data['country_ids']);
        }
    }
    private function deleteFeature(ServiceFeature $feature): void
    {
        $feature->clearMediaCollection('service_feature');
        $feature->delete();
    }
    private function syncImage($model, mixed $image, string $collection): void
    {
        if (! $image instanceof UploadedFile) {
            return;
        }

        $model->clearMediaCollection($collection);
        $model->addMedia($image)->toMediaCollection($collection);
    }
}
