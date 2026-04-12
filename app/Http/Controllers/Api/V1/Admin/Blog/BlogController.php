<?php

namespace App\Http\Controllers\Api\V1\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Blog\ListBlogsRequest;
use App\Http\Requests\Admin\Blog\StoreBlogRequest;
use App\Http\Requests\Admin\Blog\UpdateBlogRequest;
use App\Http\Resources\Admin\Blog\BlogResource;
use App\Models\Blog;
use App\Services\V1\Admin\Blog\BlogService;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Dedoc\Scramble\Attributes\Group;
#[Group('Admin Blog')]
class BlogController extends Controller
{
    use ApiResponse;

    public function __construct(public BlogService $service) {}

    public function index(ListBlogsRequest $request)
    {
        try {
            $blogs = $this->service->index($request->validated());
            $blogs = BlogResource::collection($blogs)->response()->getData(true);

            return ApiResponse::success([
                'blogs' => $blogs['data'],
                'meta' => $blogs['meta'],
                'links' => $blogs['links'],
            ], __('blog.listed_successfully'));

        } catch (\Exception $e) {
            Log::error('Failed to list blog', [
                'error' => $e->getMessage(),
                'request' => $request->validated(),
                'method' => __METHOD__,
            ]);

            return ApiResponse::error(__('blog.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    public function show(Blog $blog)
    {
        try {
            $blog = $this->service->show($blog);
            $blog = BlogResource::make($blog);

            return ApiResponse::success([
                'blog' => $blog,
            ], __('blog.showed_successfully'));
        } catch (\Exception $e) {
            Log::error('Failed to show blog', [
                'error' => $e->getMessage(),
                'blog' => $blog,
                'method' => __METHOD__,
            ]);

            return ApiResponse::error(__('blog.showed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreBlogRequest $request)
    {
        try {
            $blog = $this->service->store($request->validated());
            $blog = BlogResource::make($blog);

            return ApiResponse::success([
                'blog' => $blog,
            ], __('blog.stored_successfully'), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error('Failed to store blog', [
                'error' => $e->getMessage(),
                'request' => $request->validated(),
                'method' => __METHOD__,
            ]);

            return ApiResponse::error(__('blog.stored_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Blog $blog, UpdateBlogRequest $request)
    {
        try {
            $blog = $this->service->update($blog, $request->validated());
            $blog = BlogResource::make($blog);

            return ApiResponse::success([
                'blog' => $blog,
            ], __('blog.updated_successfully'));
        } catch (\Exception $e) {
            Log::error('Failed to update blog', [
                'error' => $e->getMessage(),
                'blog' => $blog,
                'request' => $request->validated(),
                'method' => __METHOD__,
            ]);

            return ApiResponse::error(__('blog.updated_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Blog $blog)
    {
        try {
            $this->service->destroy($blog);

            return ApiResponse::success([], __('blog.deleted_successfully'));
        } catch (\Exception $e) {
            Log::error('Failed to delete blog', [
                'error' => $e->getMessage(),
                'blog' => $blog,
                'method' => __METHOD__,
            ]);

            return ApiResponse::error(__('blog.deleted_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
