<?php

namespace App\Repositories\Chat;

interface ChatRepositoryInterface
{
    public function getResponse(string $message): array;
}
