<?php

namespace App\Http\Controllers\Api\V1\Website\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\Website\Category\CategoryResource;
use App\Services\V1\Website\Category\CategoryService;
use App\Traits\ApiResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

#[Group('Website Category')]
class CategoryController extends Controller
{
    public function __construct(public CategoryService $service) {}
    /**
     * @unauthenticated
     */
    public function listWithoutPagination()
    {
        try {
            $categories = $this->service->listWithoutPagination();
            $categories = CategoryResource::collection($categories);
            return ApiResponse::success([
                'categories' => $categories
            ], __('category.listed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to list unpaginated categories', ['error' => $th->getMessage(), 'method' => __METHOD__]);
            return ApiResponse::error(__('category.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
