<?php

namespace Tests\Unit;

use App\Models\Message;
use App\Repositories\Message\MessageRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessageRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected MessageRepository $messageRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->messageRepository = new MessageRepository(new Message());
    }

    public function test_can_create_message()
    {
        $data = [
            'conversation_id' => 1,
            'message' => 'Hello, this is a test message', 
            'sender' => 'user'
        ];

        $message = $this->messageRepository->create($data);

        $this->assertInstanceOf(Message::class, $message);
        $this->assertDatabaseHas('messages', ['message' => 'Hello, this is a test message']);
    }

    public function test_can_find_message_by_id()
    {
        $message = Message::factory()->create();

        $foundMessage = $this->messageRepository->findById($message->id);

        $this->assertNotNull($foundMessage);
        $this->assertEquals($message->id, $foundMessage->id);
    }

    public function test_can_delete_message()
    {
        $message = Message::factory()->create();

        $deleted = $this->messageRepository->delete($message->id);

        $this->assertTrue($deleted);
        $this->assertSoftDeleted('messages', ['id' => $message->id]);
    }

    public function test_can_restore_message()
    {
        $message = Message::factory()->create();
        $message->delete();

        $restored = $this->messageRepository->restore($message->id);

        $this->assertTrue($restored);
        $this->assertDatabaseHas('messages', ['id' => $message->id, 'deleted_at' => null]);
    }
}
