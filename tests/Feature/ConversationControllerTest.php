<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\ConversationService;
use Mockery;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Conversation;
use App\Models\Message;

class ConversationControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $conversationServiceMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->conversationServiceMock = Mockery::mock(ConversationService::class);
        $this->app->instance(ConversationService::class, $this->conversationServiceMock);
    }

    public function test_returns_a_list_of_conversations()
    {
        $conversations = Conversation::factory()->count(3)->create();

        $this->conversationServiceMock
            ->shouldReceive('getConversations')
            ->once()
            ->andReturn($conversations);

        $response = $this->getJson('/api/conversations');

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has(3)
            );
    }

    public function test_fetches_messages_for_a_given_conversation()
    {
        $conversation = Conversation::factory()->create();
        $messages = Message::factory()->count(3)->create([
            'conversation_id' => $conversation->id,
        ]);
    
        $this->conversationServiceMock
            ->shouldReceive('getMessages')
            ->once()
            ->with($conversation->id)
            ->andReturn($messages);
    
        $response = $this->getJson("/api/conversations/{$conversation->id}/messages");
    
        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['sender', 'text']
            ]);
    }
    
    

    public function test_creates_a_new_conversation()
    {
        $newConversation = Conversation::factory()->state([
            'id' => 3,
            'title' => 'New Chat'
        ])->create();

        $this->conversationServiceMock
            ->shouldReceive('createConversation')
            ->once()
            ->with('Hello, new chat')
            ->andReturn($newConversation);

        $response = $this->postJson('/api/conversations-create', [
            'message' => 'Hello, new chat'
        ]);

        $response->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('id', 3)
                    ->where('title', 'New Chat')
                    ->etc()
            );
    }

    public function test_fails_to_create_a_conversation_due_to_validation()
    {
        $response = $this->postJson('/api/conversations-create', [
            'message' => ''
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['message']);
    }

    public function test_deletes_a_conversation_successfully()
    {
        $this->conversationServiceMock
            ->shouldReceive('deleteConversation')
            ->once()
            ->with(1)
            ->andReturn(true);

        $response = $this->deleteJson('/api/conversations/1');

        $response->assertStatus(204);
    }

    public function test_fails_to_delete_a_nonexistent_conversation()
    {
        $this->conversationServiceMock
            ->shouldReceive('deleteConversation')
            ->once()
            ->with(99)
            ->andReturn(false);

        $response = $this->deleteJson('/api/conversations/99');

        $response->assertStatus(404)
            ->assertJson(['message' => 'Conversation not found.']);
    }
}
