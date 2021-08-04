<?php

namespace GabrielChavezMe\Larafiel\Facades;

use Illuminate\Support\Facades\Facade;

class Larafiel extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'larafiel';
    }
}