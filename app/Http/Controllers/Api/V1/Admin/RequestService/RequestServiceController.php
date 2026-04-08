<?php

namespace App\Http\Controllers\Api\V1\Admin\RequestService;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RequestService\ListRequestServicesRequest;
use App\Http\Requests\Admin\RequestService\UpdateRequestServiceStatusRequest;
use App\Http\Resources\Admin\RequestService\RequestServiceResource;
use App\Models\RequestService;
use App\Services\V1\Admin\RequestService\RequestServiceManagementService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RequestServiceController extends Controller
{
    use ApiResponse;
    public function __construct(public RequestServiceManagementService $service) {}
    public function index(ListRequestServicesRequest $request)
    {
        try {
            $requests = $this->service->list($request->validated());
            $requests = RequestServiceResource::collection($requests)->response()->getData(true);
            return ApiResponse::success([
                'requests' => $requests['data'],
                'meta' => $requests['meta'],
                'links' => $requests['links'],
            ], __('request_service.listed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to list request services', ['error' => $th->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);
            return ApiResponse::error(__('request_service.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function show(RequestService $requestService)
    {
        try {
            $requestService = $this->service->show($requestService);
            $requestService = RequestServiceResource::make($requestService);
            return ApiResponse::success([
                'request' => $requestService,
            ], __('request_service.showed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to show request service', ['error' => $th->getMessage(), 'requestService_id' => $requestService->id, 'method' => __METHOD__]);
            return ApiResponse::error(__('request_service.showed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function update(RequestService $requestService, UpdateRequestServiceStatusRequest $request)
    {
        try {
            $requestService = $this->service->update($requestService, $request->validated());
            $requestService = RequestServiceResource::make($requestService);
            return ApiResponse::success([
                'request' => $requestService,
            ], __('request_service.updated_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to update request service', ['error' => $th->getMessage(), 'requestService_id' => $requestService->id, 'request' => $request->validated(), 'method' => __METHOD__]);
            return ApiResponse::error(__('request_service.updated_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function delete(RequestService $requestService)
    {
        try {
            $this->service->destroy($requestService);
            return ApiResponse::deleted();
        } catch (\Throwable $th) {
            Log::error('Failed to delete request service', ['error' => $th->getMessage(), 'requestService_id' => $requestService->id, 'method' => __METHOD__]);
            return ApiResponse::error(__('request_service.deleted_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
