<?php

namespace App\Services\V1\Website\RequestService;

use App\Enum\RequestServiceStatusEnum;
use App\Models\Country;
use App\Models\RequestService;
use App\Models\Service;

class RequestServiceManagementService
{
    public function store(array $data)
    {
        if (isset($data['phone'])) {
            $data['phone'] = $this->normalizePhone($data['phone']);
        }

        $this->validateData($data);

        return RequestService::create([
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'],
            'service_id' => $data['service_id'],
            'country_id' => $data['country_id'],
            'additional_info' => $data['additional_info'] ?? null,
            'status' => RequestServiceStatusEnum::PENDING
        ]);
    }

    private function normalizePhone($phone)
    {
        return str_replace(['+', ' ', '-'], '', $phone);
    }

    private function validateData(array $data)
    {
        $country = Country::where('id', $data['country_id'])
            ->active(true)
            ->first();
        if (! $country) {
            throw new \LogicException('Country not found');
        }

        $service = Service::where('id', $data['service_id'])
            ->published(true)
            ->first();
        if (! $service) {
            throw new \LogicException('Service not found');
        }
    }
}
