<?php 

namespace App\Repositories\Message;

use App\Models\Message;

class MessageRepository  implements MessageRepositoryInterface
{
    public function create(array $data): Message
    {
        return Message::create($data);
    }

    public function delete(int $id): bool
    {
        $message = $this->findById($id);
        return $message ? $message->delete() : false;
    }

    public function restore(int $id): bool
    {
        $message = $this->findByIdWithTrashed($id);
        return $message ? $message->restore() : false;
    }
}
