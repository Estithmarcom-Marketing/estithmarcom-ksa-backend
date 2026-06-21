<?php

namespace App\Http\Controllers\Api\V1\Website\Message;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Message\StoreMessageRequest;
use App\Services\V1\Website\Message\MessageService;
use App\Traits\ApiResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

#[Group('Website Chatbot Message')]
class MessageController extends Controller
{
    public function __construct(public MessageService $service) {}
    /**
     * @unauthenticated
     */
    public function __invoke(StoreMessageRequest $request)
    {
        try {
            $this->service->store($request->validated());
            return ApiResponse::success([], __('message.stored_successfully'), Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::error('Failed to store chatbot  message', ['error' => $th->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);
            return ApiResponse::error(__('message.stored_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
