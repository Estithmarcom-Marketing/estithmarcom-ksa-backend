<?php

namespace App\Http\Controllers\Api\V1\Website\RequestResidency;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\RequestResidency\RequestResidencyRequest;
use App\Services\V1\Website\RequestResidency\RequestResidencyService;
use App\Traits\ApiResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

#[Group('Website Request Residencies')]
class RequestResidencyController extends Controller
{
    public function __construct(public RequestResidencyService $service) {}
    public function __invoke(RequestResidencyRequest $request)
    {
        try {
            $this->service->store($request->validated());
            return ApiResponse::success([], __('request_residency.created_successfully'), Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::error('Error creating request residency', ['error' => $th->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);
            return ApiResponse::error(__('request_residency.created_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
