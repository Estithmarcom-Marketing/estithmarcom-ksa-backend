<?php

namespace App\Services\V1\Admin\Client;

use App\Models\Client;

class ClientService
{
    public function list(array $data)
    {
        $per_page = $data['per_page'] ?? 10;

        return Client::query()
            ->when($data['active'] ?? null, fn($q, $v) => $q->active($v))
            ->with('media')
            ->latest()
            ->paginate($per_page);
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
        $client->update($data);
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
