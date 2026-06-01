<?php

namespace App\Http\Controllers\Api\V1\Admin\Highlight;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Highlight\UpdateHighlightRequest;
use App\Http\Resources\Admin\Highlight\HighlightResource;
use App\Models\Highlight;
use App\Services\V1\Admin\Highlight\HighlightService;
use App\Traits\ApiResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

#[Group('Admin Highlight')]
class HighlightController extends Controller
{
    public function __construct(public HighlightService $service) {}

    public function index()
    {
        try {
            $highlights = $this->service->list();
            $highlights = HighlightResource::collection($highlights);

            return ApiResponse::success([
                'highlights' => $highlights,
            ], __('highlight.listed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to list highlights', [
                'error' => $th->getMessage(),
                'method' => __METHOD__,
            ]);

            return ApiResponse::error(__('highlight.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Highlight $highlight)
    {
        try {
            $highlight = $this->service->show($highlight);
            $highlight = HighlightResource::make($highlight);

            return ApiResponse::success([
                'highlight' => $highlight,
            ], __('highlight.showed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to retrieve highlight', [
                'highlight_id' => $highlight->id,
                'error' => $th->getMessage(),
                'method' => __METHOD__,
            ]);

            return ApiResponse::error(__('highlight.showed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Highlight $highlight, UpdateHighlightRequest $request)
    {
        try {
            $highlight = $this->service->update($highlight, $request->validated());
            $highlight = HighlightResource::make($highlight);

            return ApiResponse::success([
                'highlight' => $highlight,
            ], __('highlight.updated_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to update highlight', [
                'error' => $th->getMessage(),
                'highlight_id' => $highlight->id,
                'request' => $request->validated(),
                'method' => __METHOD__,
            ]);

            return ApiResponse::error(__('highlight.updated_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
