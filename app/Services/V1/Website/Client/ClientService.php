<?php

namespace App\Services\V1\Website\Client;

use App\Models\Client;

class ClientService
{
    public function list()
    {
        $locale = app()->getLocale();
        return Client::select(
            [
                'id',
                "alt_$locale as alt",
                'link'
            ]
        )
            ->with('media')
            ->latest()
            ->get();
    }
}
