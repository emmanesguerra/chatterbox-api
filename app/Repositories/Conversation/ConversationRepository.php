<?php 

namespace App\Repositories\Conversation;

use App\Models\Conversation;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class ConversationRepository extends BaseRepository implements ConversationRepositoryInterface
{
    public function __construct(Conversation $model)
    {
        parent::__construct($model);
    }

    public function getConversations(): Collection
    {
        return $this->model->all();
    }

    public function getMessages(int $id): Collection
    {
        $conversation = $this->findById($id);
        return $conversation ? $conversation->messages : new Collection();
    }
}
