<?php

namespace App\Services\V1\SMS;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TqnyatSmsService
{
    public function send(array $phoneNumbers, string $message)
    {

        $response = Http::withToken(config('services.tqnyat.api_token'))
            ->withHeaders(['Content-Type' => 'application/json'])
            ->retry(3, 100)
            ->timeout(10)
            ->post(config('services.tqnyat.api_url'), [
                'recipients' => [$phoneNumbers],
                'body' => $message,
                'sender' => config('services.tqnyat.sender'),
            ])
            ->throw()
            ->json();
        Log::info('Tqnyat SMS response', $response);

        return $response;
    }
}
