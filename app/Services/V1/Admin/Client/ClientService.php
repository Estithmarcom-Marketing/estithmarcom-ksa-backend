<?php

namespace App\Services\V1\Admin\Client;

use App\Models\Client;

class ClientService
{
    public function list(array $data)
    {
        $per_page = $data['per_page'] ?? 10;

        return Client::with('media')->latest()->paginate($per_page);
    }

    public function show(Client $client)
    {
        return $client->load('media');
    }

    public function store(array $data)
    {
        $client = Client::create([
            'link' => $data['link'],
            'published' => $data['published'] ?? false,
            'alt_ar' => $data['alt_ar'],
            'alt_en' => $data['alt_en'],
        ]);
        if (! empty($data['image'])) {
            $client->addMedia($data['image'])->toMediaCollection('client');
        }

        return $client;
    }

    public function update(Client $client, array $data)
    {
        $client->update([
            'link' => $data['link'] ?? $client->link,
            'published' => $data['published'] ?? $client->published,
            'alt_ar' => $data['alt_ar'] ?? $client->alt_ar,
            'alt_en' => $data['alt_en'] ?? $client->alt_en,
        ]);
        if (! empty($data['image'])) {
            $client->clearMediaCollection('client');
            $client->addMedia($data['image'])->toMediaCollection('client');
        }

        return $client;
    }

    public function destroy(Client $client)
    {
        $client->clearMediaCollection('client');

        return $client->delete();
    }
}
