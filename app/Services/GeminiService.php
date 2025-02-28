<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GeminiService
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

        $content = Str::markdown($data['candidates'][0]['content']['parts'][0]['text'] ?? 'No response');
        
        return [
            'message' => $content
        ];
    }

    public function getTitle(string $message): string
    {
        $command = "Give one conversation title out of this message \"$message\"";  

        $reponse = $this->getResponse($command);

        return $reponse['message'];
    }
}
