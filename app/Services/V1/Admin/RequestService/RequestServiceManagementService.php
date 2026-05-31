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
            ->when(filled($data['country_id'] ?? null), fn($q) => $q->filterByCountry($data['country_id']))
            ->when(filled($data['service_id'] ?? null), fn($q) => $q->filterByService($data['service_id']))
            ->when(filled($data['status'] ?? null), fn($q) => $q->filterByStatus($data['status']))
            ->when(filled($data['search'] ?? null), fn($q) => $q->search($data['search']))
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
