<?php

namespace App\Http\Controllers\Api\V1\Admin\Faq;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Faq\ListFaqsRequest;
use App\Http\Requests\Admin\Faq\StoreFaqRequest;
use App\Http\Requests\Admin\Faq\UpdateFaqRequest;
use App\Http\Resources\Admin\Faq\FaqResource;
use App\Models\Faq;
use App\Services\V1\Admin\Faq\FaqService;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class FaqController extends Controller
{
    use ApiResponse;

    public function __construct(protected FaqService $service) {}

    public function index(ListFaqsRequest $request)
    {
        try {
            $faqs = $this->service->index($request->validated());
            $faqs = FaqResource::collection($faqs)
                ->response()
                ->getData(true);

            return ApiResponse::success(
                [
                    'faqs' => $faqs['data'],
                    'meta' => $faqs['meta'],
                    'links' => $faqs['links'],
                ],
                __('faq.listed_successfully'),
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            Log::error(
                'Failed to get common questions',
                [
                    'error' => $e->getMessage(),
                    'request' => $request->validated(),
                    'method' => __METHOD__,
                ]
            );

            return ApiResponse::error(__('faq.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Faq $faq)
    {
        try {
            $faq = $this->service->show($faq);

            return ApiResponse::success(
                ['faq' => FaqResource::make($faq)],
                __('faq.showed_successfully'),
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            Log::error(
                'Failed to get common question',
                ['error' => $e->getMessage(), 'method' => __METHOD__]
            );

            return ApiResponse::error(__('faq.showed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Faq $faq)
    {
        try {
            $faq = $this->service->destroy($faq);

            return ApiResponse::deleted();
        } catch (\Exception $e) {
            Log::error(
                'Failed to delete common question',
                ['error' => $e->getMessage(), 'method' => __METHOD__]
            );

            return ApiResponse::error(__('faq.deleted_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreFaqRequest $request)
    {
        try {
            $faq = $this->service->store($request->validated());

            return ApiResponse::success(
                ['faq' => FaqResource::make($faq)],
                __('faq.created_successfully'),
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            Log::error(
                'Failed to store common question',
                [
                    'error' => $e->getMessage(),
                    'request' => $request->validated(),
                    'method' => __METHOD__,
                ]
            );

            return ApiResponse::error(__('faq.created_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Faq $faq, UpdateFaqRequest $request)
    {
        try {
            $faq = $this->service->update($faq, $request->validated());

            return ApiResponse::success(
                ['faq' => FaqResource::make($faq)],
                __('faq.updated_successfully'),
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            Log::error(
                'Failed to update common question',
                [
                    'error' => $e->getMessage(),
                    'request' => $request->validated(),
                    'method' => __METHOD__,
                ]
            );

            return ApiResponse::error(__('faq.updated_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
