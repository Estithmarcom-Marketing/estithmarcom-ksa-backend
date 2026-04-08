<?php

namespace App\Http\Controllers\Api\V1\Admin\FreeZone;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FreeZone\ListFreeZonesRequest;
use App\Http\Requests\Admin\FreeZone\StoreFreeZoneRequest;
use App\Http\Requests\Admin\FreeZone\UpdateFreeZoneRequest;
use App\Http\Resources\Admin\FreeZone\FreeZoneResource;
use App\Models\FreeZone;
use App\Services\V1\Admin\FreeZone\FreeZoneService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class FreeZoneController extends Controller
{
    use ApiResponse;

    public function __construct(public FreeZoneService $service) {}
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
            Log::error('Failed to list free zones', ['error' => $th->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);
            return ApiResponse::error(__('free_zone.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function store(StoreFreeZoneRequest $request)
    {
        try {
            $zone = $this->service->store($request->validated());
            $zone = FreeZoneResource::make($zone);
            return ApiResponse::success(['zone' => $zone], __('free_zone.stored_successfully'), Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::error('Failed to create free zone', ['error' => $th->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);
            return ApiResponse::error(__('free_zone.stored_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function show(FreeZone $freeZone)
    {
        try {
            $zone = $this->service->show($freeZone);
            $zone = FreeZoneResource::make($zone);
            return ApiResponse::success(['zone' => $zone], __('free_zone.showed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to show free zone', ['error' => $th->getMessage(), 'freeZone_id' => $freeZone->id, 'method' => __METHOD__]);
            return ApiResponse::error(__('free_zone.showed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function update(UpdateFreeZoneRequest $request, FreeZone $freeZone)
    {
        try {
            $zone = $this->service->update($freeZone, $request->validated());
            $zone = FreeZoneResource::make($zone);
            return ApiResponse::success(['zone' => $zone], __('free_zone.updated_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to update free zone', ['error' => $th->getMessage(), 'freeZone_id' => $freeZone->id, 'request' => $request->validated(), 'method' => __METHOD__]);
            return ApiResponse::error(__('free_zone.updated_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function delete(FreeZone $freeZone)
    {
        try {
            $this->service->destroy($freeZone);
            return ApiResponse::deleted();
        } catch (\Throwable $th) {
            Log::error('Failed to delete free zone', ['error' => $th->getMessage(), 'freeZone_id' => $freeZone->id, 'method' => __METHOD__]);
            return ApiResponse::error(__('free_zone.deleted_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
