<?php

namespace App\Http\Controllers\Api\V1\Website\Country;

use App\Http\Controllers\Controller;
use App\Http\Resources\Website\Country\CountryResource;
use App\Services\V1\Website\Country\CountryService;
use App\Traits\ApiResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

#[Group('Website Country')]
class CountryController extends Controller
{
    use ApiResponse;
    public function __construct(public CountryService $service) {}
    /**
     * @unauthenticated
     */
    public function index()
    {
        try {
            $countries = $this->service->list();
            $countries = CountryResource::collection($countries)->response()->getData(true);

            return ApiResponse::success([
                'countries' => $countries['data'],
                'meta' => $countries['meta'],
                'links' => $countries['links'],
            ], __('country.listed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to list countries', ['error' => $th->getMessage(), 'method' => __METHOD__]);
            return ApiResponse::error(__('country.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @unauthenticated
     */
    public function listWithoutPagination()
    {
        try {
            $countries = $this->service->listWithoutPagination();
            $countries = CountryResource::collection($countries);

            return ApiResponse::success([
                'countries' => $countries,
            ], __('country.listed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to list countries', ['error' => $th->getMessage(), 'method' => __METHOD__]);
            return ApiResponse::error(__('country.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
