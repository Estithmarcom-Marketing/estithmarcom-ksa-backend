<?php

namespace App\Http\Controllers\Api\V1\Admin\DashboardStats;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\DashboardStats\DashboardStatsResource;
use App\Services\V1\Admin\DashboardStats\DashboardStatsService;
use App\Traits\ApiResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

#[Group('Admin Dashboard Stats')]
class DashboardStatsController extends Controller
{
    public function __construct(public DashboardStatsService $service) {}
    public function __invoke()
    {
        try {
            $stats = $this->service->getDashboardStats();
            $stats = DashboardStatsResource::make($stats);
            return ApiResponse::success([
                'stats' => $stats
            ], __('stats.listed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to retrieve dashboard stats', ['error' => $th->getMessage(), 'method' => __METHOD__]);
            return ApiResponse::error(__('stats.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
