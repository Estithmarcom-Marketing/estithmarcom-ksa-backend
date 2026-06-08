<?php

namespace App\Services\V1\Admin\DashboardStats;

use App\Models\ContactUs;
use App\Models\RequestService;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardStatsService
{
    public function getDashboardStats(): array
    {
        return Cache::remember('admin.dashboard_stats', 60, function () {
            return [
                'services'             => $this->getServicesStats(),
                'service_requests'     => $this->getServiceRequestsStats(),
                'contact_us'           => $this->getContactUsStats(),
                'requests_by_service'  => $this->getRequestsByService(),
            ];
        });
    }

    /* ---------------- SERVICES ---------------- */
    private function getServicesStats(): array
    {
        $currentMonth  = Carbon::now();
        $previousMonth = Carbon::now()->subMonth();

        $current = Service::whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->count();

        $previous = Service::whereMonth('created_at', $previousMonth->month)
            ->whereYear('created_at', $previousMonth->year)
            ->count();

        return $this->formatStat($current, $previous);
    }

    /* ---------------- SERVICE REQUESTS ---------------- */
    private function getServiceRequestsStats(): array
    {
        $currentMonth  = Carbon::now();
        $previousMonth = Carbon::now()->subMonth();

        $current = RequestService::whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->count();

        $previous = RequestService::whereMonth('created_at', $previousMonth->month)
            ->whereYear('created_at', $previousMonth->year)
            ->count();

        return $this->formatStat($current, $previous);
    }

    /* ---------------- CONTACT US ---------------- */
    private function getContactUsStats(): array
    {
        $currentMonth  = Carbon::now();
        $previousMonth = Carbon::now()->subMonth();

        $current = ContactUs::whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->count();

        $previous = ContactUs::whereMonth('created_at', $previousMonth->month)
            ->whereYear('created_at', $previousMonth->year)
            ->count();

        return $this->formatStat($current, $previous);
    }

    /* ---------------- REQUESTS BY SERVICE ---------------- */
    private function getRequestsByService(): array
    {
        $currentMonth  = Carbon::now();
        $previousMonth = Carbon::now()->subMonth();

        $current = RequestService::query()
            ->select(
                'services.id',
                DB::raw('COUNT(request_services.id) as total')
            )
            ->join('services', 'request_services.service_id', '=', 'services.id')
            ->whereMonth('request_services.created_at', $currentMonth->month)
            ->whereYear('request_services.created_at', $currentMonth->year)
            ->groupBy('services.id')
            ->get()
            ->keyBy('id');

        $previous = RequestService::query()
            ->select(
                'services.id',
                DB::raw('COUNT(request_services.id) as total')
            )
            ->join('services', 'request_services.service_id', '=', 'services.id')
            ->whereMonth('request_services.created_at', $previousMonth->month)
            ->whereYear('request_services.created_at', $previousMonth->year)
            ->groupBy('services.id')
            ->get()
            ->keyBy('id');

        return Service::select('id', 'title_ar')
            ->get()
            ->map(function ($service) use ($current, $previous) {

                $currentCount  = $current[$service->id]->total ?? 0;
                $previousCount = $previous[$service->id]->total ?? 0;

                return [
                    'service' => $service->title_ar,
                    ...$this->formatStat($currentCount, $previousCount),
                ];
            })
            ->values()
            ->all();
    }

    /* ---------------- HELPERS ---------------- */
    private function formatStat(int $current, int $previous): array
    {
        $percentage = $previous > 0
            ? (($current - $previous) / $previous) * 100
            : 0;

        return [
            'count'      => $current,
            'percentage' => round($percentage, 2),
            'trend'      => $this->getTrend($percentage),
        ];
    }

    private function getTrend(float $percentage): string
    {
        return match (true) {
            $percentage > 0 => 'up',
            $percentage < 0 => 'down',
            default         => 'neutral',
        };
    }
}
