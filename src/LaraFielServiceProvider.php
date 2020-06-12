<?php

namespace GabrielChavezMe\LaraFiel;

use Illuminate\Support\ServiceProvider;
use Mifiel\ApiClient as ApiMifiel;

class LaraFielServiceProvider extends ServiceProvider
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

        ApiMifiel::setTokens(config('larafiel.app_id'), config('larafiel.app_secret'));
       
        ApiMifiel::url(config('larafiel.mifiel_url'));

    }
}