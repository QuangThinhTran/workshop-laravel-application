<?php

namespace App\Providers;

use App\Repositories\Interfaces\IPostRepository;
use App\Repositories\PostRepository;
use App\Services\IWebhookService;
use App\Services\WebhookService;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IPostRepository::class, PostRepository::class);
        $this->app->bind(IWebhookService::class, WebhookService::class);
    }
}
