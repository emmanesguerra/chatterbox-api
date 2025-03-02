<?php

namespace Tests\Unit;

use App\Models\Conversation;
use App\Models\Message;
use App\Repositories\Conversation\ConversationRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConversationRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected ConversationRepository $conversationRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->conversationRepository = new ConversationRepository(new Conversation());
    }

    public function test_can_get_all_conversations()
    {
        Conversation::factory()->count(3)->create();

        $conversations = $this->conversationRepository->getConversations();

        $this->assertCount(3, $conversations);
    }

    public function test_can_get_messages_for_conversation()
    {
        $conversation = Conversation::factory()->create();
        $message = Message::factory()->create(['conversation_id' => $conversation->id]);

        $messages = $this->conversationRepository->getMessages($conversation->id);

        $this->assertCount(1, $messages);
        $this->assertEquals($message->id, $messages->first()->id);
    }
}
