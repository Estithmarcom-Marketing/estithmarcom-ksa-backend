<?php

namespace App\Http\Controllers\Api\V1\Website\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Client\ListClientsRequest;
use App\Http\Resources\Website\Client\ClientResource;
use App\Services\V1\Website\Client\ClientService;
use App\Traits\ApiResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

#[Group('Website client')]
class ClientController extends Controller
{
    use ApiResponse;
    public function __construct(public ClientService $service) {}
    /**
     * @unauthenticated
     */
    public function __invoke(ListClientsRequest $request)
    {
        try {
            $clients = $this->service->list($request->validated());
            $clients = ClientResource::collection($clients)->response()->getData(true);
            return ApiResponse::success([
                'clients' => $clients['data'],
                'meta' => $clients['meta'],
                'links' => $clients['links']
            ], __('client.listed_successfully'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Failed to list clients', ['error' => $th->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);
            return ApiResponse::error(__('client.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
