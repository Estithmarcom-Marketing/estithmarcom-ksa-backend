<?php

namespace App\Services\V1\Admin\RequestResidency;

use App\Enum\RequestResidencyStatusEnum;
use App\Models\RequestResidency;

class RequestResidencyService
{
    public function list(array $data)
    {
        $per_page = $data['per_page'] ?? 10;

        return RequestResidency::query()
            ->when(filled($data['residency_id'] ?? null), fn($q) => $q->filterByResidency($data['residency_id']))
            ->when(filled($data['status'] ?? null), fn($q) => $q->filterByStatus($data['status']))
            ->when(filled($data['search'] ?? null), fn($q) => $q->search($data['search']))
            ->with([
                'residency:id,title_ar'
            ])
            ->select('id', 'name', 'email', 'phone', 'status', 'residency_id', 'created_at')
            ->latest()
            ->paginate($per_page);
    }
    public function show(RequestResidency $requestResidency)
    {
        return $requestResidency->load(['residency:id,title_ar,country_id', 'residency.country:id,name_ar']);
    }
    public function update(RequestResidency $requestResidency, array $data)
    {
        $requestResidency->update([
            'status' => RequestResidencyStatusEnum::from($data['status']) ?? $requestResidency->status,
        ]);
        return $requestResidency->refresh();
    }
    public function destroy(RequestResidency $requestResidency)
    {
        return $requestResidency->delete();
    }
}
