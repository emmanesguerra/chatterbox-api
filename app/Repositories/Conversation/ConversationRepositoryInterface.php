<?php 

namespace App\Repositories\Conversation;

use App\Models\Conversation;
use Illuminate\Database\Eloquent\Collection;

interface ConversationRepositoryInterface
{
    public function getConversations(): Collection;
    public function getMessages(int $id): Collection;
}
