<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\RequestException;
use RuntimeException;

class GeminiService
{
    private string $baseUrl;
    private string $apiKey;

    public function __construct()
    {
        $this->baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';
        $this->apiKey = config('services.gemini.api_key');

        if (empty($this->apiKey)) {
            throw new RuntimeException('Gemini API key is not configured.');
        }
    }

    public function getResponse(string $message): array
    {
        try {
            $response = $this->sendRequest(['contents' => [['parts' => [['text' => $message]]]]]);

            return [
                'message' => $this->extractMessage($response),
                'success' => true
            ];

        } catch (RequestException $e) {
            throw $e;
        }
    }

    public function getTitle(string $message): string
    {
        $command = "Generate one title out of this message \"$message\", title should be less than 5 words";

        return $this->getResponse($command)['message'];
    }

    private function sendRequest(array $payload): Response
    {
        $response = Http::post("{$this->baseUrl}?key={$this->apiKey}", $payload)->throw();

        return $response;
    }

    private function extractMessage(Response $response): string
    {
        $data = $response->json();
        return Str::markdown($data['candidates'][0]['content']['parts'][0]['text'] ?? 'No response');
    }
}
