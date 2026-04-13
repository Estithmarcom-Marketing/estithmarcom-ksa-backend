<?php

namespace App\Services\V1\Website\Subscription;

use App\Models\Subscription;

class SubscriptionService
{
    public function store(array $data)
    {
        return Subscription::create([
            'email' => $data['email']
        ]);
    }
}
