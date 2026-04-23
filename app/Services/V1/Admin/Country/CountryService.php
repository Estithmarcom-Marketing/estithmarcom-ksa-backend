<?php

namespace App\Services\V1\Admin\Country;

use App\Models\Country;

class CountryService
{
    public function list(array $data)
    {
        $per_page = $data['per_page'] ?? 10;

        return Country::query()
            ->when($data['active'] ?? null, fn($q, $v) => $q->active($v))
            ->when($data['search'] ?? null, fn($q, $v) => $q->search($v))
            ->with('media')
            ->select('id', 'name_ar', 'name_en', 'active', 'created_at')
            ->latest()
            ->paginate($per_page);
    }
    public function listWithoutPagination()
    {
        return Country::select('id', 'name_ar', 'name_en', 'active')
            ->latest()
            ->get();
    }

    public function show(Country $country)
    {
        return $country->load('media');
    }

    public function store(array $data)
    {
        $country = Country::create([
            'name_ar' => $data['name_ar'],
            'name_en' => $data['name_en'],
            'title_ar' => $data['title_ar'],
            'title_en' => $data['title_en'],
            'description_ar' => $data['description_ar'],
            'description_en' => $data['description_en'],
            'active' => $data['active'] ?? false,
        ]);
        if (! empty($data['image'])) {
            $country->addMedia($data['image'])->toMediaCollection('country');
        }

        return $country;
    }

    public function update(Country $country, array $data)
    {
        $country->update([
            'name_ar' => $data['name_ar'] ?? $country->name_ar,
            'name_en' => $data['name_en'] ?? $country->name_en,
            'title_ar' => $data['title_ar'] ?? $country->title_ar,
            'title_en' => $data['title_en'] ?? $country->title_en,
            'description_ar' => $data['description_ar'] ?? $country->description_ar,
            'description_en' => $data['description_en'] ?? $country->description_en,
            'active' => $data['active'] ?? $country->active,
        ]);

        if (! empty($data['image'])) {
            $country->clearMediaCollection('country');
            $country->addMedia($data['image'])->toMediaCollection('country');
        }

        return $country->refresh();
    }

    public function destroy(Country $country)
    {
        $country->clearMediaCollection('country');

        return $country->delete();
    }
}
