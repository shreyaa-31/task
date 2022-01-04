<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\BlogInterface;
use App\Repositories\BlogRepository;
use App\UserInterface\UserInterface;
use App\Repositories\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BlogInterface::class, BlogRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}