<?php

namespace App\Http\Controllers\Api\V1\Website\Subscription;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Subscription\SubscribeRequest;
use App\Services\V1\Website\Subscription\SubscriptionService;
use App\Traits\ApiResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

#[Group('Website Subscription')]
class SubscriptionController extends Controller
{
    public function __construct(public SubscriptionService $service) {}
    public function __invoke(SubscribeRequest $request)
    {
        try {
            $this->service->store($request->validated());
            return ApiResponse::success([], __('subscription.subscribed_successfully'), Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::error('Failed to subscribe', ['error' => $th->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);
            return ApiResponse::error(__('subscription.subscribed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
