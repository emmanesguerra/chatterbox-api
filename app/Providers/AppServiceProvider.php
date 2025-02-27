<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Gemini\GeminiRepositoryInterface;
use App\Repositories\Gemini\GeminiRepository;
use App\Repositories\Conversation\ConversationRepositoryInterface;
use App\Repositories\Conversation\ConversationRepository;
use App\Repositories\Message\MessageRepositoryInterface;
use App\Repositories\Message\MessageRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(GeminiRepositoryInterface::class, GeminiRepository::class);
        $this->app->bind(ConversationRepositoryInterface::class, ConversationRepository::class);
        $this->app->bind(MessageRepositoryInterface::class, MessageRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
