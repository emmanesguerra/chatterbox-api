<?php

namespace Tests\Unit\Services;

use App\Services\GeminiService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tests\TestCase;

class GeminiServiceTest extends TestCase
{
    protected GeminiService $geminiService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->geminiService = new GeminiService();
    }

    public function test_get_chat_response_returns_mocked_api_response()
    {
        Http::fake([
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent*' => 
                Http::response(['candidates' => [['content' => ['parts' => [['text' => 'Hello, how can I help?']]]]]], 200)
        ]);

        $response = $this->geminiService->getResponse('Hello');

        $this->assertIsArray($response);
        $this->assertArrayHasKey('message', $response);
        $this->assertIsString($response['message']);
    }

    
    public function test_generate_title_via_gemini()
    {
        Http::fake([
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent*' => 
                Http::response(['candidates' => [['content' => ['parts' => [['text' => 'Sample title']]]]]], 200)
        ]);

        $response = $this->geminiService->getTitle('Sample title');

        $this->assertIsString($response);
    }
}