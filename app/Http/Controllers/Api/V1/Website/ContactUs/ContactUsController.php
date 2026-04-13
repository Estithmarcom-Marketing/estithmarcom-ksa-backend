<?php

namespace App\Http\Controllers\Api\V1\Website\ContactUs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\ContactUs\StoreContactUsRequest;
use App\Services\V1\Website\ContactUs\ContactUsService;
use App\Traits\ApiResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

#[Group('Website Contact Us')]
class ContactUsController extends Controller
{
    public function __construct(public ContactUsService $service) {}
    /**
     * @unauthenticated
     */
    public function __invoke(StoreContactUsRequest $request)
    {
        try {
            $this->service->store($request->validated());
            return ApiResponse::success([], __('contact_us.stored_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to store contact us message', ['error' => $th->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);
            return ApiResponse::error(__('contact_us.stored_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
