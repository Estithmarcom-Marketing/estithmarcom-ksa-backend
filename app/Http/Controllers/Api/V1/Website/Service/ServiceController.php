<?php

namespace App\Http\Controllers\Api\V1\Website\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Service\ListServicesRequest;
use App\Http\Resources\Website\Service\ServiceResource;
use App\Http\Resources\Website\Service\ServiceSiteMapResource;
use App\Services\V1\Website\Service\ServiceManager;
use App\Traits\ApiResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

#[Group('Website Service')]
class ServiceController extends Controller
{
    use ApiResponse;
    public function __construct(public ServiceManager $service) {}
    /**
     * @unauthenticated
     */
    public function index(ListServicesRequest $request)
    {
        try {
            $service = $this->service->list($request->validated());
            $service = ServiceResource::collection($service)->response()->getData(true);
            return ApiResponse::success([
                'services' => $service['data'],
                'meta' => $service['meta'],
                'links' => $service['links']
            ], __('service.listed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to list services', ['error' => $th->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);
            return ApiResponse::error(__('service.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @unauthenticated
     */
    public function show($identifier)
    {
        try {
            $service = $this->service->show($identifier);
            $service = ServiceResource::make($service);
            return ApiResponse::success([
                'service' => $service,
            ], __('service.showed_successfully'), Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            Log::error('Service not found', ['error' => $e->getMessage(), 'service_identifier' => $identifier, 'method' => __METHOD__]);
            return ApiResponse::error(__('service.not_found'), Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            Log::error('Failed to show service', ['error' => $th->getMessage(), 'service_identifier' => $identifier, 'method' => __METHOD__]);
            return ApiResponse::error(__('service.showed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @unauthenticated
     */
    public function listWithoutPagination()
    {
        try {
            $services = $this->service->listWithoutPagination();
            $services = ServiceResource::collection($services);
            return ApiResponse::success([
                'services' => $services,
            ], __('service.listed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to list services', ['error' => $th->getMessage(), 'method' => __METHOD__]);
            return ApiResponse::error(__('service.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @unauthenticated
     */
    public function getAllForSiteMap()
    {
        try {
            $services = $this->service->getAllForSiteMap();
            $services = ServiceSiteMapResource::collection($services);
            return ApiResponse::success([
                'services' => $services,
            ], __('service.listed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to list services for site map', ['error' => $th->getMessage(), 'method' => __METHOD__]);
            return ApiResponse::error(__('service.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
