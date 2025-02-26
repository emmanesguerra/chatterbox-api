<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\ChatService;
use Mockery;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChatControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $chatServiceMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->chatServiceMock = Mockery::mock(ChatService::class);
        $this->app->instance(ChatService::class, $this->chatServiceMock);
    }

    public function test_chat_endpoint_returns_json_response()
    {
        $this->chatServiceMock
            ->shouldReceive('chat')
            ->once()
            ->with('Hello mate')
            ->andReturn(['message' => 'Hello, how can I help?']);

        $response = $this->postJson('/api/chat', ['message' => 'Hello mate']);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Hello, how can I help?'
        ]);
    }

    public function test_chat_endpoint_returns_error_due_to_empty_message()
    {
        $response = $this->postJson('/api/chat', ['message' => '']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['message']);
    }

    public function test_chat_endpoint_returns_error_due_to_incorect_field()
    {
        $response = $this->postJson('/api/chat', ['messages' => 'Hi how are you?']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['message']);
    }
}
