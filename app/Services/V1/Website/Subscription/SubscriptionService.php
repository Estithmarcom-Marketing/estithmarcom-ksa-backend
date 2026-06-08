<?php

namespace App\Services\V1\Website\Subscription;

use App\Events\UserSubscribed;
use App\Models\Subscription;

class SubscriptionService
{
    public function store(array $data)
    {
        $subscription = Subscription::create([
            'email' => $data['email']
        ]);
        UserSubscribed::dispatch($subscription);

        return $subscription;
    }
}
