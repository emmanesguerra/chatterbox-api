<?php 

namespace App\Services;

use App\Repositories\Conversation\ConversationRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\Conversation;

class ConversationService
{
    protected $conversationRepository;

    public function __construct(ConversationRepository $conversationRepository)
    {
        $this->conversationRepository = $conversationRepository;
    }

    public function createConversation(string $title): Conversation
    {
        return $this->conversationRepository->create([
            'title' => $title
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
}
