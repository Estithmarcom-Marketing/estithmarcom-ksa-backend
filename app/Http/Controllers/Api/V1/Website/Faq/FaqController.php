<?php

namespace App\Http\Controllers\Api\V1\Website\Faq;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Faq\ListFaqsRequest;
use App\Http\Resources\Website\Faq\FaqResource;
use App\Services\V1\Website\Faq\FaqService;
use App\Traits\ApiResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

#[Group('Website Faq')]
class FaqController extends Controller
{
    public function __construct(public FaqService $service) {}
    /**
     * @unauthenticated
     */
    public function __invoke(ListFaqsRequest $request)
    {
        try {
            $faqs = $this->service->list($request->validated());
            $faqs = FaqResource::collection($faqs)->response()->getData(true);
            return ApiResponse::success([
                'faqs' => $faqs['data'],
                'meta' => $faqs['meta'],
                'links' => $faqs['links']
            ], __('faq.listed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to list faqs', ['error' => $th->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);
            return ApiResponse::error(__('faq.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
