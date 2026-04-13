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

    private function validateData(array $data): void
    {
        $this->validateServiceAvailableInCountry($data);
    }
    private function validateServiceAvailableInCountry(array $data): void
    {
        $exists = Service::query()
            ->published(true)
            ->where('id', $data['service_id'])
            ->whereHas('countries', function ($query) use ($data) {
                $query->where('countries.id', $data['country_id'])
                    ->active(true);
            })
            ->exists();

        if (! $exists) {
            throw new \LogicException(__('request_service.service_not_available_in_country'));
        }
    }
}
