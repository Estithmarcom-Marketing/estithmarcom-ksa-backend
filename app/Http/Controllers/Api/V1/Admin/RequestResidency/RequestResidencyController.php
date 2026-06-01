<?php

namespace App\Http\Controllers\Api\V1\Admin\RequestResidency;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RequestResidency\ListRequestResidenciesRequest;
use App\Http\Requests\Admin\RequestResidency\UpdateRequestResidencyStatusRequest;
use App\Http\Resources\Admin\RequestResidency\RequestResidencyResource;
use App\Models\RequestResidency;
use App\Services\V1\Admin\RequestResidency\RequestResidencyService;
use App\Traits\ApiResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

#[Group('Admin Request Residencies')]
class RequestResidencyController extends Controller
{
    public function __construct(private RequestResidencyService $service) {}
    public function index(ListRequestResidenciesRequest $request)
    {
        try {
            $residenciesRequests = $this->service->list($request->validated());
            $residenciesRequests = RequestResidencyResource::collection($residenciesRequests)->response()->getData(true);
            return ApiResponse::success(['residenciesRequests' => $residenciesRequests['data'], 'meta' => $residenciesRequests['meta']], __('request_residency.listed_successfully'));
        } catch (\Throwable $th) {
            Log::error('Failed to list residencies requests', ['error' => $th->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);
            return ApiResponse::error(__('request_residency.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function show(RequestResidency $requestResidency)
    {
        try {
            $requestResidency = $this->service->show($requestResidency);
            $requestResidency = RequestResidencyResource::make($requestResidency);
            return ApiResponse::success(['requestResidency' => $requestResidency], __('request_residency.showed_successfully'));
        } catch (\Throwable $th) {
            Log::error('Failed to retrieve residency request', ['error' => $th->getMessage(), 'request_id' => $requestResidency->id, 'method' => __METHOD__]);
            return ApiResponse::error(__('request_residency.showed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function update(UpdateRequestResidencyStatusRequest $request, RequestResidency $requestResidency)
    {
        try {
            $requestResidency = $this->service->update($requestResidency, $request->validated());
            $requestResidency = RequestResidencyResource::make($requestResidency);
            return ApiResponse::success(['requestResidency' => $requestResidency], __('request_residency.status_updated_successfully'));
        } catch (\Throwable $th) {
            Log::error('Failed to update residency request status', ['error' => $th->getMessage(), 'request_id' => $requestResidency->id, 'method' => __METHOD__]);
            return ApiResponse::error(__('request_residency.status_updated_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function delete(RequestResidency $requestResidency)
    {
        try {
            $this->service->destroy($requestResidency);
            return ApiResponse::success([], __('request_residency.deleted_successfully'));
        } catch (\Throwable $th) {
            Log::error('Failed to delete residency request', ['error' => $th->getMessage(), 'request_id' => $requestResidency->id, 'method' => __METHOD__]);
            return ApiResponse::error(__('request_residency.deleted_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
