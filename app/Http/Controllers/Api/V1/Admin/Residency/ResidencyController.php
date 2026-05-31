<?php

namespace App\Http\Controllers\Api\V1\Admin\Residency;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Residency\ListResidenciesRequest;
use App\Http\Requests\Admin\Residency\StoreResidencyRequest;
use App\Http\Requests\Admin\Residency\UpdateResidencyRequest;
use App\Http\Resources\Admin\Residency\ResidencyResource;
use App\Models\Residency;
use App\Services\V1\Admin\Residency\ResidencyService;
use App\Traits\ApiResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

#[Group('Admin Residencies')]

class ResidencyController extends Controller
{
    public function __construct(public ResidencyService $service) {}
    public function index(ListResidenciesRequest $request)
    {
        try {
            $residencies = $this->service->list($request->validated());
            $residencies = ResidencyResource::collection($residencies)->response()->getData(true);
            return ApiResponse::success(['residencies' => $residencies['data'], 'meta' => $residencies['meta']], __('residency.listed_successfully'));
        } catch (\Throwable $th) {
            Log::error('Failed to list residencies', ['error' => $th->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);
            return ApiResponse::error(__('residency.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function show(Residency $residency)
    {
        try {
            $residency = $this->service->show($residency);
            $residency = ResidencyResource::make($residency);
            return ApiResponse::success(['residency' => $residency], __('residency.showed_successfully'));
        } catch (\Throwable $th) {
            Log::error('Failed to show residency', ['error' => $th->getMessage(), 'residency_id' => $residency->id, 'method' => __METHOD__]);
            return ApiResponse::error(__('residency.showed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function store(StoreResidencyRequest $request)
    {
        try {
            $residency = $this->service->store($request->validated());
            $residency = ResidencyResource::make($residency);
            return ApiResponse::success(['residency' => $residency], __('residency.stored_successfully'), Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::error('Failed to store residency', ['error' => $th->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);
            return ApiResponse::error(__('residency.stored_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function update(UpdateResidencyRequest $request, Residency $residency)
    {
        try {
            $residency = $this->service->update($residency, $request->validated());
            $residency = ResidencyResource::make($residency);
            return ApiResponse::success(['residency' => $residency], __('residency.updated_successfully'));
        } catch (\Throwable $th) {
            Log::error('Failed to update residency', ['error' => $th->getMessage(), 'residency_id' => $residency->id, 'request' => $request->validated(), 'method' => __METHOD__]);
            return ApiResponse::error(__('residency.updated_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function delete(Residency $residency)
    {
        try {
            $this->service->destroy($residency);
            return ApiResponse::success([], __('residency.deleted_successfully'));
        } catch (\Throwable $th) {
            Log::error('Failed to destroy residency', ['error' => $th->getMessage(), 'residency_id' => $residency->id, 'method' => __METHOD__]);
            return ApiResponse::error(__('residency.deleted_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
