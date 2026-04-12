<?php

namespace App\Http\Controllers\Api\V1\Admin\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Service\ListServicesRequest;
use App\Http\Requests\Admin\Service\StoreServiceRequest;
use App\Http\Requests\Admin\Service\UpdateServiceRequest;
use App\Http\Resources\Admin\Service\ServiceResource;
use App\Models\Service;
use App\Services\V1\Admin\Service\ServiceManager;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Dedoc\Scramble\Attributes\Group;

#[Group('Admin Service')]
class ServiceController extends Controller
{
    use ApiResponse;

    public function __construct(public ServiceManager $service) {}

    public function index(ListServicesRequest $request)
    {
        try {
            $services = $this->service->index($request->validated());
            $services = ServiceResource::collection($services)->response()->getData(true);

            return ApiResponse::success([
                'services' => $services['data'],
                'meta' => $services['meta'],
                'links' => $services['links'],
            ], __('service.listed_successfully'), Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Failed to list services', ['error' => $e->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);

            return ApiResponse::error(__('service.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Service $service)
    {
        try {
            $service = $this->service->show($service);
            $service = ServiceResource::make($service);

            return ApiResponse::success(['service' => $service], __('service.showed_successfully'));
        } catch (\Exception $e) {
            Log::error('Failed to show service', ['error' => $e->getMessage(), 'service_id' => $service->id, 'method' => __METHOD__]);

            return ApiResponse::error(__('service.showed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreServiceRequest $request)
    {
        try {
            $service = $this->service->store($request->validated());
            $service = ServiceResource::make($service);

            return ApiResponse::success(['service' => $service], __('service.stored_successfully'), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error('Failed to store service', ['error' => $e->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);

            return ApiResponse::error(__('service.stored_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        try {
            $service = $this->service->update($service, $request->validated());
            $service = ServiceResource::make($service);

            return ApiResponse::success(['service' => $service], __('service.updated_successfully'));
        } catch (\Exception $e) {
            Log::error('Failed to update service', ['error' => $e->getMessage(), 'service_id' => $service->id, 'request' => $request->validated(), 'method' => __METHOD__]);

            return ApiResponse::error(__('service.updated_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(Service $service)
    {
        try {
            $this->service->destroy($service);

            return ApiResponse::deleted();
        } catch (\Exception $e) {
            Log::error('Failed to delete service', ['error' => $e->getMessage(), 'service_id' => $service->id, 'method' => __METHOD__]);

            return ApiResponse::error(__('service.deleted_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
