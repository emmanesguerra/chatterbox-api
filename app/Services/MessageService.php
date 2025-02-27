<?php 

namespace App\Services;

use App\Repositories\Message\MessageRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

class MessageService
{
    protected $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function createMessage(array $data): Message
    {
        return $this->messageRepository->create([
            'conversation_id' => $data['conversation_id'],
            'sender' => $data['sender'],
            'message' => $data['message']
        ]);
    }

    public function deleteMessage(int $messageId): bool
    {
        return $this->messageRepository->delete($messageId);
    }

    public function restoreMessage(int $messageId): bool
    {
        return $this->messageRepository->restore($messageId);
    }
}
