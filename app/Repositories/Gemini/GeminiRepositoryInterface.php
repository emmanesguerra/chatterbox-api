<?php

namespace App\Repositories\Gemini;

interface GeminiRepositoryInterface
{
    public function getResponse(string $message): array;
}
