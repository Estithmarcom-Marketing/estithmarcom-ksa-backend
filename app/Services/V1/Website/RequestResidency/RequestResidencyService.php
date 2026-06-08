<?php

namespace App\Services\V1\Website\RequestResidency;

use App\Enum\RequestResidencyStatusEnum;
use App\Events\ResidencyRequested;
use App\Models\RequestResidency;

class RequestResidencyService
{
    public function store(array $data)
    {
        if (isset($data['phone'])) {
            $data['phone'] = $this->normalizePhone($data['phone']);
        }
        $data['status'] = RequestResidencyStatusEnum::PENDING;

        $requestResidency = RequestResidency::create($data);
        ResidencyRequested::dispatch($requestResidency);
        return $requestResidency;
    }

    private function normalizePhone($phone)
    {
        return str_replace(['+', ' ', '-'], '', $phone);
    }
}
