<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\AuthRepositryInterface;
use App\Repositries\AuthRepositry;
use App\Interfaces\UserRepositryInterface;
use App\Repositries\UserRepositry;
class RepositryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AuthRepositryInterface::class, AuthRepositry::class);
        $this->app->bind(UserRepositryInterface::class, UserRepositry::class);
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
