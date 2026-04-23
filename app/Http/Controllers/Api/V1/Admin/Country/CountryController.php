<?php

namespace App\Http\Controllers\Api\V1\Admin\Country;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Country\ListCountryRequest;
use App\Http\Requests\Admin\Country\StoreCountryRequest;
use App\Http\Requests\Admin\Country\UpdateCountryRequest;
use App\Http\Resources\Admin\Country\CountryResource;
use App\Models\Country;
use App\Services\V1\Admin\Country\CountryService;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Dedoc\Scramble\Attributes\Group;

#[Group('Admin Country')]

class CountryController extends Controller
{
    use ApiResponse;

    public function __construct(public CountryService $service) {}

    public function index(ListCountryRequest $request)
    {
        try {
            $countries = $this->service->list($request->validated());
            $countries = CountryResource::collection($countries)->response()->getData(true);

            return ApiResponse::success([
                'countries' => $countries['data'],
                'meta' => $countries['meta'],
                'links' => $countries['links'],
            ], __('country.listed_successfully'));
        } catch (\Exception $e) {
            Log::error('Failed to list countries', ['error' => $e->getMessage(), 'method' => __METHOD__]);

            return ApiResponse::error(__('country.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function listWithoutPagination()
    {
        try {
            $countries = $this->service->listWithoutPagination();
            $countries = CountryResource::collection($countries);

            return ApiResponse::success([
                'countries' => $countries,
            ], __('country.listed_successfully'));
        } catch (\Exception $e) {
            Log::error('Failed to list countries without pagination', ['error' => $e->getMessage(), 'method' => __METHOD__]);

            return ApiResponse::error(__('country.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Country $country)
    {
        try {
            $country = $this->service->show($country);
            $country = CountryResource::make($country);

            return ApiResponse::success([
                'country' => $country,
            ], __('country.showed_successfully'));
        } catch (\Exception $e) {
            Log::error('Failed to show country', ['error' => $e->getMessage(), 'method' => __METHOD__]);

            return ApiResponse::error(__('country.showed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreCountryRequest $request)
    {
        try {
            $country = $this->service->store($request->validated());
            $country = CountryResource::make($country);

            return ApiResponse::success([
                'country' => $country,
            ], __('country.created_successfully'));
        } catch (\Exception $e) {
            Log::error('Failed to create country', ['error' => $e->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);

            return ApiResponse::error(__('country.created_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Country $country, UpdateCountryRequest $request)
    {
        try {
            $country = $this->service->update($country, $request->validated());
            $country = CountryResource::make($country);

            return ApiResponse::success([
                'country' => $country,
            ], __('country.updated_successfully'));
        } catch (\Exception $e) {
            Log::error('Failed to update country', ['error' => $e->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);

            return ApiResponse::error(__('country.updated_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Country $country)
    {
        try {
            $this->service->destroy($country);

            return ApiResponse::deleted();
        } catch (\Exception $e) {
            Log::error('Failed to delete country', ['error' => $e->getMessage(), 'method' => __METHOD__]);

            return ApiResponse::error(__('country.deleted_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
