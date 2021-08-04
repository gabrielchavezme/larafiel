<?php

namespace GabrielChavezMe\Larafiel\Providers;

use GabrielChavezMe\Larafiel\ApiClient;
use Illuminate\Support\ServiceProvider;

class LarafielServiceProvider extends ServiceProvider
{ 

    public function register()
    {
        $this->registerMifiel();
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/larafiel.php' => config_path('larafiel.php'),
        ], 'config');
    }

    public function registerMifiel()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/larafiel.php', 'larafiel');

    }
}