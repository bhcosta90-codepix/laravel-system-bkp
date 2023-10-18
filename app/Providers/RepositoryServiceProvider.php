<?php

namespace App\Providers;

use CodePix\System\Domain\Repository\PixKeyRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use System\Domain\Repository\PixKeyRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PixKeyRepositoryInterface::class, PixKeyRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
