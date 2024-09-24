<?php

namespace App\Providers;

use App\Repositories\Interfaces\IPostRepository;
use App\Repositories\PostRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(IPostRepository::class, PostRepository::class);
    }
}
