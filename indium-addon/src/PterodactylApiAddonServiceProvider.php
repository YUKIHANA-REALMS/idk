<?php

namespace Indium\PterodactylAddon;

use Illuminate\Support\ServiceProvider;
use Indium\PterodactylAddon\Commands\GenerateSecretKey;

class PterodactylApiAddonServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            GenerateSecretKey::class,
        ]);

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }
}
