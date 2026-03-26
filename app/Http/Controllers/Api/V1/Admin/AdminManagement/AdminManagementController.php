<?php

namespace App\Http\Controllers\Api\V1\Admin\AdminManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminManagement\ListAdminsRequest;
use App\Http\Requests\Admin\AdminManagement\StoreAdminRequest;
use App\Http\Requests\Admin\AdminManagement\UpdateAdminRequest;
use App\Http\Resources\Admin\User\UserResource;
use App\Models\User;
use App\Services\V1\Admin\AdminManagement\AdminManagementService;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AdminManagementController extends Controller
{
    use ApiResponse;

    public function __construct(protected AdminManagementService $service) {}

    public function index(ListAdminsRequest $request)
    {
        try {
            $admins = $this->service->index($request->validated());
            $admins = UserResource::collection($admins)->response()->getData(true);

            return ApiResponse::success([
                'admins' => $admins['data'],
                'meta' => $admins['meta'],
                'links' => $admins['links'],
            ],
                __('admin.listed_successfully'),
                Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Failed to list admins',
                ['error' => $e->getMessage(),
                    'request' => $request->validated(),
                    'method' => __METHOD__]);

            return ApiResponse::error(__('admin.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreAdminRequest $request)
    {
        try {
            $admin = $this->service->store($request->validated());

            return ApiResponse::success([
                'admin' => UserResource::make($admin),
            ],
                __('admin.stored_successfully'),
                Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error('Failed to create admin',
                ['error' => $e->getMessage(),
                    'request' => $request->validated(),
                    'method' => __METHOD__]);

            return ApiResponse::error(__('admin.stored_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(User $admin)
    {
        try {
            $admin = $this->service->destroy($admin);

            return ApiResponse::deleted();
        } catch (\LogicException $e) {
            Log::error('Failed to delete admin',
                ['error' => $e->getMessage(),
                    'admin' => $admin,
                    'method' => __METHOD__]);

            return ApiResponse::error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            Log::error('Failed to delete admin',
                ['error' => $e->getMessage(),
                    'admin' => $admin,
                    'method' => __METHOD__]);

            return ApiResponse::error(__('admin.deleted_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAuthenticatedUser()
    {
        try {
            $admin = $this->service->getAuthenticatedUser();

            return ApiResponse::success([
                'admin' => UserResource::make($admin),
            ],
                __('admin.showed_successfully'),
                Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Failed to list admins',
                ['error' => $e->getMessage(),
                    'method' => __METHOD__]);

            return ApiResponse::error(__('admin.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateProfile(UpdateAdminRequest $request)
    {
        try {
            $admin = $this->service->updateProfile($request->validated());
            $admin = UserResource::make($admin);

            return ApiResponse::success(['admin' => $admin],
                __('admin.updated_successfully'),
                Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Failed to update admin profile',
                ['error' => $e->getMessage(),
                    'request' => $request->validated(),
                    'method' => __METHOD__]);

            return ApiResponse::error(__('admin.updated_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateAdminRequest $request, User $admin)
    {
        try {
            $admin = $this->service->update($admin, $request->validated());
            $admin = UserResource::make($admin);

            return ApiResponse::success(['admin' => $admin],
                __('admin.updated_successfully'),
                Response::HTTP_OK);
        } catch (\LogicException $e) {
            Log::error('Failed to update admin',
                ['error' => $e->getMessage(),
                    'request' => $request->validated(),
                    'admin' => $admin,
                    'method' => __METHOD__]);

            return ApiResponse::error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            Log::error('Failed to update admin',
                ['error' => $e->getMessage(),
                    'request' => $request->validated(),
                    'method' => __METHOD__]);

            return ApiResponse::error(__('admin.updated_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
