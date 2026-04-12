<?php

namespace App\Http\Controllers\Api\V1\Website\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\Website\Setting\SettingResource;
use App\Services\V1\Website\Setting\SettingService;
use App\Traits\ApiResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

#[Group('Website Settings')]
class SettingController extends Controller
{
    use ApiResponse;
    public function __construct(public SettingService $service) {}

    /**
     *@unauthenticated
     */
    public function __invoke()
    {
        try {
            $settings = $this->service->getSettings();
            $settings = SettingResource::make($settings);
            return ApiResponse::success([
                'settings' => $settings
            ], __('setting.listed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to list settings', ['error' => $th->getMessage(), 'method' => __METHOD__]);
            return ApiResponse::error(__('setting.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
