<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\GeminiService;
use App\Repositories\Gemini\GeminiRepositoryInterface;
use Mockery;

class ChatServiceTest extends TestCase
{
    protected $geminiService;
    protected $geminiRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->geminiRepositoryMock = Mockery::mock(GeminiRepositoryInterface::class);
        $this->geminiService = new GeminiService($this->geminiRepositoryMock);
    }

    public function test_generate_response_calls_repository()
    {
        $this->geminiRepositoryMock
            ->shouldReceive('getResponse')
            ->once()
            ->with('What is the weather like today?')
            ->andReturn(['message' => 'Its sunny today']);

        $response = $this->geminiService->getResponse('What is the weather like today?');

        $this->assertIsArray($response);
    }
}
