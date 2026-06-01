<?php

namespace App\Http\Controllers\Api\V1\Website\Highlight;

use App\Http\Controllers\Controller;
use App\Http\Resources\Website\Highlight\HighlightResource;
use App\Services\V1\Website\Highlight\HighlightService;
use App\Traits\ApiResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

#[Group('Website Highlight')]
class HighlightController extends Controller
{
    public function __construct(public HighlightService $service) {}
    /**
     * @unauthenticated
     */
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
}
