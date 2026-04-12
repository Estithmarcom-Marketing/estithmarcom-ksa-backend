<?php

namespace App\Http\Controllers\Api\V1\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\UpdateSettingRequest;
use App\Http\Resources\Admin\Setting\SettingResource;
use App\Services\V1\Admin\Setting\SettingService;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Dedoc\Scramble\Attributes\Group;

#[Group('Admin Settings')]
class SettingController extends Controller
{
    use ApiResponse;

    public function __construct(public SettingService $service) {}

    public function index()
    {
        try {
            $settings = $this->service->index();
            $settings = SettingResource::make($settings);

            return ApiResponse::success([
                'settings' => $settings,
            ], __('setting.listed_successfully'));
        } catch (\Exception $e) {
            Log::error('Failed to list settings', ['error' => $e->getMessage(), 'method' => __METHOD__]);

            return ApiResponse::error(__('setting.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateSettingRequest $request)
    {
        try {
            $settings = $this->service->update($request->validated());
            $settings = SettingResource::make($settings);

            return ApiResponse::success([
                'settings' => $settings,
            ], __('setting.updated_successfully'));
        } catch (\Exception $e) {
            Log::error('Failed to update settings', ['error' => $e->getMessage(), 'method' => __METHOD__]);

            return ApiResponse::error(__('setting.updated_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
