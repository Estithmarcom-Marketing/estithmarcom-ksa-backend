<?php

namespace App\Http\Controllers\Api\V1\Admin\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Client\ListClientsRequest;
use App\Http\Requests\Admin\Client\StoreClientRequest;
use App\Http\Requests\Admin\Client\UpdateClientRequest;
use App\Http\Resources\Admin\Client\ClientResource;
use App\Models\Client;
use App\Services\V1\Admin\Client\ClientService;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Dedoc\Scramble\Attributes\Group;
#[Group('Admin Client')]
class ClientController extends Controller
{
    use ApiResponse;

    public function __construct(public ClientService $service) {}

    public function index(ListClientsRequest $request)
    {
        try {
            $clients = $this->service->list($request->validated());
            $clients = ClientResource::collection($clients)->response()->getData(true);

            return ApiResponse::success([
                'clients' => $clients['data'],
                'meta' => $clients['meta'],
                'links' => $clients['links'],
            ], __('client.listed_successfully'));
        } catch (\Exception $e) {

            Log::error('Failed to list clients', ['error' => $e->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);

            return ApiResponse::error(__('client.listed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Client $client)
    {
        try {
            $client = $this->service->show($client);
            $client = ClientResource::make($client);

            return ApiResponse::success(['client' => $client], __('client.showed_successfully'));
        } catch (\Exception $e) {
            Log::error('Failed to show client', ['error' => $e->getMessage(), 'client' => $client, 'method' => __METHOD__]);

            return ApiResponse::error(__('client.showed_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreClientRequest $request)
    {
        try {
            $client = $this->service->store($request->validated());
            $client = ClientResource::make($client);

            return ApiResponse::success(['client' => $client], __('client.stored_successfully'));
        } catch (\Exception $e) {
            Log::error('Failed to store client', ['error' => $e->getMessage(), 'request' => $request->validated(), 'method' => __METHOD__]);

            return ApiResponse::error(__('client.stored_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Client $client, UpdateClientRequest $request)
    {
        try {
            $client = $this->service->update($client, $request->validated());
            $client = ClientResource::make($client);

            return ApiResponse::success(['client' => $client], __('client.updated_successfully'));
        } catch (\Exception $e) {
            Log::error('Failed to update client', ['error' => $e->getMessage(), 'client' => $client, 'request' => $request->validated(), 'method' => __METHOD__]);

            return ApiResponse::error(__('client.updated_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Client $client)
    {
        try {
            $client = $this->service->destroy($client);

            return ApiResponse::deleted();
        } catch (\Exception $e) {
            Log::error('Failed to delete client', ['error' => $e->getMessage(), 'client' => $client, 'method' => __METHOD__]);
            return ApiResponse::error(__('client.deleted_failed'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
