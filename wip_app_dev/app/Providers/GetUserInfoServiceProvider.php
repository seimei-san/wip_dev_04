<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GetUserInfoServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(
            'getUserInfo',
            'App\Libs\GetUserInfo'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
