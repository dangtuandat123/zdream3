<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BflService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.bfl.ai';

    public function __construct()
    {
        $this->apiKey = config('services.bfl.key');
    }

    public function createTask(string $endpoint, array $payload)
    {
        $response = Http::withHeaders([
            'x-key' => $this->apiKey,
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
        ])->post($this->baseUrl . $endpoint, $payload);

        if ($response->failed()) {
            Log::error('BFL Create Task Failed', [
                'endpoint' => $endpoint,
                'payload' => $payload,
                'response' => $response->body(),
                'status' => $response->status(),
            ]);
            throw new \Exception('BFL API Error: ' . $response->body());
        }

        return $response->json();
    }

    public function pollTask(string $pollingUrl)
    {
        $response = Http::withHeaders([
            'x-key' => $this->apiKey,
            'accept' => 'application/json',
        ])->get($pollingUrl);

        if ($response->failed()) {
            Log::error('BFL Poll Task Failed', [
                'url' => $pollingUrl,
                'response' => $response->body(),
            ]);
            return ['status' => 'Error', 'error' => $response->body()];
        }

        return $response->json();
    }

    public function downloadResult(string $url)
    {
        $response = Http::get($url);
        if ($response->failed()) {
            throw new \Exception('Failed to download image from BFL');
        }
        return $response->body();
    }
}
