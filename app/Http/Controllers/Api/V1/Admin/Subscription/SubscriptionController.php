<?php

namespace App\Http\Controllers\Api\V1\Admin\Subscription;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Subscription\ListSubscriptionsRequest;
use App\Http\Resources\Admin\Subscription\SubscriptionResource;
use App\Models\Subscription;
use App\Services\V1\Admin\Subscription\SubscriptionService;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionController extends Controller
{
    use ApiResponse;

    public function __construct(public SubscriptionService $service) {}

    public function index(ListSubscriptionsRequest $request)
    {
        try {
            $subscriptions = $this->service->index($request->validated());
            $subscriptions = SubscriptionResource::collection($subscriptions)->response()->getData(true);

            return ApiResponse::success([
                'subscriptions' => $subscriptions['data'],
                'meta' => $subscriptions['meta'],
                'links' => $subscriptions['links'],
            ], __('subscription.listed_successfully'), Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Failed to list subscriptions', ['error' => $e->getMessage(), 'request' => $request->validated, 'method' => __METHOD__]);

            return ApiResponse::error(__('subscription.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(Subscription $subscription)
    {
        try {
            $this->service->destroy($subscription);

            return ApiResponse::deleted();
        } catch (\Exception $e) {
            Log::error('Failed to delete subscription', ['error' => $e->getMessage(), 'method' => __METHOD__]);

            return ApiResponse::error(__('subscription.deleted_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
