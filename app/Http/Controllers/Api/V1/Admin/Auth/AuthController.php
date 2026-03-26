<?php

namespace App\Http\Controllers\Api\V1\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Http\Resources\Admin\User\UserResource;
use App\Services\V1\Admin\Auth\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    use ApiResponse;

    public function __construct(public AuthService $service) {}

    /**
     * @unauthenticated
     */
    public function login(LoginRequest $request)
    {
        try {
            $data = $this->service->login($request->validated());

            return ApiResponse::success([
                'user' => UserResource::make($data['user']),
                'token' => $data['token'],
            ], __('admin.logged_in_successfully'));
        } catch (\LogicException $e) {
            Log::error('Admin Failed to login', ['error' => $e->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);

            return ApiResponse::error($e->getMessage(), Response::HTTP_UNAUTHORIZED);
        } catch (\Exception $e) {
            Log::error('Admin Failed to login', ['error' => $e->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);

            return ApiResponse::error(__('admin.logged_in_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function logout()
    {
        try {
            $this->service->logout();

            return ApiResponse::success(null, __('admin.logged_out_successfully'));
        } catch (\Exception $e) {
            Log::error('Admin Failed to logout', ['error' => $e->getMessage(), 'method' => __METHOD__]);

            return ApiResponse::error(__('admin.logged_out_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
