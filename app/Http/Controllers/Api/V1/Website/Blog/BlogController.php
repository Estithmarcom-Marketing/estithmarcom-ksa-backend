<?php

namespace App\Http\Controllers\Api\V1\Website\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Blog\ListBlogsRequest;
use App\Http\Resources\Website\Blog\BlogResource;
use App\Http\Resources\Website\Blog\BlogSiteMapResource;
use App\Services\V1\Website\Blog\BlogService;
use App\Traits\ApiResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

#[Group('Website Blog')]
class BlogController extends Controller
{
    use ApiResponse;
    public function __construct(public BlogService $service) {}
    /**
     * @unauthenticated
     */
    public function index(ListBlogsRequest $request)
    {
        try {
            $blogs = $this->service->list($request->validated());
            $blogs = BlogResource::collection($blogs)->response()->getData(true);
            return ApiResponse::success([
                'blogs' => $blogs['data'],
                'meta' => $blogs['meta'],
                'links' => $blogs['links'],
            ], __('blog.listed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to list blog', ['error' => $th->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);
            return ApiResponse::error(__('blog.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @unauthenticated
     */
    public function show($identifier)
    {
        try {
            $blog = $this->service->show($identifier);
            $blog = BlogResource::make($blog);
            return ApiResponse::success([
                'blog' => $blog,
            ], __('blog.showed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to show blog', ['error' => $th->getMessage(), 'blog_identifier' => $identifier, 'method' => __METHOD__]);
            return ApiResponse::error(__('blog.showed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @unauthenticated
     */
    public function getAllForSiteMap()
    {
        try {
            $blogs = $this->service->getAllForSiteMap();
            $blogs = BlogSiteMapResource::collection($blogs);
            return ApiResponse::success([
                'blogs' => $blogs
            ], __('blog.listed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to list blog for site map', ['error' => $th->getMessage(), 'method' => __METHOD__]);
            return ApiResponse::error(__('blog.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
