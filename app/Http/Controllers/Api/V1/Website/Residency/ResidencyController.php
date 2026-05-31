<?php

namespace App\Http\Controllers\Api\V1\Website\Residency;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Residency\ListResidenciesRequest;
use App\Http\Resources\Website\Residency\ResidencyResource;
use App\Services\V1\Website\Residency\ResidencyService;
use App\Traits\ApiResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

#[Group('Website Residencies')]
class ResidencyController extends Controller
{
    public function __construct(public ResidencyService $service) {}
    /**
     * @unauthenticated
     */
    public function index(ListResidenciesRequest $request)
    {
        try {
            $residencies = $this->service->list($request->validated());
            $residencies = ResidencyResource::collection($residencies)->response()->getData(true);
            return ApiResponse::success([
                'residencies' => $residencies['data'],
                'meta' => $residencies['meta'],
            ], __('residency.listed_successfully'));
        } catch (\Throwable $th) {
            Log::error('Failed to list residencies', ['error' => $th->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);
            return ApiResponse::error(__('residency.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @unauthenticated
     */
    public function show($identifier)
    {
        try {
            $residency = $this->service->show($identifier);
            $residency = ResidencyResource::make($residency);
            return ApiResponse::success(['residency' => $residency], __('residency.showed_successfully'));
        } catch (ModelNotFoundException $e) {
            Log::error('Residency not found', ['error' => $e->getMessage(), 'identifier' => $identifier, 'method' => __METHOD__]);
            return ApiResponse::error(__('residency.not_found'), Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            Log::error('Failed to show residency', ['error' => $th->getMessage(), 'identifier' => $identifier, 'method' => __METHOD__]);
            return ApiResponse::error(__('residency.showed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
