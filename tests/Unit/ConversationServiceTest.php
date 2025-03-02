<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use App\Services\ConversationService;
use App\Repositories\Conversation\ConversationRepository;
use App\Services\GeminiService;
use App\Models\Conversation;
use Illuminate\Database\Eloquent\Collection;

class ConversationServiceTest extends TestCase
{
    protected $conversationRepositoryMock;
    protected $geminiServiceMock;
    protected $conversationService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->conversationRepositoryMock = Mockery::mock(ConversationRepository::class);
        $this->geminiServiceMock = Mockery::mock(GeminiService::class);

        $this->app->instance(ConversationRepository::class, $this->conversationRepositoryMock);
        $this->app->instance(GeminiService::class, $this->geminiServiceMock);

        $this->conversationService = new ConversationService(
            $this->conversationRepositoryMock,
            $this->geminiServiceMock
        );
    }

    public function testGetConversations()
    {
        $conversations = new Collection([
            new Conversation(['id' => 1, 'title' => 'Test Conversation']),
            new Conversation(['id' => 2, 'title' => 'Another Conversation'])
        ]);

        $this->conversationRepositoryMock
            ->shouldReceive('getConversations')
            ->once()
            ->andReturn($conversations);

        $result = $this->conversationService->getConversations();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);
    }

    public function testCreateConversation()
    {
        $this->geminiServiceMock
            ->shouldReceive('getTitle')
            ->once()
            ->with('Hello World')
            ->andReturn('Hello World');

        $conversation = new Conversation(['id' => 1, 'title' => 'Hello World']);

        $this->conversationRepositoryMock
            ->shouldReceive('create')
            ->once()
            ->with(['title' => 'Hello World'])
            ->andReturn($conversation);

        $result = $this->conversationService->createConversation('Hello World');

        $this->assertInstanceOf(Conversation::class, $result);
        $this->assertEquals('Hello World', $result->title);
    }

    public function testDeleteConversation()
    {
        $this->conversationRepositoryMock
            ->shouldReceive('delete')
            ->once()
            ->with(1)
            ->andReturn(true);

        $result = $this->conversationService->deleteConversation(1);

        $this->assertTrue($result);
    }

    public function testRestoreConversation()
    {
        $this->conversationRepositoryMock
            ->shouldReceive('restore')
            ->once()
            ->with(1)
            ->andReturn(true);

        $result = $this->conversationService->restoreConversation(1);

        $this->assertTrue($result);
    }

    public function testGetMessages()
    {
        $messages = new Collection([
            ['id' => 1, 'text' => 'Hello'],
            ['id' => 2, 'text' => 'World'],
            ['id' => 3, 'text' => 'World']
        ]);

        $this->conversationRepositoryMock
            ->shouldReceive('getMessages')
            ->once()
            ->with(1)
            ->andReturn($messages);

        $result = $this->conversationService->getMessages(1);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(3, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
