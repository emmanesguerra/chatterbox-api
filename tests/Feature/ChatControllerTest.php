<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\GeminiService;
use Mockery;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class ChatControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $chatServiceMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->geminiServiceMock = Mockery::mock(GeminiService::class);
        $this->app->instance(GeminiService::class, $this->geminiServiceMock);
    }

    public function test_chat_endpoint_returns_json_response()
    {
        $this->geminiServiceMock
            ->shouldReceive('getResponse')
            ->once()
            ->with('Hello mate')
            ->andReturn([
                'message' => 'Hello, how can I help?',
                'success' => true,
            ]);

        $response = $this->postJson('/api/send-message', [
            'message' => 'Hello mate',
            'conversation_id' => 1,
        ]);

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('message')
                     ->has('success')
            );
    }

    public function test_chat_endpoint_returns_error_due_to_empty_message()
    {
        $response = $this->postJson('/api/send-message', [
            'message' => '',
            'conversation_id' => 1,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['message']);
    }

    public function test_chat_endpoint_returns_error_due_to_incorect_field()
    {
        $response = $this->postJson('/api/send-message', [
            'messages' => 'Hi how are you?',
            'conversation_id' => 1,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['message']);
    }
}
