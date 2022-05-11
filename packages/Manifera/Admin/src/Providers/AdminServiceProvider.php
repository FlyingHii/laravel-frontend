<?php

namespace Manifera\Admin\Providers;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'admin');
        $this->loadViewsFrom(__DIR__ . '/../resources/view', 'admin');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {

    }
}
