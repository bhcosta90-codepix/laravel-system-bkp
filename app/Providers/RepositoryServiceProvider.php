<?php

namespace App\Providers;

use CodePix\System\Domain\Repository\PixKeyRepositoryInterface;
use CodePix\System\Domain\Repository\TransactionRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use System\Domain\Repository\PixKeyRepository;
use System\Domain\Repository\TransactionRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PixKeyRepositoryInterface::class, PixKeyRepository::class);
        $this->app->singleton(TransactionRepositoryInterface::class, TransactionRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
