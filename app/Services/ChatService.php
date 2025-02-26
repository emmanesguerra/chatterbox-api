<?php

namespace App\Services;

use App\Repositories\Chat\ChatRepositoryInterface;

class ChatService
{
    protected $chatRepository;

    public function __construct(ChatRepositoryInterface $chatRepository)
    {
        $this->chatRepository = $chatRepository;
    }

    public function chat(string $message): array
    {
        return $this->chatRepository->getResponse($message);
    }
}
