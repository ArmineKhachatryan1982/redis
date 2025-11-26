<?php

namespace App\Providers;

use App\Interfaces\CryptoPriceRepositoryInterface;
use App\Repositories\CryptoPriceRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
         $this->app->bind(CryptoPriceRepositoryInterface::class, CryptoPriceRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
