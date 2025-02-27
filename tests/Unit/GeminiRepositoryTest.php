<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Repositories\Gemini\GeminiRepository;
use Illuminate\Support\Facades\Http;

class GeminiRepositoryTest extends TestCase
{
    protected $geminiRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->geminiRepository = new GeminiRepository();
    }

    public function test_get_chat_response_returns_mocked_api_response()
    {
        Http::fake([
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent*' => 
                Http::response(['candidates' => [['content' => ['parts' => [['text' => 'Hello, how can I help?']]]]]], 200)
        ]);

        $response = $this->geminiRepository->getResponse('Hello');

        $this->assertIsArray($response);
        $this->assertArrayHasKey('message', $response);
        $this->assertIsString($response['message']);
    }
}
