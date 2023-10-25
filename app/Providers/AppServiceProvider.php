<?php

namespace App\Providers;

use App\Services\Interfaces\AMQPInterface;
use App\Services\Interfaces\RabbitMQInterface;
use App\Services\RabbitMQService;
use BRCas\CA\Contracts\Event\EventManagerInterface;
use Illuminate\Support\ServiceProvider;
use System\Domain\Event\EventManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(EventManagerInterface::class, EventManager::class);

        $this->app->singleton(AMQPInterface::class, RabbitMQInterface::class);
        $this->app->singleton(RabbitMQInterface::class, RabbitMQService::class);

        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
