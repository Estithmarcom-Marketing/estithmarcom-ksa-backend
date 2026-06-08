<?php

namespace App\Http\Controllers\Api\V1\Admin\Notification;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Notification\ListNotificationsRequest;
use App\Http\Resources\Admin\Notification\NotificationResource;
use App\Models\Notification;
use App\Services\V1\Admin\Notification\NotificationService;
use App\Traits\ApiResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

#[Group('Admin Notification')]
class NotificationController extends Controller
{
    public function __construct(public NotificationService $service) {}
    public function index(ListNotificationsRequest $request)
    {
        try {
            $notifications = $this->service->list($request->validated());
            $notifications = NotificationResource::collection($notifications)->response()->getData(true);
            return ApiResponse::success([
                'notifications' => $notifications['data'],
                'meta' => $notifications['meta']
            ], __('notification.listed_successfully'));
        } catch (\Throwable $th) {
            Log::error('Failed to list notifications', ['error' => $th->getMessage(), 'method' => __METHOD__]);
            return ApiResponse::error(__('notification.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function markAllAsRead()
    {
        try {
            $this->service->markAllAsRead();
            return ApiResponse::success([], __('notification.marked_all_as_read_successfully'));
        } catch (\Throwable $th) {
            Log::error('Failed to mark notifications as read', ['error' => $th->getMessage(), 'method' => __METHOD__]);
            return ApiResponse::error(__('notification.marked_all_as_read_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function markAsRead(Notification $notification)
    {
        try {
            $this->service->markAsRead($notification);
            return ApiResponse::success([], __('notification.marked_as_read_successfully'));
        } catch (\Throwable $th) {
            Log::error('Failed to mark notification as read', ['error' => $th->getMessage(), 'method' => __METHOD__]);
            return ApiResponse::error(__('notification.marked_as_read_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
