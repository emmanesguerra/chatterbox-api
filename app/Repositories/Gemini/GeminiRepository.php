<?php

namespace App\Repositories\Gemini;

use Illuminate\Support\Facades\Http;

class GeminiRepository implements GeminiRepositoryInterface
{
    protected $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
    }

    public function getResponse(string $message): array
    {
        $response = Http::post("{$this->baseUrl}?key={$this->apiKey}", [
            "contents" => [
                ["parts" => [["text" => $message]]]
            ]
        ]);

        $data = $response->json();
        
        return [
            'message' => $data['candidates'][0]['content']['parts'][0]['text'] ?? 'No response'
        ];
    }
}

