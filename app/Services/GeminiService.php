<?php

namespace App\Services;

use App\Repositories\Gemini\GeminiRepositoryInterface;

class GeminiService
{
    protected $geminiRepository;

    public function __construct(GeminiRepositoryInterface $geminiRepository)
    {
        $this->geminiRepository = $geminiRepository;
    }

    public function getResponse(string $message): array
    {
        return $this->geminiRepository->getResponse($message);
    }
}
