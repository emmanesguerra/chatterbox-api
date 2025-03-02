<?php

namespace Tests\Unit\Services;

use App\Services\MessageService;
use App\Repositories\Message\MessageRepository;
use App\Models\Message;
use Mockery;
use Tests\TestCase;

class MessageServiceTest extends TestCase
{
    protected $messageService;
    protected $messageRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->messageRepositoryMock = Mockery::mock(MessageRepository::class);
        $this->messageService = new MessageService($this->messageRepositoryMock);
    }

    public function test_create_message()
    {
        $messageData = [
            'conversation_id' => 1,
            'user_id' => 1,
            'content' => 'Hello, world!',
        ];

        $mockMessage = Mockery::mock(Message::class);

        $this->messageRepositoryMock
            ->shouldReceive('create')
            ->once()
            ->with($messageData)
            ->andReturn($mockMessage);

        $result = $this->messageService->createMessage($messageData);
        $this->assertInstanceOf(Message::class, $result);
    }

    public function test_delete_message()
    {
        $messageId = 1;

        $this->messageRepositoryMock
            ->shouldReceive('delete')
            ->once()
            ->with($messageId)
            ->andReturn(true);

        $result = $this->messageService->deleteMessage($messageId);
        $this->assertTrue($result);
    }

    public function test_restore_message()
    {
        $messageId = 1;

        $this->messageRepositoryMock
            ->shouldReceive('restore')
            ->once()
            ->with($messageId)
            ->andReturn(true);

        $result = $this->messageService->restoreMessage($messageId);
        $this->assertTrue($result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
