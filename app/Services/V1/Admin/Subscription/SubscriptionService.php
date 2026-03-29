<?php

namespace App\Services\V1\Admin\Subscription;

use App\Models\Subscription;

class SubscriptionService
{
    public function index(array $data)
    {
        $per_page = $data['per_page'] ?? 10;

        return Subscription::latest()->paginate($per_page);
    }

    public function destroy(Subscription $subscription)
    {
        return $subscription->delete();
    }
}
