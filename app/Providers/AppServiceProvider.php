<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Chat\ChatRepositoryInterface;
use App\Repositories\Chat\ChatRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ChatRepositoryInterface::class, ChatRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
