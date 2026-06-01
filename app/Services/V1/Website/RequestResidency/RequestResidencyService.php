<?php

namespace App\Services\V1\Website\RequestResidency;

use App\Enum\RequestResidencyStatusEnum;
use App\Models\RequestResidency;

class RequestResidencyService
{
    public function store(array $data)
    {
        if (isset($data['phone'])) {
            $data['phone'] = $this->normalizePhone($data['phone']);
        }
        $data['status'] = RequestResidencyStatusEnum::PENDING;

        return RequestResidency::create($data);
    }

    private function normalizePhone($phone)
    {
        return str_replace(['+', ' ', '-'], '', $phone);
    }
}
