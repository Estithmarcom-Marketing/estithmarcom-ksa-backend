<?php

namespace App\Http\Controllers\Api\V1\Admin\Message;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Message\ListMessagesRequest;
use App\Http\Requests\Admin\Message\UpdateMessageStatusRequest;
use App\Http\Resources\Admin\Message\MessageResource;
use App\Models\Message;
use App\Services\V1\Admin\Message\MessageService;
use App\Traits\ApiResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

#[Group('Admin Chatbot Message')]
class MessageController extends Controller
{
    public function __construct(public MessageService $service) {}
    public function index(ListMessagesRequest $request)
    {
        try {
            $messages = $this->service->list($request->validated());
            $messages = MessageResource::collection($messages)->response()->getData(true);
            return ApiResponse::success([
                'messages' => $messages['data'],
                'meta' => $messages['meta']
            ], __('message.listed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to list chatbot messages', ['error' => $th->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);
            return ApiResponse::error(__('message.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function show(Message $message)
    {
        try {
            $message = $this->service->show($message);
            $message = MessageResource::make($message);
            return ApiResponse::success(['message' => $message], __('message.showed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to show chatbot message', ['error' => $th->getMessage(), 'method' => __METHOD__]);
            return ApiResponse::error(__('message.showed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function update(UpdateMessageStatusRequest $request, Message $message)
    {
        try {
            $message = $this->service->update($message, $request->validated());
            $message = MessageResource::make($message);
            return ApiResponse::success(['message' => $message], __('message.updated_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to update chatbot message', ['error' => $th->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);
            return ApiResponse::error(__('message.updated_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function delete(Message $message)
    {
        try {
            $message = $this->service->destroy($message);
            return ApiResponse::success([], __('message.deleted_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to destroy chatbot message', ['error' => $th->getMessage(), 'method' => __METHOD__]);
            return ApiResponse::error(__('message.deleted_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
