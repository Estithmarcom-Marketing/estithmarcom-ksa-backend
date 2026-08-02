<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('admin.notifications', function (User $user) {
    return $user instanceof User;
});
