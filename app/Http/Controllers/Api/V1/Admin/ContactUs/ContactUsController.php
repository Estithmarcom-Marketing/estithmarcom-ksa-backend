<?php

namespace App\Http\Controllers\Api\V1\Admin\ContactUs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContactUs\ListContactUsRequest;
use App\Http\Requests\Admin\ContactUs\UpdateContactUsStatusRequest;
use App\Http\Resources\Admin\ContactUs\ContactUsResource;
use App\Models\ContactUs;
use App\Services\V1\Admin\ContactUs\ContactUsService;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Dedoc\Scramble\Attributes\Group;
#[Group('Admin Contact Us')]
class ContactUsController extends Controller
{
    use ApiResponse;

    public function __construct(public ContactUsService $service) {}

    public function index(ListContactUsRequest $request)
    {
        try {
            $contactUs = $this->service->list($request->validated());
            $contactUs = ContactUsResource::collection($contactUs)->response()->getData(true);

            return ApiResponse::success([
                'contact_us' => $contactUs['data'],
                'meta' => $contactUs['meta'],
                'links' => $contactUs['links'],
            ], __('contact_us.listed_successfully'));
        } catch (\Exception $e) {
            Log::error('Failed to list contact us', ['error' => $e->getMessage(), 'method' => __METHOD__]);

            return ApiResponse::error(__('contact_us.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(ContactUs $contactUs)
    {
        try {
            $contactUs = $this->service->show($contactUs);
            $contactUs = ContactUsResource::make($contactUs);

            return ApiResponse::success([
                'contact_us' => $contactUs,
            ], __('contact_us.showed_successfully'));
        } catch (\Exception $e) {
            Log::error('Failed to show contact us', ['error' => $e->getMessage(), 'method' => __METHOD__]);

            return ApiResponse::error(__('contact_us.showed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(ContactUs $contactUs)
    {
        try {
            $contactUs = $this->service->destroy($contactUs);

            return ApiResponse::deleted();
        } catch (\Exception $e) {
            Log::error('Failed to delete contact us', ['error' => $e->getMessage(), 'method' => __METHOD__]);

            return ApiResponse::error(__('contact_us.deleted_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(ContactUs $contactUs, UpdateContactUsStatusRequest $request)
    {
        try {
            $contactUs = $this->service->updateStatus($contactUs, $request->validated());

            return ApiResponse::success([
                'contact_us' => $contactUs,
            ], __('contact_us.updated_successfully'));
        } catch (\Exception $e) {
            Log::error('Failed to update contact us', ['error' => $e->getMessage(), 'method' => __METHOD__]);

            return ApiResponse::error(__('contact_us.updated_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
