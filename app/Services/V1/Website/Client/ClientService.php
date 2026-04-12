<?php

namespace App\Services\V1\Website\Client;

use App\Models\Client;

class ClientService
{
    public function list(array $data)
    {
        $per_page = $data['per_page'] ?? 10;
        $locale = app()->getLocale();
        return Client::select(
            'id',
            "alt_$locale as alt",
            'link'
        )
            ->with('media')
            ->latest()
            ->paginate($per_page);
    }
}
