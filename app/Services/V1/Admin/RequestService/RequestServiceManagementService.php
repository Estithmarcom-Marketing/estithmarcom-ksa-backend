<?php

namespace App\Services\V1\Admin\RequestService;

use App\Enum\RequestServiceStatusEnum;
use App\Models\RequestService;

class RequestServiceManagementService
{
    public function list(array $data)
    {
        $per_page = $data['per_page'] ?? 10;

        return RequestService::query()
            ->when($data['country_id'] ?? null, fn($q, $v) => $q->filterByCountry($v))
            ->when($data['service_id'] ?? null, fn($q, $v) => $q->filterByService($v))
            ->when($data['status'] ?? null, fn($q, $v) => $q->filterByStatus($v))
            ->when($data['search'] ?? null, fn($q, $v) => $q->search($v))
            ->with([
                'service:id,title_ar',
                'country:id,name_ar'
            ])
            ->select('id', 'name', 'email', 'phone', 'status', 'service_id', 'country_id', 'created_at')
            ->latest()
            ->paginate($per_page);
    }
    public function show(RequestService $requestService)
    {
        return $requestService->load(['service:id,title_ar', 'country:id,name_ar']);
    }
    public function update(RequestService $requestService, array $data)
    {
        $requestService->update([
            'status' => RequestServiceStatusEnum::from($data['status']) ?? $requestService->status,
        ]);
        return $requestService->refresh();
    }
    public function destroy(RequestService $requestService)
    {
        return $requestService->delete();
    }
}
