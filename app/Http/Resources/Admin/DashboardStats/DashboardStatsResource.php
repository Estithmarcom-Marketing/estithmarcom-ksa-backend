<?php

namespace App\Http\Resources\Admin\DashboardStats;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardStatsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'services' => [
                'count'      => $this['services']['count'] ?? 0,
                'percentage' => $this['services']['percentage'] ?? 0,
                'trend'      => $this['services']['trend'] ?? 'neutral',
            ],

            'service_requests' => [
                'count'      => $this['service_requests']['count'] ?? 0,
                'percentage' => $this['service_requests']['percentage'] ?? 0,
                'trend'      => $this['service_requests']['trend'] ?? 'neutral',
            ],

            'contact_us' => [
                'count'      => $this['contact_us']['count'] ?? 0,
                'percentage' => $this['contact_us']['percentage'] ?? 0,
                'trend'      => $this['contact_us']['trend'] ?? 'neutral',
            ],

            'requests_by_service' => collect($this['requests_by_service'] ?? [])
                ->map(function ($item) {
                    return [
                        'service'    => $item['service'] ?? null,
                        'count'      => $item['count'] ?? 0,
                        'percentage' => $item['percentage'] ?? 0,
                        'trend'      => $item['trend'] ?? 'neutral',
                    ];
                })
                ->values()
                ->all(),
        ];
    }
}
