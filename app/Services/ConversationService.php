<?php 

namespace App\Services;

use App\Repositories\Conversation\ConversationRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\Conversation;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;

class ConversationService
{
    protected $conversationRepository;
    protected $geminiService;

    public function __construct(ConversationRepository $conversationRepository, GeminiService $geminiService)
    {
        $this->conversationRepository = $conversationRepository;
        $this->geminiService = $geminiService;
    }

    public function getConversations(): Collection
    {
        return $this->conversationRepository->getConversations();
    }

    public function createConversation(string $title): Conversation
    {
        $cleanText = preg_replace('/[\r\n\t]+/', ' ', html_entity_decode(strip_tags($this->geminiService->getTitle($title))));

        return $this->conversationRepository->create([
            'title' => $cleanText
        ]);
    }

    public function deleteConversation(int $conversationId): bool
    {
        return $this->conversationRepository->delete($conversationId);
    }

    public function restoreConversation(int $conversationId): bool
    {
        return $this->conversationRepository->restore($conversationId);
    }

    public function getMessages(int $conversationId): Collection
    {
        return $this->conversationRepository->getMessages($conversationId);
    }
}
