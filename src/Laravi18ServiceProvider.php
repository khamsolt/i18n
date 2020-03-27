<?php

namespace Khamsolt\Laravi18;

use Illuminate\Support\ServiceProvider;
use Khamsolt\Laravi18\Contracts\Services\TranslationInterface;
use Khamsolt\Laravi18\Services\TranslationServices;

class Laravi18ServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');
    }

    public function register()
    {
        $this->app->bind(TranslationInterface::class, TranslationServices::class);
    }
}
