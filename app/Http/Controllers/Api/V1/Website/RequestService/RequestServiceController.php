<?php

namespace App\Http\Controllers\Api\V1\Website\RequestService;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\RequestService\RequestServiceRequest;
use App\Services\V1\Website\RequestService\RequestServiceManagementService;
use App\Traits\ApiResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

#[Group('Website Request Service')]
class RequestServiceController extends Controller
{
    public function __construct(public RequestServiceManagementService $service) {}
    public function __invoke(RequestServiceRequest $request)
    {
        try {
            $this->service->store($request->validated());
            return ApiResponse::success([], __('request_service.stored_successfully'), Response::HTTP_CREATED);
        } catch (\LogicException $e) {
            Log::error('Failed to store request service', ['error' => $e->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);
            return ApiResponse::error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $th) {
            Log::error('Failed to store request service', ['error' => $th->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);
            return ApiResponse::error(__('request_service.stored_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
