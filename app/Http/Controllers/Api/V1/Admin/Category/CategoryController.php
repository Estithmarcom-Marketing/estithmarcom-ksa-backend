<?php

namespace App\Http\Controllers\Api\V1\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\ListCategoriesRequest;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Http\Resources\Admin\Category\CategoryResource;
use App\Models\Category;
use App\Services\V1\Admin\Category\CategoryService;
use App\Traits\ApiResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

#[Group('Admin Category')]
class CategoryController extends Controller
{
    public function __construct(protected CategoryService $service) {}
    public function index(ListCategoriesRequest $request)
    {
        try {
            $categories = $this->service->list($request->validated());
            $categories = CategoryResource::collection($categories)->response()->getData(true);
            return ApiResponse::success([
                'categories' => $categories['data'],
                'meta' => $categories['meta']
            ], __('category.listed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to list categories', [
                'error' => $th->getMessage(),
                'request' => $request->validated(),
                'method' => __METHOD__
            ]);
            return ApiResponse::error(__('category.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function listWithoutPagination()
    {
        try {
            $categories = $this->service->listWithoutPagination();
            $categories = CategoryResource::collection($categories);
            return ApiResponse::success([
                'categories' => $categories
            ], __('category.listed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to list unpaginated categories', [
                'error' => $th->getMessage(),
                'method' => __METHOD__
            ]);
            return ApiResponse::error(__('category.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function show(Category $category)
    {
        try {
            $category = $this->service->show($category);
            $category = CategoryResource::make($category);
            return ApiResponse::success([
                'category' => $category
            ], __('category.showed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to retrieve category', [
                'error' => $th->getMessage(),
                'category_id' => $category->id,
                'method' => __METHOD__
            ]);
            return ApiResponse::error(__('category.showed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            $category = $this->service->store($request->validated());
            $category = CategoryResource::make($category);
            return ApiResponse::success([
                'category' => $category
            ], __('category.stored_successfully'), Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::error('Failed to create category', [
                'error' => $th->getMessage(),
                'request' => $request->validated(),
                'method' => __METHOD__
            ]);
            return ApiResponse::error(__('category.stored_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            $category = $this->service->update($category, $request->validated());
            $category = CategoryResource::make($category);
            return ApiResponse::success([
                'category' => $category
            ], __('category.updated_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to update category', [
                'error' => $th->getMessage(),
                'category_id' => $category->id,
                'request' => $request->validated(),
                'method' => __METHOD__
            ]);
            return ApiResponse::error(__('category.updated_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function delete(Category $category)
    {
        try {
            $this->service->destroy($category);
            return ApiResponse::success([], __('category.deleted_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to delete category', [
                'error' => $th->getMessage(),
                'category_id' => $category->id,
                'method' => __METHOD__
            ]);
            return ApiResponse::error(__('category.deleted_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
