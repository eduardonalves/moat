<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(
            'App\Interfaces\ArtistRepositoryInterface', 
            'App\Repositories\ArtistRepository'
        );
        $this->app->bind(
            'App\Interfaces\AlbumRepositoryInterface', 
            'App\Repositories\AlbumRepository'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
