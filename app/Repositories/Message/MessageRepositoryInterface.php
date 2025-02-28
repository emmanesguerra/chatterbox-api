<?php 

namespace App\Repositories\Message;

use App\Models\Message;

interface MessageRepositoryInterface
{
    public function create(array $data): Message;
    public function delete(int $id): bool;
    public function restore(int $id): bool;
}
