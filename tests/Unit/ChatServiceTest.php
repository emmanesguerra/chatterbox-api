<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\ChatService;
use App\Repositories\Chat\ChatRepositoryInterface;
use Mockery;

class ChatServiceTest extends TestCase
{
    protected $chatService;
    protected $chatRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->chatRepositoryMock = Mockery::mock(ChatRepositoryInterface::class);
        $this->chatService = new ChatService($this->chatRepositoryMock);
    }

    public function test_generate_response_calls_repository()
    {
        $this->chatRepositoryMock
            ->shouldReceive('getResponse')
            ->once()
            ->with('What is the weather like today?')
            ->andReturn(['message' => 'Its sunny today']);

        $response = $this->chatService->chat('What is the weather like today?');

        $this->assertIsArray($response);
    }
}
