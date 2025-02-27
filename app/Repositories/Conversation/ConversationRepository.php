<?php 

namespace App\Repositories\Conversation;

use App\Models\Conversation;

class ConversationRepository  implements ConversationRepositoryInterface
{
    public function create(array $data): Conversation
    {
        return Conversation::create($data);
    }

    public function delete(int $id): bool
    {
        $conversation = $this->findById($id);
        return $conversation ? $conversation->delete() : false;
    }

    public function restore(int $id): bool
    {
        $conversation = $this->findByIdWithTrashed($id);
        return $conversation ? $conversation->restore() : false;
    }
}
