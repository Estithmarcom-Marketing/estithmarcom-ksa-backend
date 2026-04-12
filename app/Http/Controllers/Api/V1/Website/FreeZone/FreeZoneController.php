<?php

namespace App\Http\Controllers\Api\V1\Website\FreeZone;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\FreeZone\ListFreeZonesRequest;
use App\Http\Resources\Website\FreeZone\FreeZoneResource;
use App\Services\V1\Website\FreeZone\FreeZoneService;
use App\Traits\ApiResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

#[Group('Website FreeZone')]
class FreeZoneController extends Controller
{
    use ApiResponse;
    public function __construct(public FreeZoneService $service) {}
      /**
     * @unauthenticated
     */
    public function index(ListFreeZonesRequest $request)
    {
        try {
            $zones = $this->service->list($request->validated());
            $zones = FreeZoneResource::collection($zones)->response()->getData(true);
            return ApiResponse::success([
                'zones' => $zones['data'],
                'meta' => $zones['meta'],
                'links' => $zones['links'],
            ], __('free_zone.listed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error("Failed to list free zones", ['error' => $th->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);
            return ApiResponse::error(__('free_zone.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
      /**
     * @unauthenticated
     */
    public function show(string $identifier)
    {
        try {
            $zone = $this->service->show($identifier);
            $zone = FreeZoneResource::make($zone);
            return ApiResponse::success(['zone' => $zone], __('free_zone.showed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error("Failed to show free zone", ['error' => $th->getMessage(), 'identifier' => $identifier, 'method' => __METHOD__]);
            return ApiResponse::error(__('free_zone.showed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
