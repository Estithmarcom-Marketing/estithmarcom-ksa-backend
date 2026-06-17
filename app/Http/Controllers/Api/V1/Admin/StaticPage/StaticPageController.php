<?php

namespace App\Http\Controllers\Api\V1\Admin\StaticPage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StaticPage\StoreStaticPageRequest;
use App\Http\Requests\Admin\StaticPage\UpdateStaticPageRequest;
use App\Http\Resources\Admin\StaticPage\StaticPageResource;
use App\Models\StaticPage;
use App\Services\V1\Admin\StaticPage\StaticPageService;
use App\Traits\ApiResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

#[Group('Admin Static Page')]
class StaticPageController extends Controller
{
    public function __construct(protected StaticPageService $service) {}
    public function index()
    {
        try {
            $pages = $this->service->list();
            $pages = StaticPageResource::collection($pages)->response()->getData(true);
            return ApiResponse::success([
                'pages' => $pages['data'],
                'meta' => $pages['meta'],
                'links' => $pages['links']
            ], __('static_page.listed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to list static pages', ['error' => $th->getMessage(), 'method' => __METHOD__]);
            return ApiResponse::error(__('static_page.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function show(StaticPage $staticPage)
    {
        try {
            $page = $this->service->show($staticPage);
            $page = StaticPageResource::make($page);
            return ApiResponse::success([
                'page' => $page
            ], __('static_page.showed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to show the static page', ['error' => $th->getMessage(), 'method' => __METHOD__]);
            return ApiResponse::error(__('static_page.showed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function store(StoreStaticPageRequest $request)
    {
        try {
            $page = $this->service->store($request->validated());
            $page = StaticPageResource::make($page);
            return ApiResponse::success([
                'page' => $page
            ], __('static_page.stored_successfully'), Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::error('Failed to store static page', [
                'error' => $th->getMessage(),
                'request' => $request->validated(),
                'method' => __METHOD__
            ]);
            return ApiResponse::error(__('static_page.stored_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function update(UpdateStaticPageRequest $request, StaticPage $staticPage)
    {
        try {
            $page = $this->service->update($staticPage, $request->validated());
            $page = StaticPageResource::make($page);
            return ApiResponse::success([
                'page' => $page
            ], __('static_page.updated_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to update static page', [
                'error' => $th->getMessage(),
                'static_page_id' => $staticPage->id,
                'request' => $request->validated(),
                'method' => __METHOD__
            ]);
            return ApiResponse::error(__('static_page.updated_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function delete(StaticPage $staticPage)
    {
        try {
            $this->service->destroy($staticPage);
            return ApiResponse::success([], __('static_page.deleted_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to delete static page', [
                'error' => $th->getMessage(),
                'static_page_id' => $staticPage->id,
                'method' => __METHOD__
            ]);
            return ApiResponse::error(__('static_page.deleted_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
