<?php 

namespace App\Repositories\Conversation;

use App\Models\Conversation;

interface ConversationRepositoryInterface
{
    public function create(array $data): Conversation;
    public function delete(int $id): bool;
    public function restore(int $id): bool;
}
